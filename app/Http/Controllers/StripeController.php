<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $user = auth()->user();

        if (! $user->deliveryInfo) {
            return response()->json(['error' => 'Adresse de livraison manquante.'], 422);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $cartItems = $request->input('cartItems');
        if (! is_array($cartItems) || $cartItems === []) {
            return response()->json(['error' => 'Panier vide.'], 422);
        }

        session(['cartItems' => $cartItems]);

        $lineItems = [];
        foreach ($cartItems as $item) {
            if (! isset($item['name'], $item['price'], $item['quantity'])) {
                return response()->json(['error' => 'Données du produit incorrectes.'], 400);
            }

            $productData = [
                'name' => $item['name'],
                'description' => isset($item['description']) ? \Illuminate\Support\Str::limit($item['description'], 500) : 'Aucune description',
            ];
            $image = $item['image'] ?? '';
            if (is_string($image) && str_starts_with($image, 'https://')) {
                $productData['images'] = [$image];
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => $productData,
                    'unit_amount' => (int) round((float) $item['price'] * 100),
                ],
                'quantity' => (int) $item['quantity'],
            ];
        }

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel', [], true),
            ]);

            Cache::put(
                'stripe.checkout.'.$session->id,
                [
                    'user_id' => $user->id,
                    'cartItems' => $cartItems,
                    'delivery_info_id' => $user->deliveryInfo->id,
                ],
                now()->addHours(72)
            );

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $user = auth()->user();

        $sessionId = $request->query('session_id');
        if (is_string($sessionId) && $sessionId !== '') {
            return $this->successFromCheckoutSession($user, $sessionId);
        }

        return $this->successFromSessionOnly($user);
    }

    /**
     * Retour Stripe avec ?session_id=… : idempotent (rechargement de page sans nouvelle commande).
     */
    protected function successFromCheckoutSession($user, string $sessionId): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $existing = Order::query()->where('stripe_checkout_session_id', $sessionId)->first();
        if ($existing !== null) {
            if ((int) $existing->user_id !== (int) $user->id) {
                abort(403);
            }

            return $this->successViewResponse($existing->order_number);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $stripeSession = Session::retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect()->route('front.cart')->with('error', 'Session de paiement introuvable ou invalide.');
        }

        if ($stripeSession->payment_status !== 'paid') {
            return redirect()->route('front.cart')->with('error', 'Le paiement n’a pas été confirmé.');
        }

        $cacheKey = 'stripe.checkout.'.$sessionId;
        $cached = Cache::get($cacheKey);

        if (! is_array($cached) || empty($cached['cartItems'])) {
            return redirect()->route('client.orders')->with('error', 'Cette commande a déjà été enregistrée ou les données ont expiré. Vérifiez la liste de vos commandes.');
        }

        if ((int) ($cached['user_id'] ?? 0) !== (int) $user->id) {
            abort(403);
        }

        $deliveryInfo = $user->deliveryInfo;
        if (! $deliveryInfo) {
            return redirect()->route('delivery.create')->with('error', 'Adresse de livraison requise.');
        }

        $cartItems = $cached['cartItems'];

        try {
            return DB::transaction(function () use ($user, $sessionId, $cartItems, $deliveryInfo, $cacheKey) {
                $dup = Order::query()
                    ->where('stripe_checkout_session_id', $sessionId)
                    ->lockForUpdate()
                    ->first();

                if ($dup !== null) {
                    Cache::forget($cacheKey);
                    session()->forget('cartItems');

                    return $this->successViewResponse($dup->order_number);
                }

                $total = collect($cartItems)->sum(fn ($item) => $item['price'] * $item['quantity']);
                $orderNumber = strtoupper(Str::random(10));

                Order::create([
                    'user_id' => $user->id,
                    'status' => 'paid',
                    'total' => $total,
                    'items' => json_encode($cartItems),
                    'order_number' => $orderNumber,
                    'stripe_checkout_session_id' => $sessionId,
                    'delivery_info_id' => $deliveryInfo->id,
                ]);

                Cart::query()->where('user_id', $user->id)->delete();
                Cache::forget($cacheKey);
                session()->forget('cartItems');

                return $this->successViewResponse($orderNumber);
            });
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'Duplicate') || ($e->errorInfo[1] ?? null) === 1062) {
                $order = Order::query()->where('stripe_checkout_session_id', $sessionId)->first();
                if ($order !== null && (int) $order->user_id === (int) $user->id) {
                    Cache::forget($cacheKey);
                    session()->forget('cartItems');

                    return $this->successViewResponse($order->order_number);
                }
            }
            throw $e;
        }
    }

    /**
     * Ancienne URL /checkout-success sans session_id (rétrocompatibilité).
     */
    protected function successFromSessionOnly($user): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $deliveryInfo = $user->deliveryInfo;
        $cartItems = session('cartItems', []);

        if ($cartItems === []) {
            return redirect()->route('front.cart')->with('error', 'Le panier est vide.');
        }

        if (! $deliveryInfo) {
            return redirect()->route('delivery.create')->with('error', 'Veuillez ajouter vos informations de livraison.');
        }

        $total = collect($cartItems)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $orderNumber = strtoupper(Str::random(10));

        Order::create([
            'user_id' => $user->id,
            'status' => 'paid',
            'total' => $total,
            'items' => json_encode($cartItems),
            'order_number' => $orderNumber,
            'delivery_info_id' => $deliveryInfo->id,
        ]);

        Cart::query()->where('user_id', $user->id)->delete();
        session()->forget('cartItems');

        return $this->successViewResponse($orderNumber);
    }

    protected function successViewResponse(string $orderNumber): \Illuminate\Contracts\View\View
    {
        return view('checkout.success')->with('success', [
            'success' => 'Commande enregistrée avec succès.',
            'orderNumber' => $orderNumber,
        ]);
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}

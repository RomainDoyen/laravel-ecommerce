<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use Illuminate\Support\Str;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $user = auth()->user();

        // Vérifiez si l'utilisateur a renseigné ses informations de livraison
        // $deliveryInfo = $user->deliveryInfo;

        // if (!$deliveryInfo) {
        //     return redirect()->route('delivery.create')->with('error', 'Veuillez ajouter vos informations de livraison avant de passer à la caisse.');
        // }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];
        $cartItems = $request->input('cartItems');

        session(['cartItems' => $cartItems]);

        foreach ($cartItems as $item) {
            if (!isset($item['name'], $item['price'], $item['quantity'])) {
                return response()->json(['error' => 'Données du produit incorrectes.'], 400);
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'],
                        'description' => $item['description'] ?? 'Aucune description',
                        'images' => [$item['image'] ?? 'https://via.placeholder.com/150'],
                    ],
                    'unit_amount' => (int)($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success'),
                'cancel_url' => route('checkout.cancel'),
            ]);

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $user = auth()->user();

        $deliveryInfo = $user->deliveryInfo;

        $cartItems = session('cartItems', []);

        if (empty($cartItems)) {
            return redirect()->route('front.cart')->with('error', 'Le panier est vide.');
        }        

        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        $orderNumber = strtoupper(Str::random(10));

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'paid',
            'total' => $total,
            'items' => json_encode($cartItems),
            'order_number' => $orderNumber,
            'delivery_info_id' => $deliveryInfo->id,
        ]);

        session()->forget('cartItems');

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

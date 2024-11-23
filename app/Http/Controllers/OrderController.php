<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('client.login')->with('error', 'Veuillez vous connecter pour accéder à vos commandes.');
        }

        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->get();

        return view('client.orders', compact('orders'));
    }

    public function storeOrder(Request $request)
    {
        $user = auth()->user();
        $cartItems = $request->input('cartItems');
        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'paid',
            'total' => $total,
            'items' => json_encode($cartItems),
        ]);

        // Vider le panier après paiement 
        // ...

        return redirect()->route('client.orders')->with('success', 'Commande passée avec succès.');
    }
}

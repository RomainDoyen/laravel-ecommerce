<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller {

    public function addToCart(Request $request, $produitId) {
        if (!Auth::check()) {
            return redirect()->route('client.login')->with('error_cart', 'Vous devez être connecté pour ajouter un produit au panier.');
        }

        $produit = Produit::findOrFail($produitId);

        $cart = Cart::where('user_id', Auth::id())->where('produit_id', $produitId)->first();

        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'produit_id' => $produitId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success_cart', 'Produit ajouté au panier.');
    }

    public function showCart() {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir votre panier.');
        }

        $carts = Cart::with('produit')->where('user_id', Auth::id())->get();

        $total = $carts->sum(function ($cart) {
            return $cart->produit->prix * $cart->quantity;
        });

        return view('cart.index', compact('carts', 'total'));
    }

    public function incrementQuantity($produitId) {
        if (!Auth::check()) {
            return redirect()->route('client.login')->with('error_cart', 'Vous devez être connecté.');
        }
    
        $cart = Cart::where('user_id', Auth::id())->where('produit_id', $produitId)->first();
    
        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        }
    
        return redirect()->route('front.cart')->with('success_cart', 'Quantité augmentée.');
    }
    
    public function decrementQuantity($produitId) {
        if (!Auth::check()) {
            return redirect()->route('client.login')->with('error_cart', 'Vous devez être connecté.');
        }
    
        $cart = Cart::where('user_id', Auth::id())->where('produit_id', $produitId)->first();
    
        if ($cart) {
            if ($cart->quantity > 1) {
                $cart->quantity -= 1;
                $cart->save();
            } else {
                $cart->delete(); // Supprime si la quantité tombe à zéro.
            }
        }
    
        return redirect()->route('front.cart')->with('success_cart', 'Quantité diminuée.');
    }
    
    public function removeFromCart($produitId) {
        if (!Auth::check()) {
            return redirect()->route('client.login')->with('error_cart', 'Vous devez être connecté.');
        }
    
        $cart = Cart::where('user_id', Auth::id())->where('produit_id', $produitId)->first();
    
        if ($cart) {
            $cart->delete();
        }
    
        return redirect()->route('front.cart')->with('success_cart', 'Produit retiré du panier.');
    }
}

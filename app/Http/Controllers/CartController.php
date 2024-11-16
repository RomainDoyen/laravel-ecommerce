<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class CartController extends Controller
{
    public function addToCart($id) {
        $produit = Produit::find($id);

        if (!$produit) {
            return redirect()->back()->with('error', 'Produit introuvable.');
        }

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'id' => $produit->id,
                'titre' => $produit->titre,
                'description' => $produit->description,
                'prix' => $produit->prix,
                'quantity' => 1,
                'image' => $produit->image,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('front.cart')->with('success', 'Produit ajouté au panier.');
    }


    public function incrementQuantity($id) {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session(['cart' => $cart]);
        }
        return redirect()->route('front.cart');
    }
    
    public function decrementQuantity($id) {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            $cart[$id]['quantity']--;
            if ($cart[$id]['quantity'] < 1) {
                unset($cart[$id]);
            }
            session(['cart' => $cart]);
        }
        return redirect()->route('front.cart');
    }

    public function removeFromCart($id) {

        // session()->forget('cart');
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return redirect()->route('front.cart');
    }
}

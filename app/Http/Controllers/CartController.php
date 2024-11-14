<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class CartController extends Controller
{
    public function addToCart($id) {

        $produit = Produit::find($id);

        session(['cart' => $produit]);

        return redirect()->route('front.cart');
    }

    public function removeFromCart($id) {

        session()->forget('cart');

        return redirect()->route('front.cart');
    }
}

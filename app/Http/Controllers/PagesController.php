<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return view('front.index', compact('produits'));
    }

    public function shop()
    {
        $produits = Produit::all();
        return view('front.shop', compact('produits'));
    }

    public function about()
    {
        return view('front.about');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function cart()
    {
        $carts = Cart::where('user_id', Auth::id())->get();
        $total = $carts->sum(function ($cart) {
            if ($cart->produit->promotion && $cart->produit->prix_promotionnel) {
                return $cart->produit->prix_promotionnel * $cart->quantity;
            } else {
                return $cart->produit->prix * $cart->quantity;
            }
            // return $cart->produit->prix * $cart->quantity;
        });
        return view('front.cart', compact('carts', 'total'));
    }

    public function details($id)
    {
        $produit = Produit::find($id);
        // produit similaire
        $produits_similaires = Produit::where('category_id', $produit->category->id)->where('id', '!=', $produit->id)->distinct()->get();
        return view('front.details', compact('produit', 'produits_similaires'));
    }
}

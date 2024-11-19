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
        return view('front.cart', compact('carts'));
    }

    public function details($id)
    {
        $produit = Produit::find($id);
        return view('front.details', compact('produit'));
    }
}

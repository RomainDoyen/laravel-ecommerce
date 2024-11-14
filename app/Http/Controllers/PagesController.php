<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

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
        return view('front.cart');
    }
}

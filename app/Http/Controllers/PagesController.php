<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        // $carts = Cart::where('user_id', Auth::id())->get();
        $carts = Cart::with('produit')->where('user_id', Auth::id())->get();

        $total = $carts->sum(function ($cart) {
            $prix = $cart->produit->promotion && $cart->produit->prix_promotionnel
                ? $cart->produit->prix_promotionnel
                : $cart->produit->prix;
        
            return $prix > 0 ? $prix * $cart->quantity : 0;
        });

        $cartItems = $carts->map(function ($cart) {
            return [
                'name' => $cart->produit->titre,
                'price' => $cart->produit->promotion && $cart->produit->prix_promotionnel
                    ? $cart->produit->prix_promotionnel
                    : $cart->produit->prix,
                'quantity' => $cart->quantity,
                'description' => $cart->produit->description,
                'image' => strpos($cart->produit->image, 'products/') === 0
                    ? url(Storage::url($cart->produit->image))
                    : url(asset($cart->produit->image)),
            ];
        })->toArray();

        return view('front.cart', compact('carts', 'total', 'cartItems'));
    }

    public function details($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return redirect()->route('front.shop')->with('error', 'Produit non trouvé.');
        }

        if ($produit->category) {
            $produits_similaires = Produit::where('category_id', $produit->category->id)
                                        ->where('id', '!=', $produit->id)
                                        ->distinct()
                                        ->get();
        } else {
            $produits_similaires = [];
        }
        return view('front.details', compact('produit', 'produits_similaires'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $produits = Produit::where('titre', 'LIKE', "%{$query}%")
                           ->orWhere('description', 'LIKE', "%{$query}%")
                           ->orWhere('prix', 'LIKE', "%{$query}%")
                           ->get();

        return view('front.search', compact('produits', 'query'));
    }
}

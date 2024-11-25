<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Order;
use App\Models\DeliveryInfo;

class AdminController extends Controller
{

    public function login() {
        return view('admin.login');
    }

    public function add() {
        $categories = Category::all();
        return view('admin.add', compact('categories'));
    }

    public function edit($id) {
        $product = Produit::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit', compact('product', 'categories'));
    }

    public function login_post(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirection en fonction du rôle
            if (Auth::user()->role_id === 1) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('client.login')->with('error', 'Vous n\'avez pas accès à cette section.');
            }
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas.',
        ])->onlyInput('email');
    }


    public function dashboard() {
        // Vérifie si l'utilisateur est connecté et a le rôle d'administrateur
        if (!Auth::check() || Auth::user()->role_id !== 1) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Accès interdit. Connectez-vous en tant qu\'administrateur.']);
        }

        $produits = Produit::all();
        $categories = Category::all();
        $orders = Order::with('user')->get();
        return view('admin.dashboard', compact('produits', 'categories', 'orders'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('admin.login');
    }

    public function addProduct(Request $request){

        // Vérifie si l'utilisateur est connecté et a le rôle d'administrateur
        if (!Auth::check() || Auth::user()->role_id !== 1) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Accès interdit. Connectez-vous en tant qu\'administrateur.']);
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'prix_promotionnel' => 'nullable|numeric|min:0|lt:prix',
            'quantity' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'promotion' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Sauvegarde de l'image
        $imagePath = $request->file('image')->store('products', 'public');

        // Création du produit
        Produit::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'prix' => $validated['prix'],
            'prix_promotionnel' => $validated['prix_promotionnel'],
            'quantity' => $validated['quantity'],
            'image' => $imagePath,
            'promotion' => $validated['promotion'],
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Produit ajouté avec succès.');
    }

    public function updateProduct(Request $request, $id)
    {

        if (!Auth::check() || Auth::user()->role_id !== 1) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Accès interdit. Connectez-vous en tant qu\'administrateur.']);
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'prix_promotionnel' => 'nullable|numeric|min:0|lt:prix',
            'quantity' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'promotion' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $product = Produit::findOrFail($id);

        $product->titre = $validated['titre'];
        $product->description = $validated['description'];
        $product->prix = $validated['prix'];
        $product->prix_promotionnel = $validated['prix_promotionnel'];
        $product->quantity = $validated['quantity'];
        $product->promotion = $validated['promotion'];
        $product->category_id = $validated['category_id'];

        if ($request->hasFile('image')) {
            // Suppression de l'ancienne image
            Storage::disk('public')->delete($product->image);

            // Sauvegarde de la nouvelle image
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.dashboard')->with('success', 'Produit modifié avec succès.');
    }

    public function deleteProduct($id){

        if (!Auth::check() || Auth::user()->role_id !== 1) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Accès interdit. Connectez-vous en tant qu\'administrateur.']);
        }

        $product = Produit::findOrFail($id);

        // Suppression de l'image
        Storage::disk('public')->delete($product->image);

        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Produit supprimé avec succès.');
    }
}

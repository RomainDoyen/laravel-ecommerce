<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
{
    public function login()
    {
        return view('client.login');
    }

    public function register()
    {
        return view('client.register');
    }

    public function register_post(Request $request) {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:4',
        ]);

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = 2;
        $user->save();

        // return redirect()->route('client.login');
        return back()->with('status', 'Votre inscription a bien été effectué.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    public function login_post(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirection en fonction du rôle
            if (Auth::user()->role_id !== 1) {
                return redirect()->route('client.myspace');
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'Vous n\'avez pas accès à cette section.');
            }
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas.',
        ])->onlyInput('email');
    }


    public function myspace(Request $request) {
        // if (Auth::user()) {
        //     return view('client.dashboard');
        // } else {
        //     return redirect()->route('client.login');
        // }

        if ($request->session()->get('user')) {
            return redirect()->route('client.login');
        }
    
        return view('client.myspace');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('client.login');
    }
}

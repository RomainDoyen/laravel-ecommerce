<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryInfo;
use Illuminate\Support\Facades\Auth;

class DeliveryInfoController extends Controller
{
    public function create()
    {
        return view('delivery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        DeliveryInfo::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->only('address', 'postal_code', 'city', 'phone', 'country')
        );

        return redirect()->route('delivery.create')->with('success', 'Informations de livraison enregistrées avec succès.');
    }


}

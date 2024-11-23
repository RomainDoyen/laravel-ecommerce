<?php

namespace App\Models;
use App\Models\Produit;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'produit_id', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}

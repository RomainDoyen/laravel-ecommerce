<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'titre', 
        'description',
        'prix',
        'prix_promotionnel',
        'image',
        'quantity',
        'promotion',
    ];
}

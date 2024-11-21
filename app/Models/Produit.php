<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

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
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

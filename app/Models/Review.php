<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produit;
use App\Models\User;
use App\Models\Review;

class Review extends Model
{
    protected $fillable = ['produit_id', 'user_id', 'rating', 'review'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

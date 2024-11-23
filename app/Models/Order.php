<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total', 'items'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryInfo extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'postal_code',
        'city',
        'phone',
        'country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

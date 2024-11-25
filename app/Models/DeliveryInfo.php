<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;

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

    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_info_id');
    }
}

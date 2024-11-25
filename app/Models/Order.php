<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DeliveryInfo;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total', 'items', 'order_number', 'payment_method', 'delivery_info_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryInfo()
    {
        return $this->belongsTo(DeliveryInfo::class, 'delivery_info_id');
    }
}

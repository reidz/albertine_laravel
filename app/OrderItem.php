<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function scopeGetByOrderId($query, $orderId)
	{
		return $query->where('order_id', $orderId);
	}
}

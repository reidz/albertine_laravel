<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function scopeGetByStatus($query, $status)
	{
		return $query->where('status', $status);
	}
}

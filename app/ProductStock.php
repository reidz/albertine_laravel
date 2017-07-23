<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function size()
    {
        return $this->belongsTo('App\Size');
    }

    public function scopeProductId($query, $product_id)
	{
		return $query->where('product_id', $product_id);
	}
}

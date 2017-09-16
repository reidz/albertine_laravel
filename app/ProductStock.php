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

    public function scopeSizeId($query, $size_id)
    {
        return $query->where('size_id', $size_id);
    }

	public function getStockAvailableAttribute()
    {
        return $this->attributes['stock'] - $this->attributes['stock_sold'] - $this->attributes['stock_holding'];
    }
}

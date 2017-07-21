<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function scopeGetByCategory($query, $category_id)
    {
        return $query->where('category_id', $category_id);
    }

    public function assetAssignments()
    {
    	return $this->morphMany('App\AssetAssignments', 'assignment');
    }

    public function scopeReadyStock($query)
	{
		return $query->where('status', 'READY_STOCK');
	}

	public function scopeIsFeatured($query)
	{
		return $query->where('is_featured', 1);
	}
}

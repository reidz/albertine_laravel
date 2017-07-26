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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function getStockAvailableAttribute()
    {
        return $this->attributes['stock'] - $this->attributes['stock_sold'] - $this->attributes['stock_holding'];
    }

    public function scopeGetByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeGetByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeGetByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeGetByCategoryIdNotIn($query, $categoryIds)
    {
        return $query->whereNotIn('category_id', $categoryIds);
    }
}

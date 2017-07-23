<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public function scopeGetByIsActive($query, $isActive)
	{
		return $query->where('is_active', $isActive);
	}

	public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}

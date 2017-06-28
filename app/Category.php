<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public function scopeGetByIsActive($query, $isActive)
	{
		return $query->where('is_active', $isActive)->get();
	}
}

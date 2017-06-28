<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
	// if found, return true (already exist)
    public function scopeCheckExist($query, $sizeMetric, $sizeValue)
	{
		$result = $query->where('size_metric', $sizeMetric)
					->where('size_value', $sizeValue);
		return $result->first();
	}
}

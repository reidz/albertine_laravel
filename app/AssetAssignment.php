<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
	'product' => 'App\Product',
]);

class AssetAssignment extends Model
{
    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function assignment()
    {
    	return $this->morphTo();
    }

    public function scopeAssignmentId($query, $assignment_id)
	{
		return $query->where('assignment_id', $assignment_id);
	}

    public function scopeIsMain($query)
    {
        return $query->where('weight', 0)->take(1);
    }

}

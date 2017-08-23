<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeIsMain($query)
    {
        return $query->where('is_active', 1)->take(1);
    }
}

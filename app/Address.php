<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subdistrict()
    {
        return $this->belongsTo('App\Subdistrict');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    public function scopeIsMain($query)
    {
        return $query->where('is_active', 1)->take(1);
    }
}

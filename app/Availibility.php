<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Availibility extends Model
{
    //
    public function store()
    {
        return $this->belongsTo('App\Store');
    }
    public function position()
    {
        return $this->belongsTo('App\Position');
    }
    public function prices()
    {
        return $this->hasMany('App\Price');
    }
}

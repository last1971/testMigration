<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function firm()
    {
        return $this->belongsTo('App\Firm');
    }
    public  function availibilities()
    {
        return $this->hasMany('App\Availibility');
    }
}

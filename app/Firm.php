<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    //
    public function name()
    {
        return $this->belongsTo('App\Name');
    }
    public function stores()
    {
        return $this->hasMany('App\Store');
    }
    public function positions()
    {
        return $this->hasMany('App\Position');
    }
}

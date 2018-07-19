<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    public function name()
    {
        return $this->belongsTo('App\Name');
    }
    public function firm()
    {
        return $this->belongsTo('App\Firm');
    }
    public  function availibilities()
    {
        return $this->hasMany('App\Avalibility');
    }
}

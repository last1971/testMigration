<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    //
    public function name()
    {
        return $this->belongsTo('App\Name');
    }
    public function picture()
    {
        return $this->belongsTo('App\Picture');
    }
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
    public function pictures()
    {
        return $this->belongsToMany('App\Picture')->as('pictures');
    }
    public function  products()
    {
        return $this->hasMany('App\Product');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    //
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
    public function someCases()
    {
        return $this->hasMany('App\SomeCase');
    }
    public function  producers()
    {
        return $this->hasMany('App\Producer');
    }
    public function  products()
    {
        return $this->hasMany('App\Product');
    }
    public function  categories()
    {
        return $this->hasMany('App\Category');
    }
    public function firms(){
        return $this->hasMany('App\Firm');
    }
    public function stores()
    {
        return $this->hasMany('App\Store');
    }
}

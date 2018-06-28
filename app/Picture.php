<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    //
    protected $fillable = ['path'];

    public function someCases()
    {
        return $this->hasMany('App\SomeCase');
    }
    public function Cases()
    {
        return $this->belongsToMany('App\SomeCase');
    }
    public function someProducers()
    {
        return $this->hasMany('App\Producer');
    }
    public function Producers()
    {
        return $this->belongsToMany('App\Producer');
    }
    public function  someProducts()
    {
        return $this->hasMany('App\Product');
    }
    public function Products()
    {
        return $this->belongsToMany('App\Product');
    }
}

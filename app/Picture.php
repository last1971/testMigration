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
}

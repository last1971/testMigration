<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
    public function producer()
    {
        return $this->belongsTo('App\Producer');
    }
    public function someCase()
    {
        return $this->belongsTo('App\SomeCase');
    }
    public function pictures()
    {
        return $this->belongsToMany('App\Picture')->as('pictures');
    }
}

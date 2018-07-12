<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function name()
    {
        return $this->belongsTo('App\Name');
    }
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
    public function picture()
    {
        return $this->belongsTo('App\Picture');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    //
    public function availibility()
    {
        return $this->belongsTo('App\Availibility');
    }
    public function valute()
    {
        return $this->belongsTo('App\Valute');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    //
    public function valute()
    {
        return $this->belongsTo('App\Valute');
    }
}

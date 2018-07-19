<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valute extends Model
{
    //
    public  function exchangeRates()
    {
        return $this->hasMany('App\ExchangeRate');
    }
    public function prices()
    {
        return $this->hasMany('App\Price');
    }
    public function curse()
    {
        return $this->exchangeRates()->orderByDesc('updated_at')->first();
    }
}

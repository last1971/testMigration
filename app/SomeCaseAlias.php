<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SomeCaseAlias extends Model
{
    //
    public function master_case()
    {
        return $this->belongsTo('App\SomeCase','some_case_aliases_master_id_foreign');
    }
    public function some_case()
    {
        return $this->belongsTo('App\SomeCase');
    }
}

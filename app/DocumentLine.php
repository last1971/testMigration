<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentLine extends Model
{
    //
    public function document()
    {
        return $this->belongsTo('App\Document');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

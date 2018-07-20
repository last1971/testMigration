<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    //
    public function documentes()
    {
        return $this->hasMany('App\Document');
    }
}

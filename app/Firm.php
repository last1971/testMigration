<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    //
    public function name()
    {
        return $this->belongsTo('App\Name');
    }
    public function stores()
    {
        return $this->hasMany('App\Store');
    }
    public function positions()
    {
        return $this->hasMany('App\Position');
    }
    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function incomingDocumentes()
    {
        return $this->hasMany('App\Firm','documents_buyer_id_foreign');
    }
}

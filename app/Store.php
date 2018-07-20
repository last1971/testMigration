<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    public function name()
    {
        return $this->belongsTo('App\Name');
    }
    public function firm()
    {
        return $this->belongsTo('App\Firm');
    }
    public  function availibilities()
    {
        return $this->hasMany('App\Avalibility');
    }
    public function documents()
    {
        return $this->hasMany('App\Document');
    }
    public function  incomingDocuments()
    {
        return $this->hasMany('App\Document','documents_to_id_foreign');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Marquine\EloquentUuid\Uuid;

class Document extends Model
{
    //
    use Uuid;

    public function documentType()
    {
        return $this->belongsTo('App\DocumentType');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    public  function to()
    {
        return $this->belongsTo('App\Store','documents_to_id_foreign');
    }

    public function documentLines()
    {
        return $this->hasMany('App\DocumentLine');
    }

    public  function exchangeRate()
    {
        return $this->belongsTo('App\ExchangeRate');
    }
}

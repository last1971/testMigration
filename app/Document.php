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

    public function firm()
    {
        return $this->belongsTo('App\Firm');
    }

    public  function buyer()
    {
        return $this->belongsTo('App\Firm','documents_buyer_id_foreign');
    }

    public function store()
    {
        return $this->belongsTo('App\Firm');
    }

    public  function to()
    {
        return $this->belongsTo('App\Firm','documents_to_id_foreign');
    }
}

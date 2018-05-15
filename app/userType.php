<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userType extends Model
{
    //
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public static function toSelect()
    {
        $ret = array();
        foreach (userType::all() as $type)
        {
            $ret[$type->id] = $type->name;
        }
        return $ret;
    }
}

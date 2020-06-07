<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function incidences()
    {
        return $this->hasMany('App\Incidence');
    }
}

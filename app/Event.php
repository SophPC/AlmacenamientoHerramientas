<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function tools()
    {
        return $this->belongsToMany('App\Tool')->using('App\EventTool');
    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    public function incidences()
    {
        return $this->hasMany('App\Incidence');
    }
}

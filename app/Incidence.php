<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function tools()
    {
        return $this->belongsTo('App\Tool');
    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }
}

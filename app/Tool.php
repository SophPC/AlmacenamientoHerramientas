<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{

    protected $guarded = [];

    // protected $primaryKey = 'num';
    public $incrementing = false;
    protected $keyType = 'string';

    public function events()
    {
        return $this->belongsToMany('App\Event')->using('App\EventTool');
    }
    
    public function incidences()
    {
        return $this->hasMany('App\Incidence');
    }
}

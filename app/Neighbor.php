<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neighbor extends Model
{
    protected $table='neighbors';
    public $timestamps = false;

    public function stores(){
        return $this->hasMany('App\Store','neighbor_id');
    }

    public function regions(){
        return $this->belongsTo('App\Region','region');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected  $table='regions';

    public $timestamps = false;
    public function stores(){
        return $this->hasMany('App\Store','region_id');
    }
    public function s_orders(){
        return $this->hasMany('App\Order','s_region');
    }

    public function r_orders(){
        return $this->hasMany('App\Order','r_region');
    }


    public function agents(){
        return $this->belongsToMany('App\Agent','agent_region','region_id','agent_id');
    }
}

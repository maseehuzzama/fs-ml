<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table ='cities';

    public function stores(){
        return $this->hasMany('App\Store','city');
    }

    public function s_orders(){
        return $this->hasMany('App\Order','s_sity');
    }

    public function r_orders(){
        return $this->hasMany('App\Order','r_sity');
    }

    public function admins(){
        return $this->belongsToMany('App\Admin', 'admin_city', 'city_id', 'admin_id');
    }
}

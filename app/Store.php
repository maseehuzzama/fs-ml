<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table ='stores';
    public $timestamps = false;


    public function regions(){
        return $this->belongsTo('App\Region','region_id');
    }

    public function cities(){
        return $this->belongsTo('App\City','city');
    }

    public function neighbors(){
        return $this->belongsTo('App\Neighbor','neighbor_id');
    }
}

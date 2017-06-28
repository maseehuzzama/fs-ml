<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table ='orders';


    public function packings(){
        return $this->belongsTo('App\Packing','packing_id');
    }

    public function photos(){
        return $this->belongsTo('App\PhotoGraphy','photo_id');
    }

    public function status(){
        return $this->belongsTo('App\Status','status_id');
    }

    public function s_cities(){
        return $this->belongsTo('App\City','s_city');
    }

    public function r_cities(){
        return $this->belongsTo('App\City','r_city');
    }
    public function s_regions(){
        return $this->belongsTo('App\Region','s_region');
    }

    public function r_regions(){
        return $this->belongsTo('App\Region','r_region');
    }

    public function s_neighbors(){
        return $this->belongsTo('App\Neighbor','s_neighbor_id');
    }

    public function r_neighbors(){
        return $this->belongsTo('App\Neighbor','r_neighbor_id');
    }

    public function photo_order(){
        return $this->belongsTo('App\PhotoOrder','photo_reference','ref_number');
    }


    public function payment_mode(){
        return $this->belongsTo('App\PaymentMode','payment_id','id');

    }

    public function statuses(){
        return $this->belongsTo('App\Status','status','name');
    }


}

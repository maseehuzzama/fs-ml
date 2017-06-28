<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoOrder extends Model
{
    protected  $table = 'photo_orders';

    public function order(){
        return $this->belongsTo('App\Order','photo_reference');
    }
}

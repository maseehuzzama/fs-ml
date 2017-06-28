<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    protected $table = 'packings';

    public $timestamps = false;

    public function orders(){
        return $this->hasMany('App\Order','packing_id');
    }

    public function colors(){
        return $this->belongsToMany('App\Color', 'packing_color','packing_id','color_id');
    }
}

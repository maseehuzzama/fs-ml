<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function packings(){
        return $this->belongsToMany('App\Packing','packing_color','color_id','packing_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoGraphy extends Model
{
    protected $table = 'photography';

    public function orders(){
        return $this->hasMany('App\Order','photo_id');
    }
}

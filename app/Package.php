<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    public $timestamps = false;

    public function  p_rs(){
        return $this->hasMany('App\PackageRequest','package_code');
    }

    public function insideAccounts(){
        return $this->hasMany('App\Account','package_inside');
    }
    public function outsideAccounts(){
        return $this->hasMany('App\Account','package_outside');
    }
}

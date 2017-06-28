<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Account extends Model
{
    protected $table = 'accounts';

    public function insidePackages()
    {
        return $this->belongsTo('App\Package', 'package_inside');
    }
    public function outsidePackages()
    {
        return $this->belongsTo('App\Package', 'package_outside');
    }


    public function outValid($dateValid){
        if($dateValid < date('Y-m-d')){
            return $outValid = 0;
        }
        else{
            return $outValid = Carbon::today()->diffInDays(new Carbon($dateValid));
        }
    }
    public function inValid($dateValid){
        if($dateValid < date('Y-m-d')){
            return $inValid = 0;
        }
        else{
            return $inValid = Carbon::today()->diffInDays(new Carbon($dateValid));
        }
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageRequest extends Model
{
    protected $table ='package_requests';

    public function packages(){
        return $this->belongsTo('App\Package','package_code');
    }

    public function users(){
        return $this->belongsTo('App\User','user_id');
    }

}

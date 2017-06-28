<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected  $table = 'services';

    protected $fillable = [
        'service_name','service_name_ar','service_description','service_description_ar','service_number','keywords', 'service_image','service_icon',
    ];

}

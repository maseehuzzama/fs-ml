<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected  $table = 'roles';

    public function admins()
    {
        return $this->belongsToMany('App\Admin', 'admin_role', 'role_id', 'admin_id');
    }
}

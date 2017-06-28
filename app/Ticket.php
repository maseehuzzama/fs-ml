<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'ticket_id','user_id', 'category_id', 'title', 'priority','reference','service_type', 'message', 'status','stage'
    ];

    public function Category(){
        return $this->belongsTo('App\TicketCategory','category_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}

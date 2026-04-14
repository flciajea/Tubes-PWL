<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    protected $table = 'waiting_lists';

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'ticket_type_id',
        'status'
    ];

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
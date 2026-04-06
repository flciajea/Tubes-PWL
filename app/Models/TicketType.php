<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $table = 'ticket_types';

    protected $fillable = [
        'event_id',
        'name',
        'price',
        'quota',
        'remaining_quota'
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi ke Order Items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke Waiting List
    public function waitingLists()
    {
        return $this->hasMany(WaitingList::class);
    }
}
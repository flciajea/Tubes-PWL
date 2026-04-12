<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    // Disable timestamps karena tabel order_items tidak memiliki created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'ticket_type_id',
        'quantity',
        'price',
        'subtotal',
    ];

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke TicketType
    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}

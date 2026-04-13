<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'user_id',
        'order_item_id',
        'ticket_code',
        'qr_code',
        'status',
        'checkin_time'
    ];

    // karena hanya ada created_at
    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke order item
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | QR CODE LOGIC
    |--------------------------------------------------------------------------
    */

    // generate isi QR (link checkin)
    public function generateQr()
    {
        return url('/checkin/' . $this->ticket_code);
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE SAAT CREATE
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($t) {

            // generate ticket code kalau kosong
            if (!$t->ticket_code) {
                $t->ticket_code = 'TKT' . rand(10000, 99999);
            }

            // generate QR otomatis
            $t->qr_code = url('/checkin/' . $t->ticket_code);

            // default status
            if (!$t->status) {
                $t->status = 'active';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER FUNCTION
    |--------------------------------------------------------------------------
    */

    // cek apakah sudah dipakai
    public function isUsed()
    {
        return $this->status === 'used';
    }

    // check-in tiket
    public function checkin()
    {
        if ($this->status === 'used') {
            return false;
        }

        $this->status = 'used';
        $this->checkin_time = now();
        $this->save();

        return true;
    }
}
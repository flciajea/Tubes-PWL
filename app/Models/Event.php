<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'organizer_id',
        'category_id',
        'title',
        'description',
        'banner',
        'event_date',
        'location',
        'total_quota',
        'status'
    ];

    // Relasi ke Organizer (User)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
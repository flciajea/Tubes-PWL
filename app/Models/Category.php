<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    // relasi ke event (1 category punya banyak event)
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
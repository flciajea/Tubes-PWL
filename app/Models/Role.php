<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // nama tabel (opsional karena sudah plural)
    protected $table = 'roles';

    // kolom yang boleh diisi
    protected $fillable = [
        'name'
    ];

    // ======================
    // RELATIONSHIP
    // ======================

    // 1 role punya banyak user
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
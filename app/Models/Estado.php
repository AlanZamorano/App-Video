<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estado';

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    // public function user()
    // {
    //     return $this->hasMany(User::class);
    // }
}

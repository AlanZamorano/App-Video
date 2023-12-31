<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function video(){
        return $this->belongsTo(Video::class, 'video_id');
    }

}

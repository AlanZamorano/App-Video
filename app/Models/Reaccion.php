<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaccion extends Model
{
    use HasFactory;

    protected $table = 'reaccion';

    public function user(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function video(){
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function tipoReaccion(){
        return $this->belongsTo(TipoReaccion::class, 'tipo_reaccion_id');
    }
}

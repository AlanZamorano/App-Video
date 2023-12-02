<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    //Relacion de tablas
    public function comentarios(){
        return $this->hasMany(Comentario::class, 'video_id')->orderBy('id', 'desc');
    }

    public function likes(){
        return $this->hasMany(Reaccion::class, 'video_id')->where('tipo_reaccion_id', 1);
    }

    // Relación con la tabla reaccion para "No me gusta"
    public function dislikes(){
        return $this->hasMany(Reaccion::class, 'video_id')->where('tipo_reaccion_id', 2);
    }

    public function usuarios(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function canal(){
        return $this->belongsTo(Canal::class, 'canal_id');
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function reacciones()
    {
        return $this->hasMany(Reaccion::class);
    }
}

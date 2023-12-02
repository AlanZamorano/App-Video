<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    
    Protected $table = 'persona';

    public function comentarios(){
        return $this->hasMany('App\Models\Comentarios');
    }
}


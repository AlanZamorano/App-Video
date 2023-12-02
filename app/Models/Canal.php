<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    use HasFactory;

    protected $table= 'canal';

    public function videos(){
        return $this->hasMany(Video::class);
    }

    public function categorias(){
        return $this->hasMany(Categoria::class);
    }
}

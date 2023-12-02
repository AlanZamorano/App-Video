<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
     */

     protected $table = 'users';
    protected $fillable = [
        'name',
        'apellido_p',
        'apellido_m',
        'telefono',
        'imagen',
        'tipo_usuario_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canal(){
        return $this->hasOne(Canal::class, 'users_id');
    }
    
    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class, 'users_id');
    }

    public function reaccionl(){
        return $this->hasOne(Reaccion::class, 'users_id');
    }
}

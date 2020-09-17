<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Recupera todas tarefas de um determiando usuário
     * @return HasMany
     */
    public function tasks()
    {
        return $this->hasMany(
            Task::class,
            'user_id',
            'id'
        );
    }

    /**
     * Recupera todos os tipos de um determinado usuário
     * @return HasMany
     */
    public function types()
    {
        return $this->hasMany(Type::class);
    }

    /**
     * @override
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @override
     * @return mixed
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

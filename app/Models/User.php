<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'phoneNumber',
        'birthDate',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token','email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function coachProgramme()
    {
        return $this->hasMany(Programme::class, 'coachId');

    }
    public function playerProgramme()
    {
        return $this->hasMany(Programme::class, 'playerId');

    }
    public function coachOrder()
    {
        return $this->hasMany(Order::class, 'coachId');

    }
    public function playerOrser()
    {
        return $this->hasMany(Order::class, 'playerId');
    }


    public function player()
    {
        return $this->hasMany(Time::class, 'playerId');

    }
    public function coach()
    {
        return $this->hasMany(Time::class, 'coachId');

    }
    public function image()
    {
        return $this->hasMany(Image::class,'userId');

    }

}


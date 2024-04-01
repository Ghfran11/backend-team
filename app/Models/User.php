<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'role',
        'rate',
        'expiration',
        'finance',
        'bio'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];
    protected $appends = ['rate', 'is_paid'];

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
    public function coachPrograms()
    {
        return $this->belongsToMany(Program::class, 'programe_users', 'user_id')->withPivot('days', 'startDate');
    }
    public function playerPrograms()
    {
        return $this->belongsToMany(Program::class, 'programe_users', 'player_id')->withPivot('days', 'startDate');
    }
    public function coachOrder()
    {
        return $this->hasMany(Order::class, 'coachId')->where('status','waiting');
    }
    public function playerOrder()
    {
        return $this->hasMany(Order::class, 'playerId');
    }

    public function time()
    {
        return $this->hasMany(Time::class, 'userId');
    }

    public function image()
    {
        return $this->hasMany(Image::class, 'userId')->where('type', 'profile');
    }
    // public function profileImage()
    // {
    //     return $this->hasOne(Image::class, 'userId')->where('type', 'profile');
    // }
    public function report()
    {
        return $this->hasMany(Report::class, 'userId');
    }

    public function rate()
    {
        return $this->hasMany(Rating::class, 'coachId', 'playerId');

    }

    public function finance()
    {
        return $this->hasMany(Finance::class, 'userId');

    }

    public function getRateAttribute()
    {
        $coachId = $this->id;
        $totalRating = Rating::query()
            ->where('coachId', $coachId)
            ->sum('rate');
        $userCount = Rating::query()
            ->where('coachId', $coachId)
            ->count('playerId');
        if ($userCount === 0) {
            return 0;
        }
        $averageRating = $totalRating / $userCount;
        return intval($averageRating);
    }
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'userId');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sennder_id');
    }
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function getIsPaidAttribute()
    {
        return $this->isPaid();
    }
    public function isPaid()
    {
        $currentDate = now();
        $expirationDate = $this->expiration;
        if ($currentDate->lessThanOrEqualTo($expirationDate)) {
            return 'paid';
        } else {
            return 'unpaid';
        }
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Article::class, 'article_user', 'user_id', 'article_id')->withPivot('isFavourite');
    }
    public function coachArticle()
    {
        return $this->belongsToMany(Article::class, 'article_user', 'coach_id', 'article_id')->withPivot('isFavourite');
    }
    public function program()
    {
        return $this->hasMany(Program::class, 'user_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'userId');
    }


}

<?php

namespace App\Models;

<<<<<<< HEAD
use App\Traits\UUID;
=======
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
>>>>>>> 7697ef8bfebcd35431649573b32fa369a71e60e9
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
<<<<<<< HEAD
    use UUID, HasFactory;

=======
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
>>>>>>> 7697ef8bfebcd35431649573b32fa369a71e60e9
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
=======
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
>>>>>>> 7697ef8bfebcd35431649573b32fa369a71e60e9
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

<<<<<<< HEAD
=======
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
>>>>>>> 7697ef8bfebcd35431649573b32fa369a71e60e9
    public function getJWTCustomClaims()
    {
        return [];
    }
}

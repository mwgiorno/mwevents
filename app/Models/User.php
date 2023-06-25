<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'firstname',
        'lastname',
        'birthdate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public static function new(
        string $username,
        string $firstname,
        string $lastname,
        string $password,
        mixed $birthdate
    )
    {
        return static::create([
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'password' => Hash::make($password),
            'birthdate' => $birthdate,
        ]);
    }

    public function getFullname()
    {
        return "$this->firstname $this->lastname";
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'author');
    }
}

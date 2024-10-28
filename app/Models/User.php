<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    private const DEFAULT_PASSWORD = 'password123';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'contact_number',
        'username',
        'email',
        'password',
        'role',
        'signature',
        'user_status'

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // this function automatically sets password of the user when none is given
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->password)) {
                $user->password = Hash::make(self::DEFAULT_PASSWORD);
            }
        });
    }

    public static function getDefaultPassword()
    {
        return self::DEFAULT_PASSWORD;
    }

    public function isProfileIncomplete()
    {
        return (is_null($this->email) || is_null($this->email_verified_at)) || is_null($this->contact_number);
    }

}

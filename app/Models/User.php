<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'picture',
        'birthday',
        'gender',
        'phone',
        'email',
        'password',
        'role',
        'status',
        'google_id',
    ];

    public function reviews()
    {
        return $this->hasMany(reviews::class);
    }

    public function reservations()
    {
        return $this->hasMany(reservations::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(destinations::class, 'user_favorites', 'user_id', 'destination_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isGuide()
    {
        return $this->role === 'guide';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

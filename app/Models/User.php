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
        'birthday',
        'gender',
        'phone',
        'email',
        'password',
        'role',
        'status'
    ];

        // Relationships
        public function profile()
        {
            return $this->hasOne(profiles::class);
        }
    
        public function reviews()
        {
            return $this->hasMany(reviews::class);
        }
    
        public function itineraries()
        {
            return $this->hasMany(itineraries::class);
        }
    
        public function reservations()
        {
            return $this->hasMany(reservations::class);
        }
    
        public function favorites()
        {
            return $this->belongsToMany(destinations::class, 'user_favorites');
        }
    
        // Check if user is admin
        public function isAdmin()
        {
            return $this->role === 'admin';
        }
    
        // Check if user is guide
        public function isGuide()
        {
            return $this->role === 'guide';
        }
    
        // Check if user is client
        public function isClient()
        {
            return $this->role === 'client';
        }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
}

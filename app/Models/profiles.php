<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profiles extends Model
{
    /** @use HasFactory<\Database\Factories\ProfilesFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'avatar',
        'bio',
        'address',
        'preferences',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Methods
    public function updateProfileFirstName($firstName)
    {
        $this->user->update(['first_name' => $firstName]);
        return $this->user->fresh();
    }

    public function updateProfileLastName($lastName)
    {
        $this->user->update(['last_name' => $lastName]);
        return $this->user->fresh();
    }

    public function updateProfileGender($gender)
    {
        $this->user->update(['gender' => $gender]);
        return $this->user->fresh();
    }

    public function updateProfilePhone($phone)
    {
        $this->user->update(['phone' => $phone]);
        return $this->user->fresh();
    }

    public function updateProfilePassword($password)
    {
        $this->user->update(['password' => bcrypt($password)]);
        return $this->user->fresh();
    }

    public function updateProfileBio($bio)
    {
        $this->update(['bio' => $bio]);
        return $this->fresh();
    }
}

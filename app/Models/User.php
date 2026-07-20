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

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'contact_no',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function farms()
    {
        return $this->hasMany(Farm::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function diseaseReports()
    {
        return $this->hasMany(DiseaseReport::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'dep',
        'remember_token',
    ];
    protected $hidden = [
        'password', // Hide the password when serializing
        'remember_token', // Optionally hide the remember token
    ];

    // Specify attributes that should not be mass assignable
    protected $guarded = ['passeord']; // Corrected typo from 'passeord' to 'password'

    // User.php
    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\role;

class user extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'dep',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'userhasroles');
    }
}

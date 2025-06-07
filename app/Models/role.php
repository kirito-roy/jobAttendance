<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    public $table = 'roles';
    protected $fillable = ['role'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'userhasroles');
    }
}

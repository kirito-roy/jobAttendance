<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'start_time', 'end_time', 'day_of_week'];

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}

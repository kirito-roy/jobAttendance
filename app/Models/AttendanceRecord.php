<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'check_in', 'check_out', "date", 'status'];

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}

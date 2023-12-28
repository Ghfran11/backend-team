<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $guarded = [];


    use HasFactory;

    public function days()
    {
        return $this->belongsTo(Day::class, 'dayId');
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'userId');
    }
}

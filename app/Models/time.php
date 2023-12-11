<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = ['playerId','startTime','endTime','dayId','type'];
    use HasFactory;

    public function days()
    {
        return $this->belongsTo(Day::class,'dayId');

    }

    public function player()
    {
        return $this->belongsTo(User::class,'playerId');
    }

}

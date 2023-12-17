<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
<<<<<<< HEAD
    protected $fillable = ['playerId','startTime','endTime','dayId','coachId'];
=======
    protected $guarded=[];

>>>>>>> c7a182187fcf5d51d56d60cf8afdd4de3ea5a68e
    use HasFactory;

    public function days()
    {
        return $this->belongsTo(Day::class,'dayId');

    }

    public function player()
    {
<<<<<<< HEAD
        return $this->belongsTo(User::class,'playerId');
    }
    public function coach()
    {
        return $this->belongsTo(User::class,'coachId');
=======
        return $this->belongsTo(User::class,'coachId','playerId');
>>>>>>> c7a182187fcf5d51d56d60cf8afdd4de3ea5a68e
    }

}

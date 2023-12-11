<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{

    use HasFactory;
    protected $fillable = ['playerId','exerciseId','dayId'];

    public function player()
    {
        return $this->belongsTo(User::class,'playerId');
    }
    public function days()
    {
        return $this->belongsTo(Day::class,'dayId');

    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['coachId','playerId'];

    public function player()
    {
        return $this->belongsTo(User::class,'playerId')->onDelete('cascade');;
    }
    public function coach()
    {
        return $this->belongsTo(User::class,'coachId')->onDelete('cascade');;
    }



}

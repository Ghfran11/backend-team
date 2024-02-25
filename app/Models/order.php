<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['coachId', 'playerId', 'type', 'status'];

    public function player()
    {
        return $this->belongsTo(User::class, 'playerId');
    }
    public function coach()
    {
        return $this->belongsTo(User::class, 'coachId');
    }
}

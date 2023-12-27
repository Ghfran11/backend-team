<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['playerId', 'coachId', 'rate'];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coachId')->onDelete('cascade');
    }
}

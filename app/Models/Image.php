<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at', 'userId', 'exerciseId'];
    protected $guarded = [];


    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->onDelete('cascade');

    }
}

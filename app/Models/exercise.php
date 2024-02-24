<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];
    public function programme()
    {
        return $this->hasMany(Program::class, 'exerciseId');

    }

    public function image()
    {
        return $this->hasMany(Image::class, 'exerciseId');

    }
}

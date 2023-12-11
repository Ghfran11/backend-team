<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    use HasFactory;

public function programme()
{
    return $this->hasMany(Day::class,'dayId');

}
public function time()
{
    return $this->hasMany(Day::class,'dayId');

}
}


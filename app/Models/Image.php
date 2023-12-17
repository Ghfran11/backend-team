<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded=[];


public function exercise()
{
    return $this->belongsTo(Exercise::class,'exerciseId');

}
public function user()
{
    return $this->belongsTo(User::class,'userId');

}
}

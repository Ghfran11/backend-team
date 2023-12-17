<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded=[];

<<<<<<< HEAD

public function exercise()
{
    return $this->belongsTo(Exercise::class,'exerciseId');

}
=======
    public function exercise()
{
    return $this->belongsTo(Exercise::class,);

}

>>>>>>> c7a182187fcf5d51d56d60cf8afdd4de3ea5a68e
public function user()
{
    return $this->belongsTo(User::class,'userId');

}
}

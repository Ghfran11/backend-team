<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'type', 'imageUrl'];


    public function program()
    {
        return $this->hasMany(Program::class, 'categoryId');
    }
}

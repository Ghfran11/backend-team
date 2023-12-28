<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = ['gender','weight','waist Measurement','neck','height','userId','birthDate'];
    use HasFactory;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $fillable = ['gender', 'weight', 'waist_measurement', 'neck', 'height', 'userId', 'birthDate', 'program_id'];



    public function program()
    {
        return $this->belongsToMany(Program::class, 'program_userinfos', 'userInfo_id');
    }
}



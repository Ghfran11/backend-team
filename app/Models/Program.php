<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{

    use HasFactory;
    protected $fillable = ['name', 'file', 'categoryId', 'type', 'imageUrl', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }
    public function coachs()
    {
        return $this->belongsToMany(User::class, 'programe_users', 'program_id');
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'programe_users', 'program_id')->withPivot('days');
    }
    public function userInfo()
    {
        return $this->hasMany(userInfo::class ,'program_userinfos', 'program_id');
    }

}

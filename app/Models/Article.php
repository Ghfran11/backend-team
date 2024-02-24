<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'article_user', 'article_id', 'user_id');
    }

}

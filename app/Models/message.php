<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['caht_id', 'content'];


    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
    public function message_notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}

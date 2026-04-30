<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = ['user_id', 'role', 'content'];

    public $timestamps = false; // We use created_at manually in migration

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

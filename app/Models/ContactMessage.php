<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'message', 'read_at', 'reply_message', 'reply_at', 'is_important'];

    protected $casts = [
        'read_at' => 'datetime',
        'reply_at' => 'datetime',
        'is_important' => 'boolean',
    ];

    public function getIsReadAttribute(): bool
    {
        return $this->read_at !== null;
    }
}

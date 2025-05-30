<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingMessage extends Model
{
    protected $fillable = [
        'from',
        'to',
        'subject',
        'description',
        'verification_token',
        'is_verified',
        'expires_at'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expires_at' => 'datetime',
    ];
} 
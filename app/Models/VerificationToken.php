<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationToken extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'verification_token',
        'verification_type',
        'expire_at',
        'user_uuid'
    ];

    protected $casts = [
        'expire_at' => 'datetime',
    ];
}

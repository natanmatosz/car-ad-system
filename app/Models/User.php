<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasUuids;

    public const int MINIMUM_AGE = 18;

    public $primaryKey = 'uuid';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'birth_date',
        'phone_number',
        'email_verified_at',
        'phone_verified_at'
    ];

    protected $hidden = [
        'password'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'timestamp',
            'phone_verified_at' => 'timestamp',
            'birth_date' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function newUniqueId(): string
    {
        return Uuid::uuid4()->toString();
    }
}

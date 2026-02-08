<?php

namespace App\Repositories\VerificationToken;

use App\Models\VerificationToken;
use Illuminate\Container\Attributes\Bind;

#[Bind(EloquentVerificationTokenRepository::class)]
interface VerificationTokenRepository
{
    public function storeEmailToken(string $token, string $uuid): void;

    public function storePhoneNumberToken(string $token, string $uuid): void;

    public function retrievePhoneNumberToken(string $uuid): VerificationToken;

    public function retrieveEmailToken(string $uuid): VerificationToken;
}

<?php

namespace App\Utils\VerificationToken;

use App\Models\User;
use Illuminate\Container\Attributes\Bind;

#[Bind(RandomVerificationTokenManager::class)]
interface VerificationTokenManager
{
    public const int BASIC_TOKEN = 6;
    public function generateEmailToken(int $length, User $user);
    public function generatePhoneNumberToken(int $length, User $user);

    public function verifyEmailToken(string $token, string $uuid): void;
    public function verifyPhoneNumberToken(string $token, string $uuid): void;
}

<?php

namespace App\Utils\VerificationToken;

interface VerificationTokenManager
{
    public function generateTokenForUser(int $length, string $userUuid): string;

    public function validateTokenForUser(string $token, string $userUuid): bool;
}

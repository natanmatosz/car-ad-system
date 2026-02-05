<?php

namespace App\Utils\VerificationToken;

use Nette\Utils\Random;

class RandomVerificationTokenManager implements VerificationTokenManager
{
    public function __construct(protected Random $random)
    {

    }

    public function generateTokenForUser(int $length, string $uuid): string
    {
        return "";
    }

    public function validateTokenForUser(string $token, string $uuid): bool
    {
        return false;
    }
}

<?php

namespace App\Dto\User;

use App\Enums\VerificationTokenType;

final readonly class VerifyTokenDto
{
    public function __construct(
        public string $token,
        public VerificationTokenType $verificationType
    )
    {

    }
}

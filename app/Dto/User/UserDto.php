<?php

namespace App\Dto\User;

readonly class UserDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $phoneNumber,
        public string $email,
        public string $password,
        public string $birthDate
    ) {

    }
}

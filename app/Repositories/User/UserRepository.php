<?php

namespace App\Repositories\User;

use App\Dto\User\UserDto;
use App\Models\User;
use Illuminate\Container\Attributes\Bind;

#[Bind(EloquentUserRepository::class)]
interface UserRepository
{
    public function create(UserDto $dto): User;

    public function update(string $uuid, UserDto $dto): User;

    public function isEmailRegistered(string $email): bool;

    public function isPhoneNumberRegistered(string $phoneNumber): bool;

    public function validateEmail(string $uuid): void;

    public function validatePhoneNumber(string $uuid): void;

    public function getEmailVerificationCode(string $uuid): string;

    public function getPhoneNumberVerificationCode(string $uuid): string;
}

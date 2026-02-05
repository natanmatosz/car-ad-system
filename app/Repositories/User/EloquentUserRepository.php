<?php

namespace App\Repositories\User;

use App\Dto\User\UserDto;
use App\Models\User;

class EloquentUserRepository implements UserRepository
{
    public function __construct(protected User $model)
    {
    }

    public function create(UserDto $dto): User
    {
        $user = $this->model->fill([
            'first_name'    => $dto->firstName,
            'last_name'     => $dto->lastName,
            'email'         => $dto->email,
            'phone_number'  => $dto->phoneNumber,
            'password'      => $dto->password,
            'birth_date'    => $dto->birthDate,
        ]);

        $user->save();

        return $user;
    }

    public function update(string $uuid, UserDto $dto): User
    {
        return $this->model;
    }

    public function isEmailRegistered(string $email): bool
    {
        return $this->model->newQuery()->where('email', $email)->exists();
    }

    public function isPhoneNumberRegistered(string $phoneNumber): bool
    {
        return $this->model->newQuery()->where('phone_number', $phoneNumber)->exists();
    }

    public function validateEmail(string $uuid): void
    {
        $this->validateEmailOrPhoneNumber($uuid, true);
    }

    public function validatePhoneNumber(string $uuid): void
    {
        $this->validateEmailOrPhoneNumber($uuid, false);
    }

    private function validateEmailOrPhoneNumber(string $uuid, bool $isEmail): void
    {
        $toUpdate = $isEmail ? ['email_verified_at' => now()]: ['phone_number_verified_at' => now()];
        $this->model->newQuery()->where('uuid', $uuid)->update($toUpdate);
    }
}

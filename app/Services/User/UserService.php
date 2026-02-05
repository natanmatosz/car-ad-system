<?php

namespace App\Services\User;

use App\Dto\User\UserDto;
use App\Exceptions\User\EmailAlreadyRegisteredException;
use App\Exceptions\User\PhoneNumberAlreadyRegisteredException;
use App\Models\User;
use App\Repositories\User\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $repository
    )
    {

    }

    public function create(UserDto $dto): void
    {
        $this->validateUserData($dto);
        $this->repository->create($dto);
    }

    public function update(string $uuid, UserDto $dto): void
    {
        if (! $this->repository->isEmailRegistered($dto->email)) {
            throw new PhoneNumberAlreadyRegisteredException("User not found");
        }

        $this->repository->update($uuid, $dto);
    }

    private function validateUserData(UserDto $dto): void
    {
        if ($this->repository->isEmailRegistered($dto->email)) {
            throw new EmailAlreadyRegisteredException("An user with this email already exists.");
        }

        if ($this->repository->isPhoneNumberRegistered($dto->phoneNumber)) {
            throw new PhoneNumberAlreadyRegisteredException("An user with this phone number already exists.");
        }

        if (! $this->userHasMinimumAge(new \DateTimeImmutable($dto->birthDate), new \DateTimeImmutable('now'))) {
            throw new \DomainException("User should be at least 18 years old.");
        }
    }

    private function userHasMinimumAge(\DateTimeImmutable $birthDate, \DateTimeImmutable $now): bool
    {
        return $birthDate->diff($now)->y >= User::MINIMUM_AGE;
    }

}

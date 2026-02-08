<?php

namespace App\Services\User;

use App\Dto\User\UserDto;
use App\Dto\User\VerifyTokenDto;
use App\Enums\VerificationTokenType;
use App\Exceptions\User\EmailAlreadyRegisteredException;
use App\Exceptions\User\PhoneNumberAlreadyRegisteredException;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Utils\VerificationToken\VerificationTokenManager;

class UserService
{
    public function __construct(
        protected UserRepository $repository,
        protected VerificationTokenManager $tokenManager
    )
    {
    }

    public function create(UserDto $dto): void
    {
        $this->validateUserData($dto);
        $user = $this->repository->create($dto);
        $this->tokenManager->generateEmailToken(VerificationTokenManager::BASIC_TOKEN, $user);
        $this->tokenManager->generatePhoneNumberToken(VerificationTokenManager::BASIC_TOKEN, $user);
    }

    public function update(string $uuid, UserDto $dto): void
    {
        if (! $this->repository->isEmailRegistered($dto->email)) {
            throw new PhoneNumberAlreadyRegisteredException("User not found");
        }

        $this->repository->update($uuid, $dto);
    }

    public function validateVerificationToken(VerifyTokenDto $dto, string $uuid): void
    {
        switch ($dto->verificationType) {
            case VerificationTokenType::EMAIL:
                $this->tokenManager->verifyEmailToken($dto->token, $uuid);
                break;
            case VerificationTokenType::PHONE_NUMBER:
                $this->tokenManager->verifyPhoneNumberToken($dto->token, $uuid);
                break;
            default:
                throw new \Exception("Invalid verification type");
        }
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

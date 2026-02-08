<?php

namespace App\Utils\VerificationToken;

use App\Mail\EmailVerificationToken;
use App\Models\User;
use App\Models\VerificationToken;
use App\Repositories\User\UserRepository;
use App\Repositories\VerificationToken\VerificationTokenRepository;
use Illuminate\Mail\Mailer;
use Nette\Utils\Random;
use Twilio\Rest\Client;

class RandomVerificationTokenManager implements VerificationTokenManager
{
    public function __construct(
        protected Mailer $mailer,
        protected VerificationTokenRepository $repository,
        protected UserRepository $userRepository,
        protected Client $smsClient
    )
    {

    }

    public function generateEmailToken(int $length, User $user): void
    {
        $token = Random::generate($length, '1-9');
        $this->repository->storeEmailToken($token, $user->uuid);

        $this->mailer->to($user->email)->queue(new EmailVerificationToken($user->first_name, $token));
    }

    public function generatePhoneNumberToken(int $length, User $user): void {
        $token = Random::generate($length, '1-9');
        $this->repository->storePhoneNumberToken($token, $user->uuid);

        $this->smsClient->messages->create("+55{$user->phone_number}", [
            'body' => "Hello, {$user->first_name} Your verification token is: {$token}",
            'from' => env('TWILIO_NUMER')
        ]);
    }

    public function verifyEmailToken(string $token, string $uuid): void
    {
        $verificationToken = $this->repository->retrieveEmailToken($uuid);
        $this->validateToken($verificationToken, $token);
        $this->userRepository->validateEmail($uuid);
    }

    public function verifyPhoneNumberToken(string $token, string $uuid): void
    {
        $verificationToken = $this->repository->retrievePhoneNumberToken($uuid);
        $this->validateToken($verificationToken, $token);
        $this->userRepository->validatePhoneNumber($uuid);
    }

    private function validateToken(VerificationToken $verificationToken, string $token): void
    {
        if (now()->isAfter($verificationToken->expire_at)) {
            throw new \DomainException("Token exipired.");
        }

        if ($verificationToken->verification_token != $token) {
            throw new \DomainException("Invalid token");
        }
    }
}

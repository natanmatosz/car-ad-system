<?php

namespace App\Repositories\VerificationToken;

use App\Models\User;
use App\Models\VerificationToken;

class EloquentVerificationTokenRepository implements VerificationTokenRepository
{
    protected const string EMAIL_TOKEN = 'email';
    protected const string PHONE_TOKEN = 'phone';

    public function __construct(protected VerificationToken $model)
    {

    }

    public function retrievePhoneNumberToken(string $uuid): VerificationToken
    {
         return $this->retrieveEmailOrPhoneToken($uuid, self::PHONE_TOKEN);
    }

    public function retrieveEmailToken(string $uuid): VerificationToken
    {
        return $this->retrieveEmailOrPhoneToken($uuid, self::EMAIL_TOKEN);
    }


    public function storeEmailToken(string $token, string $uuid): void
    {
        $this->storeEmailOrPhoneToken($token, $uuid, self::EMAIL_TOKEN);
    }

    public function storePhoneNumberToken(string $token, string $uuid): void
    {
        $this->storeEmailOrPhoneToken($token, $uuid, self::PHONE_TOKEN);
    }

    private function retrieveEmailOrPhoneToken(string $uuid, string $verificationType): VerificationToken
    {
        return $this->model->newQuery()
            ->where([
                'user_uuid' => $uuid,
                'verification_type' => $verificationType,
            ])->first();
    }

    private function storeEmailOrPhoneToken(string $token, string $uuid, string $verificationType): void
    {
        VerificationToken::create([
            'verification_token'    => $token,
            'verification_type'     => $verificationType,
            'expire_at'             => now()->addMinutes(15),
            'user_uuid'             => $uuid
        ]);
    }

}

<?php

namespace App\Http\Requests;

use App\Dto\User\VerifyTokenDto;
use App\Enums\VerificationTokenType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class VerificationTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string|min:6|max:6',
            'verification_type' => new Enum(VerificationTokenType::class),
        ];
    }

    public function toDto(): VerifyTokenDto
    {
        return new  VerifyTokenDto(
            token: $this->input('token'),
            verificationType: VerificationTokenType::from($this->input('verification_type')),
        );
    }
}

<?php

namespace App\Http\Requests;

use App\Dto\User\UserDto;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'phone_number' => 'required|string',
            'birth_date' => 'required|date_format:Y-m-d',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ];
    }

    public function toDto(): UserDto
    {
        return new UserDto(
            firstName:      $this->input('first_name'),
            lastName:       $this->input('last_name'),
            phoneNumber:    $this->input('phone_number'),
            email:          $this->input('email'),
            password:       $this->input('password'),
            birthDate:      $this->input('birth_date'),
        );
    }
}

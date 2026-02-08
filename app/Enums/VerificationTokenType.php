<?php

namespace App\Enums;

enum VerificationTokenType: string
{
    case EMAIL = 'email';
    case PHONE_NUMBER = 'phone_number';
}

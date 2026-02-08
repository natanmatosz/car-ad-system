<x-mail::message>
Olá, {{ $firstName }}!

O seu código de verificação de e-mail é <strong>{{ $verificationToken }}</strong>

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>

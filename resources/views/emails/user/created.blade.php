@component('mail::message')
# Bem-vindo!

Seu cadastro foi realizado no sistema. Sua senha é: {{ $password }}

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent

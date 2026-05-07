<x-mail::message>
# Password Reset Code

Hello,

You are receiving this email because we received a password reset request for your admin account.

Your verification code is:
## {{ $code }}

This code will expire in 15 minutes.

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

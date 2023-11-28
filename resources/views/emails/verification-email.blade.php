@component('mail::message')
    # Verify Your Email Address

    Thanks for signing up! Please verify your email by clicking the button below!

    @component('mail::button', ['url' => $verificationLink])
        Verify Email Address
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

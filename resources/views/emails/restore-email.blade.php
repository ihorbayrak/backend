@component('mail::message')
    Your restoration code is: {{ $code }}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

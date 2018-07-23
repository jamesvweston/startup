@component('mail::message')
Please confirm your email address

@component('mail::button', ['url' => config('app.url') . '/api/users/email_confirmation/' . $token])
Confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

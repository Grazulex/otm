@component('mail::message')
Welcome

We have make a new account for you.
Your login is : {{ $username }}
You can make a reset of your passord the first time.

Thanks,<br>
{{ config('app.name') }}
@endcomponent


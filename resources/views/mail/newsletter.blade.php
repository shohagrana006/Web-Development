@component('mail::message')
# {{ Str::title($user_name_for_mail) }}, You got 10% disconut

You are our selected Customer. You got 10% discount for our all products.



@component('mail::button', ['url' => 'Shohag'])
View all
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

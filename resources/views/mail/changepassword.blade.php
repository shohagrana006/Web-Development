@component('mail::message')
# Change Password Email to {{ Str::title($user_name_for_mail) }}

@component('mail::panel')
Your Password has been Change!
@endcomponent

@component('mail::button', ['url' => "shohag"])
Test Button
@endcomponent

@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
|Col 4 is       |  Right-left   | $69

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

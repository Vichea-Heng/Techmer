@component('mail::message')
# Reset Password

<p>Dear {{ $data["name"] }},</p>

<p>We received a request to reset your Facebook password.</p>

<p>You can directly change your password.</p>

@component('mail::button', ['url' => $data["url"]])
Click Here To Reset
@endcomponent

<p>Didn't request this change?</p>
<p>If you didn't request a new password, let us know.</p>

Thanks,<br>
Techfinder
@endcomponent
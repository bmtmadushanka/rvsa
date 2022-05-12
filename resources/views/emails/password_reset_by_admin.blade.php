@include('emails.header')
<tr>
    <td>Dear {{ $user->first_name }} {{ $user->last_name }},</td>
</tr>
<tr>
    <td>
        The team {{ Company::get('code') }} has reset your account password for a security reason. A new password can be created when you log into your <a href="{{ config('app.url') }}/forgot-password">account</a> next time.
    </td>
</tr>
@include('emails.footer')

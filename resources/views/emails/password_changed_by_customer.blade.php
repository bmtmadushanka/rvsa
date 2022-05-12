@include('emails.header')
<tr>
    <td>Dear {{ $user->first_name }} {{ $user->last_name }},</td>
</tr>
<tr>
    <td>
        You've changed your {{ Company::get('code') }} account password successfully. If you haven't made any change, please contact the team {{ Company::get('code') }} immediately.
    </td>
</tr>
@include('emails.footer')

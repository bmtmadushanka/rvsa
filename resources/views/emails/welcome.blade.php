@include('emails.header')
<tr>
    <td>Dear {{ $user->first_name }} {{ $user->last_name }},</td>
</tr>
<tr>
    <td>
        Thank you for choosing {{ Company::get('code') }}.
        Please log-in to your <a href="{{ config('app.url') }}">Client Dashboard</a> in order to purchase Model Reports.
        Looking forward to welcoming you on board.
    </td>
</tr>
@include('emails.footer')

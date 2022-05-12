@include('emails.header')
<tr>
    <td>Dear {{ $message->ticket->sender->first_name }} {{ $message->ticket->sender->last_name }},</td>
</tr>
<tr>
    <td>
        The Admin has replied to the Discussion. Please follow the link to view the complete message & write back to us.<br/><br/>
        <a href="{{ config('app.url') }}/di/{{ $message->token }}">{{ config('app.url') }}/di/{{ $message->token }}</a>
    </td>
</tr>
@include('emails.footer')

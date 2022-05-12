@include('emails.header')
<tr>
    <td>Dear Admin,</td>
</tr>
<tr>
    <td>
        {{ $message->ticket->sender->first_name }} {{ $message->ticket->sender->last_name }} ({{ $message->ticket->sender->client->raw_company_name }}), has replied to a DI. Please follow the link to view the complete message.<br/><br/>
        <a href="{{ config('app.url') }}/di/{{ $message->token }}">{{ config('app.url') }}/di/{{ $message->token }}</a>
    </td>
</tr>
@include('emails.footer')

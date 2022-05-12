@include('emails.header')
<tr>
    <td>Dear Admin,</td>
</tr>
<tr>
    <td>
        {{ $approval->creator->first_name }} {{$approval->creator->last_name }} ({{ $approval->creator->client->raw_company_name }}) has requested a profile change. Please follow the link to review it.<br/><br/>
        <a href="{{ config('app.url') }}/admin/approval/{{ $approval->id }}">{{ config('app.url') }}/admin/approval/{{ $approval->id }}</a>
    </td>
</tr>
@include('emails.footer')

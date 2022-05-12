@include('emails.header')
<tr>
    <td>Dear {{ $approval->creator->first_name }} {{ $approval->creator->last_name }},</td>
</tr>
<tr>
    <td>
       The admin has changed some of your profile data. Please follow the link to see the changes.<br/><br/>
       <a href="{{ config('app.url') }}/user/notifications/approval/{{ $approval->id }}">{{ config('app.url') }}/user/notifications/approval/{{ $approval->id }}</a>
    </td>
</tr>
@include('emails.footer')


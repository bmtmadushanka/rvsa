@include('emails.header')
<tr>
    <td>Dear {{ $order->user->first_name }} {{ $order->user->last_name }},</td>
</tr>
<tr>
    <td>
        Regret to inform you that your recent payment towards purchasing of Model Reports from {{ Company::get('web') }} has been failed due to the following reason.<br/><br/>
        <table class="table-condensed" style="width: 100%" border=1>
            <tbody>
            <tr>
                <td class="bg-light-grey" style="width: 150px">Order ID</td>
                <td>{{ sprintf('%03d', $order->id) }}</td>
            </tr>
            <tr>
                <td class="bg-light-grey">Reason</td>
                <td>{{ $reason }}</td>
            </tr>
            </tbody>
        </table>
        <div style="margin-top: 15px">Please follow the below link and re-try do the payment for the same order.</div>
        <a href="{{ config('app.url') }}/orders">{{ config('app.url') }}/orders</a>
    </td>
</tr>
@include('emails.footer')

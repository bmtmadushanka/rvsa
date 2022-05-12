@include('emails.header')
<tr>
    <td>Dear {{ $order->user->first_name }} {{ $order->user->last_name }},</td>
</tr>
<tr>
    <td>
        We have received the payment for following Model Report purchases (Order ID - {{ sprintf('%03d', $order->id) }}). The transaction will appear on your Bank Statement as PAYPAL *RVSA.<br/><br/>
        <table class="table-condensed" style="width: 100%" border=1>
            <thead>
            <th style="text-align: left; padding: 5px 10px">Model Report Identifier</th>
            <th style="padding: 5px 10px; width: 170px; text-align: left;">VIN</th>
            <th style="text-align: right; padding: 5px 10px; width: 100px">Amount</th>
            </thead>
            <tbody>
            @foreach ($order->reports AS $report)
            <tr>
                <td>{{ $report->child->make }} {{ $report->child->model }} {!! str_replace('<br>', ' ', $report->child->description) !!}</td>
                <td style="text-align: left">{{ $report->vin }}</td>
                <td style="text-align: right">$ {{ number_format($report->price, 2) }}</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" style="text-align: right">Sub Total</td>
                 <td style="text-align: right">$ {{ number_format($order->sub_total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">Discount</td>
                 <td style="text-align: right">$ -{{ number_format($order->discount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">Total inclusive of GST ($ {{ number_format($order->total/11, 2) }})</td>
                 <td style="text-align: right">$ {{ number_format($order->total, 2) }}</td>
            </tr>
            </tfoot>
        </table>
        <div style="margin-top: 15px">Please use the below link to view your latest orders. </div>
        <a href="{{ config('app.url') }}/orders">{{ config('app.url') }}/orders</a>
    </td>
</tr>
@include('emails.footer')

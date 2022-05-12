<table class="datatable-init table" id="table-user-orders">
    <thead>
    <tr>
        <th class="text-nowrap">Order ID</th>
        <th class="text-center" style="width: 100px">Status</th>
        <th class="text-nowrap">Date Created</th>
        <th>Reports</th>
        <th class="text-right text-nowrap" style="width: 150px">Order Total</th>
        @ifFrontEnd
        <th class="text-center">Action</th>
        @endIfFrontEnd
    </tr>
    </thead>
    <tbody>
    @foreach ($orders AS $order)
        <tr>
            <td style="width: 80px" class="align-middle text-right">{{ sprintf('%03d', $order->id)}}</td>
            <td style="width: 120px" class="align-middle text-center"><span class="badge badge-status badge-{{ $order->status == 'paid' ? 'success' : 'secondary' }} justify-content-center" style="width: 55px">{{ ucfirst($order->status) }}</span></td>
            <td style="width: 150px" class="align-middle text-center">{{ $order->created_at->toDateString() }}</td>
            <td class="align-middle">
                @foreach ($order->reports AS $report)
                    {{ $report->child->make }} - {{ $report->vin }}<br/>
                @endforeach
            </td>
            <td style="width: 150px" class="align-middle text-right">{{ number_format($order->total, 2) }} AUD</td>
            @ifFrontEnd
            <td class="text-center text-nowrap">
                @if ($order->status === 'pending')
                <a type="button" class="btn btn-outline-{{ $order->status == 'pending' ? 'danger' : 'secondary disabled' }} justify-content-center mr-1" data-id="{{ $order->id }}" href="/order/{{ $order->id }}/{{ $order->status == 'pending' ? 'pay' : 'view' }}" style="text-transform: initial; width: 110px"><em class="icon ni ni-{{ $order->status == 'pending' ? 'sign-usd mr-1' : 'eye mr-1' }}"></em> {{ $order->status == 'pending' ? 'Pay Now' : 'View Order' }}</a>
                @endif
            </td>
            @endIfFrontEnd
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function(){
        setTimeout(function() {
            $('table#table-user-orders thead th.sorting:first ').trigger('click');
        }, 200)
    })
</script>

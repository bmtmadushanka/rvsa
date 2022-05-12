@unless ($tab_data->isEmpty())
    <table class="datatable table mb-3 wrapper-scrollable">
        <thead>
        <tr>
            <th class="text-nowrap"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="p-0 border-bottom">
                @foreach ($tab_data AS $payment)
                <div class="nk-ibx-item px-2">
                    <div class="nk-ibx-item-elem nk-ibx-item-user flex-grow-1">
                        <span class="badge badge-outline-{{ $payment->status === 'paid' ? 'success' : 'danger' }} mr-1 justify-content-center" style="width: 50px">{{ ucfirst($payment->status) }}</span>
                        @if ($payment->status === 'paid')
                            Thank you for the payment. We've received {{ $payment->gross_amount }} AUD for your order ID {{ sprintf('%03d', $payment->order_id) }}
                        @else
                            The payment of {{ $payment->gross_amount }} AUD paid to Order ID {{ sprintf('%03d', $payment->order_id) }} was failed
                        @endif
                        at {{ date('Y-M-d G:i:s A', strtotime($payment->updated_at)) }}
                    </div>
                </div>
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
@else
    <div class="nk-ibx-item p-5 nk-ibx-item-fluid justify-content-center fs-17px">
        <div style="position: absolute; top: 100px"><em class="icon ni ni-info mr-1"></em> You haven't purchased any report yet!</div>
    </div>
@endunless

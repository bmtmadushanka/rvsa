@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/sales"><em class="icon ni ni-arrow-left"></em><span>Sales</span></a></div>
                <h2 class="nk-block-title fw-normal">Client - {{ $user->client->raw_company_name }}</h2>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="row g-gs">
                <div class="col-md-4">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-0">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Gross</h6>
                                </div>
                            </div>
                            <div class="card-amount mt-3">
                                <span class="amount"> {{ number_format($user->payments->where('status', 'paid')->sum('gross_amount'), 2) }} <span class="currency currency-usd">AUD</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-0">
                                <div class="card-title">
                                    <h6 class="subtitle">Total PayPal Fee</h6>
                                </div>
                            </div>
                            <div class="card-amount mt-3">
                                <span class="amount"> {{ number_format($user->payments->where('status', 'paid')->sum('paypal_fee'), 2) }} <span class="currency currency-usd">AUD</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-0">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Net</h6>
                                </div>
                            </div>
                            <div class="card-amount mt-3">
                                <span class="amount"> {{ number_format($user->payments->where('status', 'paid')->sum('net_amount'), 2) }} <span class="currency currency-usd">AUD</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-preview mt-4">
                <div class="card-inner">
                    <table class="datatable-init table">
                        <thead>
                        <tr>
                            <th class="text-nowrap" style="width: 50px">Order ID</th>
                            <th class="text-right" style="width: 80px">Status</th>
                            <th>Model Report</th>
                            <th>Date Ordered</th>
                            <th class="text-nowrap" style="width: 100px">Gross Amount</th>
                            <th class="text-nowrap" style="width: 100px">Paypal Fees</th>
                            <th class="text-nowrap" style="width: 100px">Net Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($user->orders->where('status', 'paid') AS $order)
                            <tr>
                                <td style="width: 50px" class="align-middle text-right">{{ sprintf('%03d', $order->id)}}</td>
                                <td style="width: 80px" class="align-middle text-center"><span class="badge badge-status badge-success justify-content-center" style="width: 55px">Paid</span></td>
                                <td class="align-middle">
                                    @foreach ($order->reports AS $report)
                                        {{ $report->child->make }} - {{ $report->vin }}<br/>
                                    @endforeach
                                </td>
                                <td style="width: 150px" class="align-middle text-center">{{ $order->payment->first()->updated_at->toDateString() }}</td>
                                <td style="width: 100px" class="align-middle text-right pr-4">$ {{ number_format($order->payment->first()->gross_amount, 2) }}</td>
                                <td style="width: 100px" class="align-middle text-right pr-4">$ {{ number_format($order->payment->first()->paypal_fee, 2) }}</td>
                                <td style="width: 100px" class="align-middle text-right pr-4">$ {{ number_format($order->payment->first()->net_amount, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            setTimeout(function() {
                $('table.dataTable thead th.sorting:first ').trigger('click');
            }, 1000)
        })
    </script>
@endsection

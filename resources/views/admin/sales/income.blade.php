@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <h2 class="nk-block-title fw-normal">Payments</h2>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            @include('layouts.messages')

            <div class="card card-preview-mt-4">
                <div class="card-inner">
                    <form class="form" action="/admin/income">
                        <div class="row">
                            <div class="col-sm-12 col-md-3" style="max-width: 230px">
                                <div class="form-group ml-2">
                                    <label class="form-label required" for="input-date-from">Date From</label>
                                    <div class="input-group" id="input-group-date-from" style="width: 200px">
                                        <input type="text" class="form-control date-picker" name="date_from" value="{{ $_GET['date_from'] ?? '' }}" id="input-date-from" data-date-format="yyyy-mm-dd" aria-describedby="img-addon" autocomplete="off"/>
                                        <div class="input-group-append" style="height: 36px">
                                            <span class="input-group-text">
                                                <span class="input-group-addon p-0" id="img-addon">
                                                   <em class="icon ni ni-calendar-check fs-18px"></em>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3" style="max-width: 210px">
                                <div class="form-group">
                                    <label class="form-label required" for="input-date-to">Date To</label>
                                    <div class="input-group" id="input-group-date-to" style="width: 200px">
                                        <input type="text" class="form-control date-picker" name="date_to" value="{{ $_GET['date_to'] ?? '' }}" id="input-date-to" data-date-format="yyyy-mm-dd" aria-describedby="img-addon" autocomplete="off"/>
                                        <div class="input-group-append" style="height: 36px">
                                            <span class="input-group-text">
                                                <span class="input-group-addon p-0" id="img-addon">
                                                   <em class="icon ni ni-calendar-check fs-18px"></em>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">*</label>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-primary"><em class="icon ni ni-search"></em> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-preview mt-4">
                <div class="card-inner">
                    <table class="datatable-init-export nowrap table" data-export-title="Export">
                        <thead>
                        <tr>
                            <th class="text-nowrap" style="width: 100px">Date</th>
                            <th>Order ID</th>
                            <th>Client</th>
                            <th>Transaction ID</th>
                            <th class="text-right text-nowrap" style="width: 100px">Gross Amount</th>
                            <th class="text-right text-nowrap" style="width: 100px">Paypal Fees</th>
                            <th class="text-right text-nowrap" style="width: 100px">Net Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($payments AS $k => $payment)
                            <tr>
                                <td>{{ $payment->updated_at->format('Y-m-d H:i:s') }}</td>
                                <td class="text-right">{{ sprintf('%03d', $payment->order->id) }}</td>
                                <td>{{ $payment->order->user->client->raw_company_name }}</td>
                                <td>{{ $payment->token }}</td>
                                <td class="text-right">$ {{ number_format($payment->gross_amount, 2) }}</td>
                                <td class="text-right">$ {{ number_format($payment->paypal_fee, 2) }}</td>
                                <td class="text-right">$ {{ number_format($payment->net_amount, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="border-top"></th>
                            <th class="border-top"></th>
                            <th class="border-top"></th>
                            <th class="border-top"></th>
                            <th class="text-right border-top">$ {{ number_format($totals['gross'], 2) }}</th>
                            <th class="text-right border-top">$ {{ number_format($totals['paypal'], 2) }}</th>
                            <th class="text-right border-top">$ {{ number_format($totals['net'], 2) }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            setTimeout(function() {
                $('table.dataTable thead th.sorting:first ').trigger('click');
            }, 200)
        })
    </script>
@endsection

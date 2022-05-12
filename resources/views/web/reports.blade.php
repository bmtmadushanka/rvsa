@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">Model Reports</h2>
                    <div class="float-right">
                        <a type="button" class="btn btn-outline-primary float-right" href="/cart"><em class="icon ni ni-cart mr-1"></em> View Cart</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    <table class="datatable-init table">
                        <thead>
                        <tr>
                            <th>SEV No.</th>
                            <th style="width: 130px">Make</th>
                            <th style="width: 220px">Model / Code</th>
                            <th>Work Instruction Identifier</th>
                            <th>Unit Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($reports AS $report)
                        <tr>
                            <td class="align-middle">{{ $report->data['vehicle']['sev_no'] }}</td>
                            <td class="align-middle">{{ $report->make }}</td>
                            <td class="align-middle">{{ $report->model }}<br/>{{ $report->model_code }}</td>
                            <td class="align-middle">{!! $report->description !!}</td>
                            <td class="align-middle">{{ number_format($report->price, 2) }} AUD</td>
                            <td class="align-middle">
                                <input type="number" class="form-control form-control-lg text-right integer qty" data-id="{{ $report->id }}" name="qty" value="1" maxlength="3" style="width: 60px"/>
                            </td>
                            <td class="text-center align-middle text-nowrap">
                                <button type="button" class="btn btn-outline-secondary btn-update-cart justify-content-center mr-1" data-method="update" data-id="{{ $report->id }}" style="text-transform: initial; width: 110px"><i class="fas fa-shopping-cart mr-1"></i> Add to Cart</button>
                                <button type="button" class="btn btn-outline-danger btn-update-cart btn-buy-now justify-content-center" data-method="buy_now" data-id="{{ $report->id }}" style="text-transform: initial; width: 100px"><i class="fas fa-dollar-sign mr-1"></i> Buy Now</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- .card-preview -->
        </div> <!-- nk-block -->
    </div><!-- .components-preview -->
@endsection

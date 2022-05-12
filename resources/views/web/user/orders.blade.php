@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <h2 class="nk-block-title fw-normal">My Orders</h2>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            @include('layouts.messages')
            <div class="card card-preview">
                <div class="card-inner">
                 @include('web.partials.user_orders')
                </div>
            </div>
        </div>
    </div>
@endsection

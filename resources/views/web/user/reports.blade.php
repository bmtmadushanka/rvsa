@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <h2 class="nk-block-title fw-normal">My Model Reports</h2>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block nk-block-lg">
           @include('layouts.messages')
            <div class="card card-preview">
                <div class="card-inner">
                    @include('web.partials.user_reports')
                </div>
            </div><!-- .card-preview -->
        </div> <!-- nk-block -->
    </div><!-- .components-preview -->
@endsection

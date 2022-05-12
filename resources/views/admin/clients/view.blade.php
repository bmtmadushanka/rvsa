@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/clients"><em class="icon ni ni-arrow-left"></em><span>Clients</span></a></div>
                <h2 class="nk-block-title fw-normal">Client - {{ $user->client->raw_company_name }}</h2>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="card card-preview px-3 py-1">
                <div class="card-inner">
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ !$selected_tab || !in_array($selected_tab, ['profile', 'notifications']) && !$errors->all() ? 'active' : '' }} ? 'active' : '' }}" data-toggle="tab" href="#tabReports">Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabOrders">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $errors->all() || $selected_tab === 'profile' ? 'active' : '' }}" data-toggle="tab" href="#tabProfile">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $selected_tab === 'notifications' ? 'active' : '' }}" data-toggle="tab" href="#tabNotification">Notifications</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @include('layouts.messages')
                        <div class="tab-pane pt-1 {{ !$selected_tab || !in_array($selected_tab, ['profile', 'notifications']) && empty($errors) ? 'active' : '' }}" id="tabReports">
                            @include('web.partials.user_reports')
                        </div>
                        <div class="tab-pane pt-1" id="tabOrders">
                            @include('web.partials.user_orders')
                        </div>
                        <div class="tab-pane pt-1 {{ $errors->all() || $selected_tab === 'profile' ? 'active' : '' }}" id="tabProfile">
                            @include('admin.clients.update_profile')
                            @include('admin.clients.reset_password')
                        </div>
                        <div class="tab-pane pt-1 {{ $selected_tab === 'notifications' ? 'active' : '' }}" id="tabNotification">
                            @include('web.partials.user_notifications')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card .table tr:first-child th, .card .table tr:first-child td {
            border-top: 1px solid #dbdfea !important;
        }

        .card .dataTables_filter {
            margin: 0.45rem 0.5rem 1.2rem !important;
        }

        .card .dataTables_length {
            margin: 0.45rem 0.5rem 1.2rem !important;
        }

    </style>
@endsection

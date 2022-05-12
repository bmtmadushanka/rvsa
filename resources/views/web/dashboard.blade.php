@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="d-flex">
                    <h3 class="nk-block-title page-title flex-grow-1">My Dashboard</h3>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="nk-block nk-block-lg">
            <div class="row g-gs">
                <div class="col-md-3">
                    <a href="{{ route('web_reports') }}">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="text-center py-1">
                                    <div class="card-icon">
                                        <img src="/images/dashboard/web/purchase_reports.jpg" alt="Purchase Reports">
                                    </div>
                                    <h6 class="mt-4">Purchase Reports</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('web_user_reports') }}">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="text-center py-1">
                                    <div class="card-icon">
                                        <img src="/images/dashboard/web/my_reports.jpg" alt="My Reports">
                                    </div>
                                    <h6 class="mt-4">My Reports</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('web_user_orders') }}">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="text-center py-1">
                                    <div class="card-icon">
                                        <img src="/images/dashboard/web/my_orders.jpg" alt="My Orders">
                                    </div>
                                    <h6 class="mt-4">My Orders</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('web_user_discussions') }}">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                @unless (empty($notifications['pending_discussions']))
                                    <span class="notification-count">{{ sprintf('%02d', $notifications['pending_discussions']) }}</span>
                                @endunless
                                <div class="text-center py-1">
                                    <div class="card-icon">
                                        <img src="/images/dashboard/web/discussion_items.jpg" alt="Discussion Items">
                                    </div>
                                    <h6 class="mt-4">Discussion Items</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('web_user_notifications', 'updates') }}">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                @unless (empty($notifications['pending_notifications']))
                                    <span class="notification-count">{{ sprintf('%02d', $notifications['pending_notifications']) }}</span>
                                @endunless
                                <div class="text-center py-1">
                                    <div class="card-icon">
                                        <img src="/images/dashboard/web/my_notifications.jpg" alt="Notifications">
                                    </div>
                                    <h6 class="mt-4">My Notifications</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('web_user_profile') }}">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="text-center py-1">
                                    <div class="card-icon">
                                        <img src="/images/dashboard/web/my_profile.jpg" alt="Profile">
                                    </div>
                                    <h6 class="mt-4">My Profile</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

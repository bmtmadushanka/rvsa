@extends('layouts.master')
@section('content')
    <div class="nk-block-head nk-block-head-lg">
        <div class="nk-block-head-content">
            <div class="d-flex">
                <h3 class="nk-block-title page-title flex-grow-1">Admin Dashboard</h3>
            </div>
        </div>
    </div>
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-md-3">
                <a href="/admin/discussions">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            @unless (empty($notifications['pending_discussions']))
                            <span class="notification-count">{{ sprintf('%02d', $notifications['pending_discussions']) }}</span>
                            @endunless
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/discussion_items.jpg" alt="Discussion Items">
                                </div>
                                <h6 class="mt-4">Discussion Items</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="admin/approval">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            @unless (empty($notifications['pending_approvals']))
                            <span class="notification-count">{{ sprintf('%02d', $notifications['pending_approvals']) }}</span>
                            @endunless
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/approvals.png" alt="Approvals">
                                </div>
                                <h6 class="mt-4">Approvals</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/admin/sales">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/payments.png" alt="Payments">
                                </div>
                                <h6 class="mt-4">Payments</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="/admin/clients">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/clients.png" alt="Clients">
                                </div>
                                <h6 class="mt-4">Clients</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-md-3">
                <a href="/admin/adr">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/adrs.png" alt="ADRs">
                                </div>
                                <h6 class="mt-4">ADRs</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="admin/master-copy">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/master_copies.png" alt="Master Copies">
                                </div>
                                <h6 class="mt-4">Master Copies</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="admin/child-copy">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/child_copies.png" alt="Child Copies">
                                </div>
                                <h6 class="mt-4">Child Copies</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="admin/settings">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/company_details.png" alt="Company Details">
                                </div>
                                <h6 class="mt-4">Company Details</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="/admin/manager">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/dashboard/admin/admin.png" alt="Admins">
                                </div>
                                <h6 class="mt-4">Admins</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{--<div class="col-md-3">
                <a href="/admin/model-reports">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="text-center py-1">
                                <div class="card-icon">
                                    <img src="/images/icons/file-pdf.svg" alt="">
                                </div>
                                <h6 class="mt-4">Model Reports</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>--}}
        </div>
    </div>
@endsection

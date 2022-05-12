@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <h2 class="nk-block-title fw-normal">Clients</h2>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            @include('layouts.messages')
            <div class="card card-preview">
                <div class="card-inner">
                    <table class="datatable-init table">
                        <thead>
                        <tr>
                            <th class="text-nowrap" style="width: 50px">ID</th>
                            <th class="text-right" style="width: 80px">Status</th>
                            <th>RAW Name</th>
                            <th class="text-nowrap" style="width: 50px">Model Reports</th>
                            <th style="width: 50px">Notifications</th>
                            <th class="text-center" style="width: 50px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users AS $user)
                            <tr>
                                <td style="width: 50px" class="align-middle text-right">{{ sprintf('%03d', $user->id)}}</td>
                                <td style="width: 80px" class="align-middle text-center">
                                    <span class="badge badge-status badge-{{ $user->is_suspended  ? 'danger' : 'success' }} justify-content-center" style="width: 65px">{{ $user->is_suspended  ? 'Suspended' : 'Active' }}</span>
                                </td>
                                <td class="align-middle">{{ $user->client->raw_company_name }}</td>
                                <td style="width: 50px" class="align-middle text-right pr-4">{{ $user->model_reports->count() }}</td>
                                <td style="width: 50px" class="align-middle text-right pr-4">{{ $user->tickets->count() }}</td>
                                <td style="width: 50px" class="text-center text-nowrap">
                                    <a type="button" class="btn btn-outline-secondary justify-content-center mr-1 btn-update-user-status" data-module="clients" data-value="{{ $user->is_suspended }}" data-user="{{ $user->id }}" style="text-transform: initial; width: 110px">{{ $user->is_suspended ? 'Re-Enable' : 'Suspend' }}</a>
                                    <a type="button" class="btn btn-outline-secondary justify-content-center mr-1" href="admin/client/{{ $user->id }}" style="text-transform: initial; width: 110px"><em class="icon ni ni-eye mr-1"></em> View</a>
                                </td>
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
            }, 200)
        })
    </script>
@endsection

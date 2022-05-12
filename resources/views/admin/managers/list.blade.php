@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">Admin Area</h2>
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-primary float-right" id="btn-new-admin"><em class="ni ni-plus mr-1"></em> New Admin</button>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="nk-block nk-block-lg">
            <div class="bg-white p-2">
                <div class="card card-preview">
                    <div class="card-inner">
                        <div class="tab-pane pt-1 active" id="tabAdmins">
                            <table class="datatable-init table">
                                <thead>
                                <tr>
                                    <th class="text-nowrap" style="width: 50px">ID</th>
                                    <th class="text-center text-nowrap" style="width: 80px">Status</th>
                                    <th>Name</th>
                                    <th>Contacts</th>
                                    <th>Role</th>
                                    <th class="text-center" style="width: 50px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users AS $user)
                                    <tr>
                                        <td style="width: 50px" class="align-middle text-right">{{ sprintf('%03d', $user->id)}}</td>
                                        <td style="width: 160px" class="align-middle text-center">
                                            <span class="badge badge-status badge-{{ $user->is_suspended  ? 'danger' : 'success' }} justify-content-center" style="width: 65px">{{ $user->is_suspended  ? 'Suspended' : 'Active' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </td>
                                        <td class="align-middle">{{ $user->email }}<br/> (+61) {{ $user->mobile_no }}</td>
                                        <td class="align-middle">{{ !empty($user->role) ? $user->role : 'N/A' }}</td>
                                        <td style="width: 50px" class="text-center text-nowrap">
                                            <a type="button" class="btn btn-outline-secondary justify-content-center mr-1 btn-update-user-status" data-module="manager" data-status="is_suspended" data-value="{{ $user->is_suspended }}" data-user="{{ $user->id }}" style="text-transform: initial; width: 110px">{{ $user->is_suspended ? 'Re-Enable' : 'Suspend' }}</a>
                                            <a type="button" class="btn btn-outline-secondary justify-content-center mr-1 btn-edit-admin" data-id="{{ $user->id }}" style="text-transform: initial; width: 110px">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function() {

                $('body').on('click', '#btn-new-admin, .btn-edit-admin ', function() {
                    let $$ = $(this)

                    let url = APP_URL + 'admin/manager/create';
                    if ($$.data('id')) {
                        url = APP_URL + 'admin/manager/' + $$.data('id') + '/edit';
                    }

                    loadingButton($$);
                    $.ajax({
                        cache: false,
                        url: url,
                        timeout: 20000
                    }).done(function (j) {
                        if (typeof j.status !== 'undefined') {
                            if (typeof j.msg !== 'undefined') {
                                notify(j.status, j.msg);
                            }
                            if (typeof j.data !== 'undefined') {
                                let myModal = $('#modal-common')
                                myModal.find('.modal-dialog').removeClass('modal-sm modal-xl').addClass('modal-lg');
                                myModal.find('.modal-content').html(j.data);
                                myModal.modal('show');
                            }
                        } else {
                            notify('error', 'We have encountered an error. Please contact your IT Department');
                        }
                    }).fail(function (xhr, status) {
                        handler(xhr, status)
                    }).always(function() {
                        loadingButton($$, false);
                    });

                });

            })
        </script>
    </div>
@endsection

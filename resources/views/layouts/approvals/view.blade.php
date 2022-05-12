@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="{{ $isBackEnd ? '/admin/approval' : '/user/notifications/account' }}"><em class="icon ni ni-arrow-left"></em><span>Notifications</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">Profile Change : {{ $approval->creator->client->raw_company_name }}</h2>
                    <div class="float-right">
                        {{--<a type="button" class="btn btn-outline-primary float-right mt-2" href="{{ route('web-user-new-message') }}"><i class="fas fa-plus mr-1"></i> New Message</a>--}}
                    </div>
                </div>
                <h2 class="nk-block-title fw-normal"></h2>
            </div>
        </div>
        @include('layouts.messages')
        <div class="nk-block nk-block-lg">
            @include('layouts.messages')
            <div class="card card-preview p-3">
                <div class="card-inner">
                    @if(!is_null($approval->reviewed_at))
                        <div class="alert alert-{{ $approval->is_approved ? 'success' : 'danger' }} alert-icon">
                            <em class="icon ni ni-{{ $approval->is_approved ? 'check' : 'cross' }}-circle"></em> The request has been <strong>{{ $approval->is_approved ? 'approved' : 'rejected' }}</strong> by {{ $isBackEnd ? $approval->reviewer->first_name : 'the Administrator' }} at {{ date('Y-M-d G:i:s A', strtotime($approval->reviewed_at)) }}.
                        </div>
                    @endif
                    <table class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th>Column</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($approval->fields AS $column => $values)
                        <tr>
                            <th class="align-middle" style="background: #f9f9f9">{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                            <td>{{ $values['old'] }}</td>
                            <td>{{ $values['new'] }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pt-4 text-center">
                        @ifBackEnd
                            @if (!$approval->is_approved && !$approval->reviewed_at)
                                <button class="btn btn-outline-danger btn-review-approval" data-status="reject" data-id="{{ $approval->id }}" style="width: 120px">Reject</button>
                                <button class="btn btn-outline-primary btn-review-approval" data-status="approve" data-id="{{ $approval->id }}" style="width: 120px">Approve</button>
                            @endif
                        @notBackEnd
                            @if (!$approval->is_approved)
                                <button class="btn btn-outline-danger" id="btn-delete-approval" data-id="{{ $approval->id }}" style="width: 110px">Delete</button>
                            @elseif ($approval->created_by != $approval->reviewed_by)
                                The {{ Company::get('code') }} admin changed your profile data. Please contact {{ Company::get('code') }} team for further clarification.
                            @endif
                        @endIfBackEnd
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {

            $('.datatable').DataTable({
                "dom": 'flrtip',
                "pageLength": 50,
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bInfo": true,
                "bAutoWidth": true
            });

            $('body').on('click', '#btn-delete-approval', function() {

                let $$ = $(this);
                loadingButton($$);
                $.ajax({
                    cache: false,
                    method: 'DELETE',
                    type: 'DELETE',
                    url: APP_URL + 'user/notifications/approval/'+ $(this).data('id') +'/delete',
                    timeout: 20000,
                    data: {
                        '_method': 'DELETE',
                        '_token': $('meta[name=csrf-token]').attr('content'),
                    },
                }).done(function (j) {
                    if (typeof j.status !== 'undefined') {
                        if (typeof j.msg !== 'undefined') {
                            notify(j.status, j.msg);
                        }
                        if (typeof j.redirect !== 'undefined') {
                            redirect(j.redirect);
                        }
                    } else {
                        notify('error', 'We have encountered an error. Please contact your IT Department');
                    }
                }).fail(function (xhr, status) {
                    handler(xhr, status)
                }).always(function() {
                    loadingButton($$);
                });
            });

            $('body').on('click', '.btn-review-approval', function() {
                let $$ = $(this);

                Swal.fire(confirmSwal('Are you sure that you want to ' +  $$.data('status')  + ' the changes? Once done, the action cannot be undone.')).then((result) => {
                    if (result.value) {
                        loadingButton($$);
                        $.ajax({
                            cache: false,
                            method: 'PATCH',
                            url: APP_URL + 'admin/approval/'+ $(this).data('id'),
                            timeout: 20000,
                            data: {
                                '_method': 'PATCH',
                                '_token': $('meta[name=csrf-token]').attr('content'),
                                'status': $$.data('status')
                            },
                        }).done(function (j) {
                            if (typeof j.status !== 'undefined') {
                                if (typeof j.msg !== 'undefined') {
                                    notify(j.status, j.msg);
                                }
                                if (typeof j.redirect !== 'undefined') {
                                    redirect(j.redirect);
                                }
                            } else {
                                notify('error', 'We have encountered an error. Please contact your IT Department');
                            }
                        }).fail(function (xhr, status) {
                            handler(xhr, status)
                        }).always(function() {
                            loadingButton($$);
                        });
                    }
                });

            })
        });
    </script>
@endsection

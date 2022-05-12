@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">Child Copies</h2>
                    <div class="float-right">
                        <div class="dropdown">
                            <a href="#" class="btn btn-primary" data-toggle="dropdown" aria-expanded="false"><span><i class="fas fa-plus mr-1"></i> New Child Copy</span><em class="icon ni ni-chevron-down"></em></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-auto mt-1" style="max-width: initial">
                                <ul class="link-list-plain">
                                    @foreach ($master_copies AS $master_copy)
                                    <li class="text-nowrap"><a href="/admin/child-copy/create?master={{ $master_copy->id }}">{{ $master_copy->name }} - {{ $master_copy->version }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    <div id="accordion" class="accordion">
                        <style>
                            .btn-trigger:before {
                                background-color: transparent !important;
                                color: #fff;
                            }
                            .btn-trigger:hover em, .btn-trigger:active em, .btn-trigger:focus em, .btn-trigger:visited em {
                                color: #fff;
                            }
                        </style>
                        @foreach ($child_copies AS $batch_id => $reports)
                        <div class="accordion-item">
                            <a href="javascript:void(0)" class="accordion-head" data-toggle="collapse" data-target="#accordion-item-{{ $reports->first()->batch_id }}">
                                <h6 class="title font-weight-normal">{{ $reports->first()->name }} {{ $reports->first()->make }} {{ $reports->first()->model }} {{ $reports->first()->model_code }}</h6>
                                <span class="accordion-icon"></span>
                            </a>
                            <div class="accordion-body collapse {{ isset($_GET['item']) && $_GET['item'] == $reports->first()->batch_id ? 'show' : '' }}" id="accordion-item-{{ $reports->first()->batch_id }}" data-parent="#accordion">
                                <div class="accordion-inner p-0" style="min-height: 200px; background: #f9f9f9">
                                    <table class="table table-bordered border-outer-none border-bottom table-hover bg-white">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="width:80px">Status</th>
                                            <th style="width:120px">Name</th>
                                            <th style="width:200px">Make/Model/Code</th>
                                            <th>Work Instruction Identifier</th>
                                            <th class="text-center">Version/Approval</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center" style="width:80px">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($reports AS $report)
                                            <tr>
                                                <td class="text-center"><span class="badge badge-status badge-{{ $report->status['color'] }} justify-content-center" style="width: 50px">{{ $report->status['text'] }}</span></td>
                                                <td>
                                                    {{ $report->name }}
                                                    <div class="small">({{ $report->master->name }} - {{ $report->master->version }})</div>
                                                </td>
                                                <td>{{ $report->make }} {{ $report->model }}<br/>{{ $report->model_code }}</td>
                                                <td>
                                                    {!! $report->description !!}
                                                    <div class="text-muted small mt-2">
                                                        {{ $report->user->first_name }}
                                                        <span> / {{ $report->created_at->toDateString() }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{ $report->version }}<br/>
                                                    <div class="text-muted">{{ $report->approval_code ?? 'N/A'}}</div>
                                                    @if ($report->versionChanges)
                                                    <div><a class="btn btn-link btn-show-version-changes" data-type="child" data-id="{{ $report->id }}" href="javascript:void(0)">View Changes</a></div>
                                                    @else
                                                        <small class="text-muted">(First Version)</small>
                                                    @endif
                                                </td>
                                                <td class="text-right">{{ number_format($report->price, 2) }}</td>
                                                <td class="text-center text-nowrap">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary mr-1 {{ $report->is_readonly ? 'disabled' : 'btn-update-child-data' }}" data-column="approval_code" data-id="{{ $report->id }}" title="Edit Approval Code"><em class="icon ni ni-award"></em> </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary mr-1 {{ $report->is_readonly ? 'disabled' : 'btn-update-child-data' }}" data-column="price" data-id="{{ $report->id }}" title="Edit Price"><em class="icon ni ni-sign-dollar"></em> </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary mr-1 {{ $report->is_readonly ? 'disabled' : 'btn-update-indexes' }}" data-id="{{ $report->id }}" title="Edit Indexes"><em class="icon ni ni-list-index-fill"></em> </button>
                                                    <a class="btn btn-sm btn-outline-secondary mr-1 {{ $report->is_readonly ? 'disabled' : '' }}" {{ $report->is_readonly ? 'disabled' : 'href=/admin/child-copy/' . $report->id . '/mods' }} title="Edit Modification"><em class="icon ni ni-property-add"></em></a>
                                                    <a class="btn btn-sm btn-outline-secondary mr-1" href="/child-copy/{{ $report->id }}/download" title="Downloads" target="_blank"><em class="icon ni ni-download"></em></a>
                                                    <a class="btn btn-sm btn-outline-secondary mr-1 {{ $report->is_readonly ? 'disabled' : '' }}" {{ $report->is_readonly ? 'disabled' : 'href=/admin/child-copy/' . $report->id . '/edit' }} title="Edit Child Copy"><em class="icon ni ni-edit-alt"></em></a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger mr-1 {{ !is_null($report->approval_code) ? 'disabled' : 'btn-delete-child-copy' }}" data-id="{{ $report->id }}" title="Delete Child Report"><em class="icon ni ni-trash"></em></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $('body').on('click', '.btn-delete-child-copy', function() {
            let $$ = $(this);

            Swal.fire(confirmSwal('Are you sure that you want to delete the Child Copy? Once done, the action cannot be undone.')).then((result) => {
                if (result.value) {
                    $.ajax({
                        cache: false,
                        method: 'DELETE',
                        type: 'DELETE',
                        url: APP_URL + 'admin/child-copy/' + $$.data('id'),
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
                            notify('error', 'We have encountered an error. Please contact your System Administrator');
                        }
                    }).fail(function (xhr, status) {
                        handler(xhr, status)
                    })
                }
            });
        });

        $('body').on('click', '.btn-update-child-data', function() {
            let $$ = $(this);
            $.ajax({
                cache: false,
                url: APP_URL + 'admin/child-copy/' + $$.data('id') + '/edit-column',
                timeout: 20000,
                data: {
                    'column': $$.data('column')
                }
            }).done(function (j) {
                if (typeof j.status !== 'undefined') {
                    if (typeof j.msg !== 'undefined') {
                        notify(j.status, j.msg);
                    }
                    if (typeof j.data !== 'undefined') {
                        let myModal = $('#modal-common')
                        myModal.find('.modal-dialog').removeClass('modal-lg modal-xl').addClass('modal-sm');
                        myModal.find('.modal-content').html(j.data);
                        myModal.modal('show');
                    }
                } else {
                    notify('error', 'We have encountered an error. Please contact your System Administrator');
                }
            }).fail(function (xhr, status) {
                handler(xhr, status)
            })
        })

        $('body').on('click', '.btn-update-indexes', function() {
            let $$ = $(this);
            let params = 'scrollbars=no,resizable=yes,status=no,location=no,toolbar=no,menubar=no,width='+ screen.availWidth +',height=' + screen.availHeight;
            let newWindow = open('/admin/child-copy/'+ $(this).data('id') +'/edit-index', 'example', params)
            newWindow.focus();
        })

    </script>
@endsection

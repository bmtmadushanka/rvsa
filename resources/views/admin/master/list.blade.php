@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">Master Copies</h2>
                    <div class="float-right">
                        <a type="button" class="btn btn-outline-primary float-right" href="javascript:void(0)" id="btn-create-master-copy"><i class="fas fa-plus mr-1"></i> New Master Copy</a>
                    </div>
                </div>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block nk-block-lg">
            <div class="card card-preview p-0">
                <div class="card-inner p-0">
                    <div id="accordion" class="accordion">
                        @foreach ($master_copies AS $batch_id => $reports)
                        <div class="accordion-item">
                            <a href="javascript:void(0)" class="accordion-head" data-toggle="collapse" data-target="#accordion-item-{{ $reports->first()->batch_id }}">
                                <h6 class="title font-weight-normal">{{ $reports->first()->name }}</h6>
                                <span class="accordion-icon"></span>
                            </a>
                            <div class="accordion-body collapse {{ isset($_GET['item']) && $_GET['item'] == $reports->first()->batch_id ? 'show' : '' }}" id="accordion-item-{{ $reports->first()->batch_id }}" data-parent="#accordion">
                                <div class="accordion-inner p-0" style="min-height: 200px; background: #f9f9f9">
                                    <table class="table table-bordered border-outer-none border-bottom table-hover bg-white">
                                    <thead>
                                        <tr>
                                        <th style="width: 40px">ID</th>
                                        <th class="text-center" style="width:100px">Status</th>
                                        <th>Name</th>
                                        <th>Version</th>
                                        <th class="text-right" style="width: 150px">Child Copy Count</th>
                                        <th style="width: 120px">User Created</th>
                                        <th style="width: 120px">Date Created</th>
                                        <th class="text-center" style="width:80px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($reports AS $report)
                                        <tr>
                                            <td class="align-middle">{{ $report->id }}</td>
                                            <td class="text-center align-middle"><span class="badge badge-status badge-{{ $report->status['color'] }}">{{ $report->status['text'] }}</span></td>
                                            <td class="align-middle">{{ $report->name }}</td>
                                            <td class="align-middle">{{ $report->version }}
                                                @if ($report->versionChanges)
                                                <a class="btn btn-link btn-show-version-changes" data-type="master" data-id="{{ $report->id }}" href="javascript:void(0)">View Changes</a>
                                                @else
                                                    <small class="text-muted ml-3"> - First Version</small>
                                                @endif
                                            </td>
                                            <td class="align-middle text-right">{{ sprintf('%02d', $report->childCopies->count()) }}</td>
                                            <td class="align-middle">{{ $report->author->first_name }}</td>
                                            <td class="align-middle">{{ $report->created_at->toDateString() }}</td>
                                            <td class="text-center text-nowrap">
                                                <a class="btn btn-sm btn-outline-secondary mr-1 btn-edit-master-copy" data-id="{{ $report->id }}" href="javascript:void(0)"><em class="icon ni ni-edit-alt"></em></a>
                                                <button class="btn btn-sm btn-outline-danger mr-1 btn-delete-adr" data-id="{{ $report->id }}"><em class="icon ni ni-trash"></em></button>
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

        $('body').on('click', '#btn-create-master-copy, .btn-edit-master-copy', function() {
            let params = 'scrollbars=no,resizable=yes,status=no,location=no,toolbar=no,menubar=no,width='+ screen.availWidth +',height=' + screen.availHeight;
            let newWindow = typeof $(this).data('id') == 'undefined' ? open('/admin/master-copy/create', 'example', params) : open('/admin/master-copy/'+ $(this).data('id') +'/edit', 'example', params)
            newWindow.focus();
        });

        $('body').on('click', '.btn-delete-adr', function() {
            let $$ = $(this);
            Swal.fire(confirmSwal('Are you sure that you want to delete the Master Copy? Once done, the action cannot be undone.')).then((result) => {
                if (result.value) {
                    $.ajax({
                        cache: false,
                        method: 'DELETE',
                        type: 'DELETE',
                        url: APP_URL + 'admin/master-copy/' + $$.data('id'),
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
                                redirect('/admin/master-copy');
                            }
                        } else {
                            notify('error', 'We have encountered an error. Please contact your System Administrator');
                        }
                    }).fail(function (xhr, status) {
                        handler(xhr, status)
                    });
                }
            });
        });
    </script>

@endsection

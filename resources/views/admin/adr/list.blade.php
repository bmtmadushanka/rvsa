@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">ADRs</h2>
                    <div class="float-right">
                        <a type="button" class="btn btn-outline-primary float-right" href="{{ route('adr.create') }}"><i class="fas fa-plus mr-1"></i> New ADR</a>
                    </div>
                </div>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block nk-block-lg">
            <div class="card card-preview p-0">
                <div class="card-inner p-0">
                    <table class="table table-bordered table-hover bg-white">
                        <thead>
                        <tr>
                            <th class="text-right" style="width:120px">Number</th>
                            <th class="text-center" style="width:100px">Status</th>
                            <th>Name</th>
                            <th style="width: 120px">User Created</th>
                            <th style="width: 120px">Date Created</th>
                            <th class="text-center" style="width:80px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($adrs AS $adr)
                            <tr>
                                <td class="text-right align-middle">{{ $adr->number }}</td>
                                <td class="text-center align-middle"><span class="badge badge-status badge-{{ $adr->status['color'] }}">{{ $adr->status['text'] }}</span></td>
                                <td class="align-middle">{{ $adr->name }}</td>
                                <td class="align-middle">{{ $adr->author->first_name }}</td>
                                <td class="align-middle">{{ $adr->created_at->toDateString() }}</td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-sm btn-outline-primary mr-1 btn-preview-adr d-none" data-id="{{ $adr->id }}"><em class="icon ni ni-eye"></em> </button>
                                    <a class="btn btn-sm btn-outline-secondary mr-1 {{ $adr->is_common_adr ? "disabled" : "" }}" href='{{ !$adr->is_common_adr ? ("/admin/adr/$adr->id/edit") : '' }}'><em class="icon ni ni-edit-alt"></em></a>
                                    <button class="btn btn-sm btn-outline-danger mr-1 {{ $adr->is_common_adr ? "disabled" : "btn-delete-adr" }}" data-id="{{ $adr->id }}"><em class="icon ni ni-trash"></em></button>
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
        $('body').on('click', '.btn-preview-adr', function() {
            let params = 'scrollbars=no,resizable=yes,status=no,location=no,toolbar=no,menubar=no,width='+ screen.availWidth +',height=' + screen.availHeight;

            let newWindow = open(APP_URL + 'admin/adr/' + $(this).data('id'), 'example', params)
            newWindow.focus();
        });

        $('body').on('click', '.btn-delete-adr', function() {
            let $$ = $(this);

            Swal.fire(confirmSwal('Are you sure that you want to delete the ADR? Once done, the action cannot be undone.')).then((result) => {
                if (result.value) {
                    $.ajax({
                        cache: false,
                        method: 'DELETE',
                        type: 'DELETE',
                        url: APP_URL + 'admin/adr/' + $$.data('id'),
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
                                redirect('/admin/adr');
                            }
                        } else {
                            notify('error', 'We have encountered an error. Please contact your IT Department');
                        }
                    }).fail(function (xhr, status) {
                        handler(xhr, status)
                    });
                }
            });
        });
    </script>
@endsection

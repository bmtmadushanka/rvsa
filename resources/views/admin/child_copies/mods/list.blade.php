@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/child-copy"><em class="icon ni ni-arrow-left"></em><span>Child Copies</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1"> Modifications</h2>
                    <div class="float-right">
                        <a type="button" class="btn btn-outline-primary float-right" href="/admin/child-copy/{{ $childCopy->id }}/mods/create" id="btn-create-master-copy"><em class="icon ni ni-plus-sm"></em> Add Variant</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" style="width:80px">Status</th>
                            <th>Variant</th>
                            <th class="text-center" style="width: 150px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($childCopy->mods AS $mod)
                        <tr>
                            <td class="text-center align-middle"><span class="badge badge-status badge-{{ $mod->status['color'] }}">{{ $mod->status['text'] }}</span></td>
                            <td class="align-middle">Variant {{ $mod->variant_id }} {{ $mod->variant_id === 1 ? ' (General)' : '' }}</td>
                            <td class="text-center text-nowrap">
                                <a class="btn btn-sm btn-outline-secondary mr-1" href="/admin/child-copy/{{ $childCopy->id }}/mods/{{ $mod->id }}/edit" title="Edit Child Copy"><em class="icon ni ni-edit-alt"></em></a>
                                <button type="button" class="btn btn-sm btn-outline-danger mr-1 {{ $mod->variant_id == 1 ? '' : 'btn-delete-variant' }}" {{ $mod->variant_id == 1 ? 'disabled="disabled"' : '' }} data-id="{{ $mod->id }}" title="Delete Variant"><em class="icon ni ni-trash"></em></button>
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
        $(function() {
            $('body').on('click', '.btn-delete-variant', function() {
                let $$ = $(this);

                Swal.fire(confirmSwal('Are you sure that you want to delete the Variant? Once done, the action cannot be undone.')).then((result) => {
                    if (result.value) {
                        $.ajax({
                            cache: false,
                            method: 'DELETE',
                            type: 'DELETE',
                            url: APP_URL + 'admin/child-copy/'+ {{ $childCopy->id }} +'/mods/' + $$.data('id'),
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
                                    redirect('/admin/child-copy/'+ {{ $childCopy->id }} +'/mods');
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
        });
    </script>
@endsection

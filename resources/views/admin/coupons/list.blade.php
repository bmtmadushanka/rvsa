@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">Coupons</h2>
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-primary float-right" id="btn-new-coupon"><em class="ni ni-plus mr-1"></em> New Coupon</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            @include('layouts.messages')
            <div class="card card-preview">
                <div class="card-inner">
                    <table class="datatable-init table">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 80px">Status</th>
                            <th class="text-center" style="width: 80px">Type</th>
                            <th>Code</th>
                            <th style="width: 50px">Discount</th>
                            <th class="text-center text-nowrap" style="width: 120px">Valid From</th>
                            <th class="text-center text-nowrap" style="width: 120px">Valid To</th>
                            <th class="text-nowrap">Created By</th>
                            <th class="text-center" style="width: 50px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($coupons AS $coupon)
                            <tr>
                                <td style="width: 80px" class="align-middle text-center text-nowrap">
                                    <span class="badge badge-status badge-{{ $coupon->status_formatted['color'] }} justify-content-center" style="width: 65px">{{ ucfirst($coupon->status_formatted['text']) }}</span>
                                </td>
                                <td style="width: 80px" class="align-middle text-center text-nowrap">
                                    <span class="badge badge-status badge-secondary justify-content-center" style="width: 65px">{{ $coupon->type === 'one-off' ? 'One Off' : 'Indefinite' }}</span>
                                </td>
                                <td class="align-middle">{{ $coupon->code }}</td>
                                <td style="width: 50px" class="align-middle text-right pr-4">{{ $coupon->discount }}%</td>
                                <td class="align-middle text-center">{{ $coupon->valid_from ?? '-' }}</td>
                                <td class="align-middle text-center">{{ $coupon->valid_to ?? '-' }}</td>
                                <td style="width: 80px">{{ $coupon->creator->first_name }}<br/><small class="text-muted">{{ date('Y-m-d', strtotime($coupon->created_at)) }}</small></td>
                                <td style="width: 50px" class="text-center text-nowrap">
                                    <button type="button" class="btn btn-sm btn-outline-secondary justify-content-center mr-1 btn-edit-coupon" data-id="{{ $coupon->id }}"><em class="icon ni ni-pen"></em></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger justify-content-center mr-1 btn-delete-entity" data-url="admin/coupon" data-entity="coupon" data-id="{{ $coupon->id }}"><em class="icon ni ni-trash"></em></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="/css/plugins/bootstrap-datetimepicker.min.css" />
    @endpush
    @push('scripts-post')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment-with-locales.min.js"></script>
        <script src="/js/plugins/bootstrap-datetimepicker.min.js"></script>
    @endpush
    <script>

        $(function() {

            $('body').on('click', '#btn-new-coupon, .btn-edit-coupon ', function() {
                let $$ = $(this)

                let url = APP_URL + 'admin/coupon/create';
                if ($$.data('id')) {
                    url = APP_URL + 'admin/coupon/' + $$.data('id') + '/edit';
                    loadingButton($$, true, false);
                } else {
                    loadingButton($$);
                }

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
                            myModal.find('.modal-dialog').removeClass('modal-sm modal-lg modal-xl');
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
@endsection

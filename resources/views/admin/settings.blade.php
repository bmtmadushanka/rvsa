@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <h2 class="nk-block-title fw-normal">Company Details</h2>
            </div>
        </div>
        @include('layouts.messages')
        <div class="nk-block nk-block-lg">
            <div class="bg-white p-4">
                <div class="card card-preview">
                    <div class="card-inner">
                        <form class="form custom-form-inline" method="POST" action="/admin/settings" enctype="multipart/form-data" >
                            @csrf
                            @method('patch')
                            <h4 class="mb-5 fw-normal pb-2 border-bottom">Company Info</h4>
                            <div class="mb-4 pb-2">
                                <div class="form-group d-flex w-100">
                                    <label class="form-label required" for="input-company-name">Name</label>
                                    <div class="form-control-wrap w-100">
                                        <input type="text" class="form-control" id="input-company-name" name="company_name" autocomplete="off" value="{{ old('company_name') ?? ($settings->company_name ?? '') }}" required maxlength="150" placeholder="Enter Company Name">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 pb-2">
                                <div class="form-group d-flex w-100">
                                    <label class="form-label required" for="input-company-address">Address</label>
                                    <div class="form-control-wrap w-100">
                                        <input type="text" class="form-control" id="input-company-address" name="company_address" autocomplete="off" value="{{ old('company_address') ?? ($settings->company_address ?? '') }}" required maxlength="300" placeholder="Enter Company Address">
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-5">
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-company-code" style="width: 250px">Code</label>
                                            <div class="form-control-wrap w-100">
                                                <input type="text" class="form-control" id="input-company-code" name="company_code" autocomplete="off" value="{{ old('company_code') ?? ($settings->company_code ?? '') }}" required maxlength="10" placeholder="Enter Company Code">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2 ml-md-5">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-company-acn" style="width: 150px">ACN</label>
                                            <div class="form-control-wrap w-100">
                                                <input type="text" class="form-control" id="input-company-acn" name="company_acn" autocomplete="off" value="{{ old('company_acn') ?? ($settings->company_acn ?? '') }}" required maxlength="150" placeholder="Enter Company ACN">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-company-test-facility-id" style="width: 250px">Test Facility ID</label>
                                            <div class="form-control-wrap w-100">
                                                <input type="text" class="form-control" id="input-company-test-facility-id" name="company_test_facility_id" autocomplete="off" value="{{ old('company_test_facility_id') ?? ($settings->company_test_facility_id ?? '') }}" required maxlength="150" placeholder="Enter Company Test Facility ID">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-5">
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-company-email" style="width: 250px">Email</label>
                                            <div class="form-control-wrap w-100">
                                                <input type="text" class="form-control" id="input-company-email" name="company_email" autocomplete="off" value="{{ old('company_email') ?? ($settings->company_email ?? '') }}" required maxlength="150" placeholder="Enter Company Email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-5">
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-company-contact-no" style="width: 250px">Contact No</label>
                                            <div class="form-control-wrap w-100">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="input-company-contact-no" name="company_contact_no" autocomplete="off" value="{{ old('company_contact_no') ?? ($settings->company_contact_no ?? '') }}" required placeholder="Enter Company Contact No">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2 ml-md-5">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-company-web" style="width: 150px">Web</label>
                                            <div class="form-control-wrap w-100">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">www</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="input-company-web" name="company_web" autocomplete="off" value="{{ old('company_web') ?? ($settings->company_web ?? '') }}" required maxlength="150" placeholder="Enter Company Web">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-5">
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-company-logo" style="width: 250px">Logo</label>
                                            <div class="form-control-wrap w-100">
                                                <div class="border bg-gray-100 p-2">
                                                    <img src="{{ config('app.asset_url') }}images/logos/{{ $settings->company_logo }}" alt="Company Logo" height="55px" />
                                                </div>
                                                <div class="custom-file mt-2">
                                                    <input type="file" class="custom-file-input" name="logo" id="customFile">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<h4 class="my-5 fw-normal pb-2 border-bottom">Default RAW Details</h4>
                            <div class="mb-4 pb-2">
                                <div class="form-group d-flex w-100">
                                    <label class="form-label required" for="input-raw-company-name">Company Name</label>
                                    <div class="form-control-wrap w-100">
                                        <input type="text" class="form-control" id="input-raw-company-name" name="default_raw_company_name" autocomplete="off" value="{{ old('default_raw_company_name') ?? ($settings->default_raw_company_name ?? '') }}" required maxlength="150" placeholder="Enter Company Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-5">
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-raw-id" style="width: 250px">Raw ID</label>
                                            <div class="form-control-wrap w-100">
                                                <input type="text" class="form-control" id="input-raw-id" name="default_raw_id" autocomplete="off" value="{{ old('default_raw_id') ?? ($settings->default_raw_id ?? '') }}" required maxlength="150" placeholder="Enter Company Code">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 pb-2 ml-md-5">
                                        <div class="form-group d-flex w-100">
                                            <label class="form-label required" for="input-default-abn" style="width: 150px">ABN</label>
                                            <div class="form-control-wrap w-100">
                                                <input type="text" class="form-control unsigned-integer" id="input-default-abn" name="default_abn" autocomplete="off" value="{{ old('default_abn') ?? ($settings->default_abn ?? '') }}" required minlength="11" maxlength="11" placeholder="Enter Company ABN">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 pb-2">
                                <div class="form-group d-flex w-100">
                                    <label class="form-label required" for="input-default-address">Address</label>
                                    <div class="form-control-wrap w-100">
                                        <input type="text" class="form-control" id="input-default-address" name="default_address" autocomplete="off" value="{{ old('default_address') ?? ($settings->default_address ?? '') }}" required maxlength="300" placeholder="Enter Company Name">
                                    </div>
                                </div>
                            </div> --}}
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                            </div>
                        </form>
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

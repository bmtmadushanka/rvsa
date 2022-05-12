@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">My Notifications  <button class="btn btn-sm btn-outline-secondary d-lg-none d-sm-inline-block" id="btn-toggle-notification-aside"><em class="icon ni ni-align-justify"></em></button></h2>
                    <div class="float-right">
                        {{--<a type="button" class="btn btn-outline-primary float-right mt-2" href="{{ route('web-user-new-message') }}"><i class="fas fa-plus mr-1"></i> New Message</a>--}}
                    </div>
                </div>
                <h2 class="nk-block-title fw-normal"></h2>
            </div>
        </div>
        @include('layouts.messages')
        <div class="nk-block nk-block-lg">
            <div class="nk-ibx">
                @include('web.notifications.aside')
                <div class="nk-ibx-body bg-white wrapper-table-notifications">
                    @include('web.notifications.content')
                </div>
            </div>
        </div>
    </div>
    <style>
        .components-preview.preview-sm .nk-ibx-aside {

            position: static;
            transform: none;
            transition: none;
            width: 215px;

        }
    </style>
    <script>
        $(document).ready( function () {

            $('.datatable').DataTable({
                dom: 'flrtip',
                pageLength: 50,
                bPaginate: true,
                bLengthChange: true,
                bFilter: true,
                bInfo: true,
                bAutoWidth: true,
                order: [],
                scrollY:  '500px',
                scrollCollapse: true,
            });
        });

        $('body').on('click', '#btn-toggle-notification-aside', function() {
            $(this).closest('div.components-preview').toggleClass('preview-sm')
        });
    </script>
@endsection

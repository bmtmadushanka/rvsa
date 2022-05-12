@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1">Pending Approvals</h2>
                </div>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="card card-bordered wrapper-table-notifications">
                <div class="card-inner">
                    <div class="nk-ibx">
                        <div class="nk-ibx-body bg-white p-2 wrapper-table-notifications" style="max-width: 100%">
                            @include('layouts.approvals.list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {

            $('.datatable').DataTable({
                "dom": 'flrtirp',
                "pageLength": 50,
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bInfo": true,
                "bAutoWidth": false,
                "order": []
            });
        });
    </script>

@endsection

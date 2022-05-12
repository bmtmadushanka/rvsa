@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="components-preview">
                <div class="nk-block-head nk-block-head-lg">
                    <div class="nk-block-head-content">
                        <div class="nk-block-head-sub"><a class="back-to" href="/admin/dashboard"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a></div>
                        <h2 class="nk-block-title fw-normal">Master Copies</h2>
                    </div>
                </div>
                <div class="nk-block nk-block-lg">

                    <div class="row d-flex align-items-center">
                        <div class="col flex-column">
                            <div class="card card-bordered" style="width: 500px">
                                <div class="card-header border-bottom">Existing Blueprints</div>
                                <ul class="list-group list-group-flush" style="height: 550px; overflow-y: auto">
                                    @foreach ($blueprints AS $page => $blueprint)
                                        <li class="list-group-item" data-id="{{ $page }}">{{ $page . '.' }} {{ $blueprint }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col flex-column">
                            <div class="">
                                <button type="button" class="d-block mb-1 btn btn-outline-dark" style="width: 110px" id="add-blank-page">Add Blank</button>
                                <button type="button" class="d-block mb-1 btn btn-outline-secondary" style="width: 110px" id="add-blank-page">Add All</button>
                                <button type="button" class="d-block mb-1 btn btn-outline-primary" style="width: 110px" id="add-blank-page">Add</button>
                                <button type="button" class="d-block mb-1 btn btn-outline-danger" style="width: 110px" id="add-blank-page">Remove</button>
                                <button type="button" class="d-block mb-1 btn btn-outline-secondary" style="width: 110px" id="add-blank-page">Remove All</button>
                            </div>
                        </div>
                        <div class="col flex-column">
                            <div class="card card-bordered" style="width: 500px">
                                <div class="card-header border-bottom">New Master Copy</div>
                                <form class="form" method="get" action="">
                                    <ul class="list-group list-group-flush" style="height: 500px; overflow-y: auto">
                                        <li class="list-group-item">Cras justo odio</li>
                                        <li class="list-group-item">Dapibus ac facilisis in</li>
                                        <li class="list-group-item">Vestibulum at eros</li>
                                    </ul>
                                    <div class="p-2 text-center border-top" style="background: #f9f9f9">
                                        <button type="button" class="btn btn-sm btn-info" id="btn-create-master-copy">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('body').on('click', '#btn-create-master-copy', function() {
            let params = 'scrollbars=no,resizable=yes,status=no,location=no,toolbar=no,menubar=no,width='+ screen.availWidth +',height=' + screen.availHeight;

            let newWindow = open('/admin/master-copy/create', 'example', params)
            newWindow.focus();
        });
    </script>

@endsection

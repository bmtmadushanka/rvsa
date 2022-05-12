@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/child-copy"><em class="icon ni ni-arrow-left"></em><span>Child Copies</span></a></div>
                <h3 class="nk-block-title fw-normal flex-grow-1">
                    @if (isset($childCopy))
                        Edit Child Copy - {{ $childCopy->make }} {{ $childCopy->model }}-{{ $childCopy->model_code }}
                    @else
                        New Child Copy - Master ({{ $master->name }})
                    @endif
                </h3>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    @if (isset($childCopy))
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ !isset($_GET['tab']) ? 'active': '' }}" data-toggle="tab" href="#tabChildReport">Child Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ isset($_GET['tab']) && $_GET['tab'] === 'adrs' ? 'active': '' }}" data-toggle="tab" href="#tabAdrs">ADRs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabVersionChanges">Version Changes</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane pt-1 {{ !isset($_GET['tab']) ? 'active': '' }}" id="tabChildReport">
                            @include('admin.child_copies.partials.create.user_inputs')
                        </div>
                        <div class="tab-pane pt-1 {{ isset($_GET['tab']) && $_GET['tab'] === 'adrs' ? 'active': '' }}" id="tabAdrs">
                            @include('admin.child_copies.adrs_list')
                        </div>
                        <div class="tab-pane pt-1" id="tabVersionChanges">
                            @if (isset($childCopy->versionChanges->data))
                                @include('admin.child_copies.version_changes')
                            @else
                                <div class="text-center border" style="padding: 80px">
                                    <em class="icon ni ni-info mr-1 fs-20px pos-rel" style="top: 3px"></em> This is the very first version of this report. Therefore no changes available
                                </div>
                            @endif
                        </div>
                    </div>
                    @else
                        @include('admin.child_copies.partials.create.user_inputs')
                    @endif
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
@endsection

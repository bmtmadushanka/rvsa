@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/child-copy/{{ $childCopy->id }}/mods"><em class="icon ni ni-arrow-left"></em><span>Modifications</span></a></div>
                <div class="d-flex">
                    <h2 class="nk-block-title fw-normal flex-grow-1"> {{ isset($mod) ? 'Edit' : 'Create' }} Variant {{ isset($mod) ? ($mod->variant_id == 0 ? '- General' : '- ' . $mod->variant_id) : '' }}</h2>
                </div>
            </div>
        </div>
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <form class="ajax form scrollable" method="POST" action="/admin/child-copy/{{ $childCopy->id }}/mods{{ isset($mod) ? '/' . $mod->id : '' }}" enctype="multipart/form-data" onsubmit="return false;">
                    @isset($mod) {{ method_field('PATCH') }} @endif
                    @csrf
                    <div class="card card-preview">
                        <div class="card-inner">
                            @include('admin.child_copies.partials.mods.pre', ['key' => 'pre', 'prefix' => 'pre'])
                            @include('admin.child_copies.partials.mods.post', ['key' => 'post', 'prefix' => 'post'])
                            @if(isset($mod) && $mod->variant_id != 1)
                                <div class="col-sm-12 col-md-6 pl-0 mt-3 mb-5">
                                    <div class="form-group mb-4 pb-1 d-flex">
                                        <label class="form-label required pt-1 mr-4" for="input-variant-id">Variant ID</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control w-100" id="input-variant-id" name="variant_id" value="{{ $mod->variant_id }}" maxlength="2" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="text-center mb-2">
                                <a type="button" class="btn btn-outline-secondary" href="/admin/child-copy/{{ $childCopy->id }}/mods">Cancel</a>
                                <button type="button" class="btn btn-outline-primary" id="btn-save-mods">Save</button>
                                <input type="hidden" name="is_new_version" value="0" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="/css/plugins/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="/plugins/selectize/selectize.min.css" />
    @endpush
    @push('scripts-post')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment-with-locales.min.js"></script>
        <script src="/js/plugins/bootstrap-datetimepicker.min.js"></script>
        <script src="/plugins/selectize/selectize.min.js"></script>
    @endpush
    <script>
        $(function() {
            activateSelectize();

            $('body').on('click', '#btn-save-mods', function() {
                loadingButton($(this));
                validateChildCopyInputs($(this), 0, {{ $variant->id ?? 0 }});
            })
        })
    </script>
@endsection

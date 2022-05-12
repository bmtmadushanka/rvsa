@extends('layouts.master')
@section('content')
    <div class="components-preview">
        <div class="nk-block-head nk-block-head-lg">
            <div class="nk-block-head-content">
                <div class="nk-block-head-sub"><a class="back-to" href="/admin/{{ isset($child_copy_id) ? "child-copy/$child_copy_id/edit" : 'adr' }}"><em class="icon ni ni-arrow-left"></em><span>{{ isset($child_copy_id) ? 'Child ' : '' }}ADRs</span></a></div>
                <h2 class="nk-block-title fw-normal flex-grow-1">
                    {{ isset($child_copy_id) ? 'Edit Child Copy' : (isset($adr) ? 'Edit' : 'New') }} ADR {{ isset($adr) ? (' - '. $adr->number) : '' }}
                </h2>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    <form class="form ajax scrollable" method="POST" action="{{ $action }}{{ isset($adr) ? '/' . $adr->id : ''}}" id="form-create-adr">
                        @isset($adr) {{ method_field('PATCH') }} @endif
                        @csrf
                        <div id="tinymce" class="container" style="height: 4000px">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex mt-5">
                                        <div class="form-group mr-3 mb-3">
                                            <label class="required" for="input-adr-no">ADR No</label>
                                            <div class="input-group" style="width: 200px">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">ADR</span>
                                                </div>
                                                <input type="text" class="form-control" name="number" id="input-adr-no" value="{{ $adr->number ?? '' }}" {{ isset($adr) && $adr->is_common_adr ? 'disabled=disabled' : '' }} maxlength="10" autocomplete="off" required style="width: 80px"/>
                                            </div>
                                            <div class="feedback"></div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-group">
                                                <label class="required" for="input-adr-name">ADR Name</label>
                                                <input type="text" class="form-control" name="name" id="input-adr-name" maxlength="150" value="{{ $adr->name ?? '' }}" autocomplete="off" required />
                                                <div class="feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <textarea class="w-100 text-center" name="content[description]" style="height: 500px" id="textarea-adr-specific-details">@if (!empty($adr->html)){!! json_decode(html_entity_decode($adr->text)) !!} @else Loading.... @endif</textarea>
                                    </div>
                                    <div class="card border-0 mt-5" id="wrapper-evident-supporting-info">
                                        <label class="font-weight-bold" for="input-sev-entry-no">Evidence Supporting Info</label>
                                        @foreach ($evidence_types AS $evidence_type)
                                            <div class="{{ !$loop->first ? 'mt-4' : 'mt-3' }}">
                                                <div class="form-check">
                                                    <input class="form-check-input checkbox-evidence-support" type="checkbox" {{ isset($adr->evidence) && in_array($evidence_type, array_keys($adr->evidence)) ? 'checked=checked' : '' }} id="checkbox-{{ Str::kebab($evidence_type) }}">
                                                    <label class="form-check-label" for="checkbox-{{ Str::kebab($evidence_type) }}">{{ $evidence_type }}</label>
                                                </div>
                                                <div class="mt-3 ml-4 wrapper-textarea-supporting-evidence" style="display: {{ isset($adr->evidence) && in_array($evidence_type, array_keys($adr->evidence)) ? 'block' : 'none' }}">
                                                    <textarea class="w-100 mb-4 textarea-supporting-evidence" name="content[evidence][{{ $evidence_type }}]" rows="15">@if (isset($adr->evidence) && in_array($evidence_type, array_keys($adr->evidence))){!! $adr->evidence[ $evidence_type] !!}@endif</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @isset($child_copy_id)
                                        <div class="form-group mt-5">
                                            <label class="form-label" for="customFileLabel">Default File Upload</label>
                                            @if ($adr->pdf)
                                            <div class="border bg-gray-100 p-2 my-2" style="width: 400px;">
                                                <a href="/uploads/adrs/{{ $adr->pdf }}" download>
                                                    <em class="icon ni ni-file-pdf" style="font-size: 35px"></em>
                                                    <span style="position: relative; bottom: 10px">{{ $adr->pdf }}</span>
                                                </a>
                                                <div class="float-right"><a class="btn btn-sm btn-outline-danger mt-1 btn-remove-attachment"><em class="icon ni ni-cross"></em></a></div>
                                            </div>
                                            @endif
                                            <div class="form-control-wrap" style="width: 400px;">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="document" id="customFile" accept="application/pdf">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                            <div class="feedback"></div>
                                        </div>
                                    @endif
                                    <div class="text-center mt-5 pt-5">
                                        {{--<button type="button" class="btn btn-outline-secondary justify-content-center align-middle" id="btn-preview-adr"><em class="icon ni ni-eye mr-1"></em> PREVIEW</button>--}}
                                        <button type="button" class="btn btn-outline-primary justify-content-center align-middle btn-update-child-adr" style="width: 120px"><em class="icon ni ni-save mr-1"></em>{{ isset($adr) ? 'Update' : 'Save' }}</button>
                                        <button type="submit" style="display: none"></button>
                                        @isset($child_copy_id)
                                            <input type="hidden" name="is_new_version" value="0" />
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <script>

                        $('body').on('click', '.btn-update-child-adr', function() {

                            let $$ = $(this);
                            loadingButton($$);
                            form = $$.closest('form');

                            form[0].reportValidity()

                            if (form.valid()) {

                                if (form.find('input[name="is_new_version"]').length) {

                                    Swal.fire(confirmSwal('Do you want to do save the changes as a new version?', true)).then((result) => {
                                        if (result.value) {
                                            form.find('input[name="is_new_version"]').val(1);
                                        }
                                        if (typeof result.value != 'undefined') {
                                            $$.next().click();
                                        }
                                    });

                                } else {
                                    $$.next().click();
                                }
                            }

                            setTimeout(function() {
                                loadingButton($$, false);
                            }, 2000);

                        });

                        $('body').on('click', '.checkbox-evidence-support', function() {
                            let $$ = $(this);
                            if($$.is(':checked')) {
                                $$.closest('div.form-check').next().slideDown('fast');
                            } else {
                                let textarea = $$.closest('div.form-check').next().find('textarea');
                                tinymce.get(textarea.attr('id')).setContent('');
                                textarea.closest('div').hide();
                            }
                        })

                        $('body').on('click', '.btn-remove-attachment', function() {
                            let $$ = $(this);
                            Swal.fire(confirmSwal('Are you sure that you want to delete the attachment? Once done, the action cannot be undone.')).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        cache: false,
                                        method: 'DELETE',
                                        type: 'DELETE',
                                        url: APP_URL + 'admin/adr/' + {{ $adr->id ?? 0 }} + '/attachment',
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
                                                location.reload();
                                            }
                                        } else {
                                            notify('error', 'We have encountered an error. Please contact your System Administrator');
                                        }
                                    }).fail(function (xhr, status) {
                                        handler(xhr, status)
                                    })
                                }
                            })
                        });

                        $(document).ready(function() {
                            tinymce.init({
                                selector: 'textarea#textarea-adr-specific-details',
                                menubar: false,
                                plugins: 'autolink lists code table image paste charmap',
                                toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist checklist | bullchecklist code pageembed permanentpen table image charmap| customCheckBoxY customCheckbox customArrow vin',
                                toolbar_mode: 'floating',
                                content_css: "/css/tinymce.css?v=1.1.6",
                                auto_focus: false,
                                relative_urls : false,
                                remove_script_host : false,
                                document_base_url : APP_URL,
                                forced_root_block: true,
                                images_upload_handler: function (blobInfo, success, failure) {
                                    var xhr, formData;
                                    xhr = new XMLHttpRequest();
                                    xhr.withCredentials = false;
                                    xhr.open('POST', '/admin/adr/images');
                                    xhr.onload = function() {
                                        var json;

                                        if (xhr.status != 200) {
                                            notify('HTTP Error: ' + xhr.status);
                                            return;
                                        }
                                        json = JSON.parse(xhr.responseText);

                                        if (!json || typeof json.data.url != 'string') {
                                            notify('Invalid Request: ' + xhr.responseText);
                                            return;
                                        }
                                        success(json.data.url);
                                    };
                                    formData = new FormData();
                                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                                    formData.append('_token', $('meta[name=csrf-token]').attr('content'));
                                    xhr.send(formData);
                                },
                                setup: function (editor) {
                                    @if (!isset($adr))
                                    editor.on('init', function (e) {
                                        editor.setContent('<table id="table-adr-default" style="border-collapse: collapse; margin-bottom:0; width: 100%" border="1"><tbody><tr><td class="text-center"><strong>Component / Deterioration / Modification details as applicable</strong></td><td class="text-center w-75px" style="width: 75px"><strong>RAW</strong></td><td class="text-center w-75px" style="width: 75px"><strong>AVV</strong></td> </tr>' +
                                            '<tr><td><b>Component:</b>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td><b>Deterioration:</b>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>' +
                                            '<tr><td><b>Modification(s):</b>&nbsp;None required for this vehicle.</td> <td>&nbsp;</td> <td>&nbsp;</td></tr>' +
                                            '<tr><td class="text-left" colspan="3">Comments: <div style="position:relative; top: -22px; right:18px; height: 10px !important"><div class="float-right" style="width: 250px; height: inherit"><span class="fw-bold mr-3">AVV Approved: </span><span class="fw-bold"><span class="mr-3 mt-1 d-inline-block" style="width: 45px !important">Y <span class="checkbox">&nbsp;</span>&nbsp;</span><span class="mt-1 mr-1 d-inline-block" style="width: 60px">N <span class="checkbox">&nbsp;</span></span></span></div></div></td></tr>' +
                                            '</tbody></table><div class="adr-content" style="padding-top:15px"><b>EVIDENCE PACK:</b> (For Author & Department use only)<div><b>Unique document reference:</b> <span class="placeholder" data-id="1">Reference</span> <span class="ml-75"><b>Version:</b>&nbsp; VS</span> </div> <div> <span> <b>1/ Compliance Method:</b> Compliance with Overseas Standards </span> <span class="ml-75"> <b>Extent of Compliance:</b> Full</span></div></div><div>&nbsp;</div>');
                                    });
                                    @endif
                                    editor.ui.registry.addButton('customCheckBoxY', {
                                        icon: 'gamma',
                                        tooltip: 'Insert Custom Check Box',
                                        onAction: function (_) {
                                           editor.insertContent('<span class="d-inline-block" style="width: 55px; white-space: nowrap; margin-left: 15px;">Y <input type="checkbox" class="checkbox rawcheck"></span>');
                                        }
                                    }),
                                    editor.ui.registry.addButton('customCheckBox', {
                                        icon: 'unselected',
                                        tooltip: 'Insert Custom Empty CheckBox',
                                        onAction: function (_) {
                                            editor.insertContent('<span class="d-inline-block" style="width: 10px; white-space: nowrap; margin-left: 10px; margin-right: 20px"><input type="checkbox" class="checkbox checkbox-inline avvcheck">&nbsp;&nbsp;</span>&nbsp;');
                                        }
                                    }),
                                    editor.ui.registry.addButton('customArrow', {
                                        icon: 'arrow-right',
                                        tooltip: 'Insert Custom Arrow',
                                        onAction: function (_) {
                                            editor.insertContent('<img src="/images/arrow.png" alt="" width="15" height="14" />&nbsp;');
                                        }
                                    }),
                                    editor.ui.registry.addButton('vin', {
                                        icon: 'code-sample',
                                        tooltip: 'Insert VIN Number',
                                        onAction: function (_) {
                                            editor.insertContent('<span class="placeholder" data-id="2">VIN</span>&nbsp;');
                                        }
                                    })

                                }
                            });

                            tinymce.init({
                                selector: '.textarea-supporting-evidence',
                                menubar: false,
                                plugins: 'autolink lists code table image charmap',
                                toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist checklist | bullchecklist code pageembed permanentpen table image charmap | customCheckBoxY customCheckbox customArrow vin',
                                toolbar_mode: 'floating',
                                content_css: "/css/tinymce.css?v=1.1.6",
                                auto_focus: false,
                                relative_urls : false,
                                remove_script_host : false,
                                document_base_url : APP_URL,
                                forced_root_block: true,
                                images_upload_handler: function (blobInfo, success, failure) {
                                    var xhr, formData;
                                    xhr = new XMLHttpRequest();
                                    xhr.withCredentials = false;
                                    xhr.open('POST', '/admin/adr/images');
                                    xhr.onload = function() {
                                        var json;

                                        if (xhr.status != 200) {
                                            notify('HTTP Error: ' + xhr.status);
                                            return;
                                        }
                                        json = JSON.parse(xhr.responseText);

                                        if (!json || typeof json.data.url != 'string') {
                                            notify('Invalid Request: ' + xhr.responseText);
                                            return;
                                        }
                                        success(json.data.url);
                                    };
                                    formData = new FormData();
                                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                                    formData.append('_token', $('meta[name=csrf-token]').attr('content'));
                                    xhr.send(formData);
                                },
                                height: 400,
                                setup: function (editor) {
                                    editor.ui.registry.addButton('customCheckBoxY', {
                                        icon: 'gamma',
                                        tooltip: 'Insert Custom Check Box',
                                        onAction: function (_) {
                                            editor.insertContent('<span class="d-inline-block" style="width: 55px; white-space: nowrap; margin-left: 15px;">Y <span class="checkbox">&nbsp;</span></span>&nbsp;');
                                        }
                                    }),
                                    editor.ui.registry.addButton('customCheckBox', {
                                        icon: 'unselected',
                                        tooltip: 'Insert Custom Empty CheckBox',
                                        onAction: function (_) {
                                            editor.insertContent('<span class="d-inline-block" style="width: 10px; white-space: nowrap; margin-left: 10px; margin-right: 20px"><span class="checkbox checkbox-inline">&nbsp;</span>&nbsp;</span>&nbsp;');
                                        }
                                    }),
                                    editor.ui.registry.addButton('customArrow', {
                                        icon: 'arrow-right',
                                        tooltip: 'Insert Custom Arrow',
                                        onAction: function (_) {
                                            editor.insertContent('<img src="/images/arrow.png" alt="" width="15" height="14" />&nbsp;');
                                        }
                                    }),
                                    editor.ui.registry.addButton('vin', {
                                        icon: 'code-sample',
                                        tooltip: 'Insert VIN Number',
                                        onAction: function (_) {
                                            editor.insertContent('<span class="placeholder" data-id="2">VIN</span>&nbsp;');
                                        }
                                    })
                                }
                            });

                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
    @push('scripts-pre')
        <script src="https://cdn.tiny.cloud/1/0q55drcnhujbp3gq2knv9wsb2xg2aand0w64gvbfzsh685jd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    @endpush
@endsection

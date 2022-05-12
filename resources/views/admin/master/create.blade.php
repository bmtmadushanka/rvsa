<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>Model Report</title>
    <link rel="stylesheet" type="text/css" href="/css/plugins/a4-configs.css?v=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/0q55drcnhujbp3gq2knv9wsb2xg2aand0w64gvbfzsh685jd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="/js/script.js?ver=1.1.1"></script>
    <script src="/assets/js/bundle.js?ver=2.8.0"></script>
    <script src="/assets/js/scripts.js?ver=2.8.0"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const APP_URL = "{!! url('/') !!}/";
    </script>
    <style>
        @font-face {
            font-family: 'Calibri';
            font-weight: normal;
            src: url({{ storage_path('/fonts/Calibri Regular.ttf')}})  format('truetype');
        }

        @font-face {
            font-family: 'Calibri';
            font-weight: bold;
            src: url({{ storage_path('/fonts/Calibri Bold.ttf')}})  format('truetype');
        }

        .header {
            background: #29347a;
            color: #fff;
            border-bottom: 1px solid #3644a0;
            position: absolute;
            top: 0;
            width: 100%;
            left: 0;
            padding: 10px 75px;
        }

        button {
            cursor: pointer;
        }

        .page.footer {
            min-height: 0px;
            padding: 30px;
            text-align: center;
        }

        #toast-container > div {
            opacity: 1;
        }

        #overlay {
            position: fixed; /* Sit on top of the page content */
            width: 100%; /* Full width (cover the whole page) */
            height: 100%; /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5); /* Black background with opacity */
            z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
            cursor: pointer; /* Add a pointer on hover */
        }

        #overlay-text{
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 20px;
            color: white;
            transform: translate(-50%,-50%);
            -ms-transform: translate(-50%,-50%);
            font-weight: normal;
        }

    </style>

</head>
<body>
    <div id="overlay">
        <div id="overlay-text">Loading. Please Wait!</div>
    </div>
    <form class="form ajax scrollable" method="POST" action="admin/master-copy{{ isset($masterCopy) ? '/' .$masterCopy->id : '' }}" data-callback="callback_create_master">
        @isset($masterCopy) {{ method_field('PATCH') }} @endif
        @csrf
        <div class="document">
            <div class="page" style="display: none">
                <div class="header">
                    <label>Page: </label>
                    <input type="hidden" name="page[]" value="0" />
                    <input type="hidden" name="is_delete[]" value="0" />
                    <input type="number" name="sort_order[]" value="" style="height: 35px; width: 70px; text-align: right; margin-top: 2px" />
                    <input type="hidden" name="blueprint_id[]" value=""/>
                    <div style="float:right">
                        <button type="button" style="margin-top: 3px; padding: 8px 10px" class="btn-add-page" data-location="before"><i class="fas fa-plus" style="margin-right: 5px"></i> Insert Page Before</button>
                        <button type="button" style="margin-top: 3px; padding: 8px 10px" class="btn-add-page" data-location="after"><i class="fas fa-plus" style="margin-right: 5px"></i> Insert Page After</button>
                        <button type="button" style="margin-top: 3px; padding: 8px 10px" class="btn-remove-page"><i class="fas fa-times" style="margin-right: 5px"></i> Delete Page</button>
                    </div>
                </div>
                <textarea name="content[]" style="height: 21cm"></textarea>
            </div>
            @foreach ($pages AS $k => $page)
            <div class="page">
                <div class="header">
                    <div style="display: inline-block; {{ $k == 1 ? 'visibility:hidden' : '' }}">
                        <label>Page: </label>
                        <input type="hidden" name="page[]" value="{{ $page['page_id'] ?? 0 }}" />
                        <input type="hidden" name="is_delete[]" value="0" />
                        <input type="number" name="sort_order[]" required value="{{ $k }}" style="height: 35px; width: 70px; text-align: right; margin-top: 2px"/>
                        <input type="hidden" name="blueprint_id[]" value="{{ isset($masterCopy) ? $page['blueprint_id'] : $k }}">
                    </div>
                    @if ($k > 1)
                        <div style="float:right">
                            <button type="button" style="margin-top: 3px; padding: 8px 10px" class="btn-add-page" data-location="before"><i class="fas fa-plus" style="margin-right: 5px"></i> Insert Page Before</button>
                            <button type="button" style="margin-top: 3px; padding: 8px 10px" class="btn-add-page" data-location="after"><i class="fas fa-plus" style="margin-right: 5px"></i> Insert Page After</button>
                            <button type="button" style="margin-top: 3px; padding: 8px 10px" class="btn-remove-page"><i class="fas fa-times" style="margin-right: 5px"></i> Delete Page</button>
                        </div>
                    @endif
                </div>
                <textarea class="tinymce" name="content[]" style="height: 21cm">{!! isset($masterCopy) ? $page['text'] : $page !!}</textarea>
            </div>
            @endforeach
            <div class="page footer">
                <div class="form-group" style="display:flex; justify-content: center; margin-bottom: 20px">
                    <label for="input-name" style="margin-top: 10px">Status</label>
                    <div>
                        <select name="is_active" style="width: 130px; margin-bottom: 10px; padding: 10px; margin-left: 10px; margin-right: 185px">
                            <option value="1" {{ !isset($masterCopy) || $masterCopy->is_active == 1 ? 'selected=selected' : '' }}>Active</option>
                            <option value="0" {{ isset($masterCopy) && $masterCopy->is_active == 0 ? 'selected=selected' : '' }}>Inctive</option>
                        </select>
                        <div class="feedback" style="text-align: left; margin-left: 10px; color: red"></div>
                    </div>
                </div>
                <div class="form-group" style="display:flex; justify-content: center; margin-bottom: 20px">
                    <label for="input-name" style="margin-top: 10px">Master Copy Name</label>
                    <div>
                        <input type="text" name="name" value="{{ $masterCopy->name ?? '' }}" required maxlength="25" autocomplete="off" style="width: 400px; margin-bottom: 10px; padding:10px; margin-left: 10px"/>
                        <div class="feedback" style="text-align: left; margin-left: 10px; color: red"></div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" onclick="window.close()" style="margin-top: 3px; padding: 8px 10px; width: 100px">Close</button>
                    <button type="button" id="btn-save-master" style="margin-top: 3px; padding: 8px 10px; width: 100px">Save</button>
                    <button type="submit" style="visibility: hidden">Submit</button>
                    <input type="hidden" name="is_new_version" value="0" />
                </div>
            </div>
        </div>
    </form>
    <script>

        $(document).ready(function () {
            initTinyMCE();

            setTimeout(function() {
                $('#overlay').hide();
            }, 10000);
        })

        $('body').on('click', '#btn-save-master', function() {

            @if (isset($masterCopy))
            Swal.fire(confirmSwal('Do you want to do save the changes as a new version? Doing this will update all the associated child copies accordingly. Once done, the action cannot be undone.', true)).then((result) => {
                if (result.value) {
                    $(this).closest('form').find('input[name="is_new_version"]').val(1);
                }
                if (typeof result.value != 'undefined') {
                    $(this).next().trigger('click');
                }
            });
            @else
                $(this).next().trigger('click');
            @endif
        })

        $('body').on('click', '.btn-add-page', function () {
            let $$ = $(this);
            let elem = $$.closest('.document').find('.page:first-child').clone().show()
            if ($$.data('location') === 'before') {
                elem.insertBefore($$.closest('.page'));
            } else {
                elem.insertAfter($$.closest('.page'));
            }
            reOrderPageNumbers();
            elem.find('textarea').addClass('tinymce');
            initTinyMCE();

        });

        $('body').on('click', '.btn-remove-page', function () {

            let $$ = $(this);
            if ($$.closest('.document').find('.btn-remove-page').length <= 2) {
                return;
            }

            Swal.fire(confirmSwal('Are you sure that you want to delete the page?')).then((result) => {

                if (result.value) {
                    let wrapperPage = $$.closest('.page');
                    let page = wrapperPage.find('input[name="page[]"');

                    wrapperPage.find('.tox-tinymce').remove();

                    if (page.val() != 0) {
                        page.next('input').val(1);
                        wrapperPage.slideUp('fast', function () {
                            $(this).hide();
                            reOrderPageNumbers();
                        })
                    } else {
                        wrapperPage.slideUp('fast', function () {
                            $(this).remove();
                            reOrderPageNumbers();
                        })
                    }

                }
            });
        });

        function reOrderPageNumbers() {
            let i = 1;
            $('body').find('div.page:visible').each(function () {
                $(this).find('input[name="sort_order[]"]').val(i);
                i == 1 ? i+=3 : i++;
            });
        }

        function initTinyMCE(selector = 'textarea.tinymce') {
            tinymce.init({
                selector: selector,
                object_resizing: false,
                menubar: false,
                max_height: 790,
                min_height: 790,
                plugins: 'autolink lists table image code',
                toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist checklist | bullchecklist code pageembed permanentpen table image | customCheckBox ',
                toolbar_mode: 'floating',
                content_css: "/css/tinymce_blueprint.css?v=1.6",
                auto_focus: false,
                extended_valid_elements: 'placeholder',
                relative_urls : false,
                remove_script_host : false,
                document_base_url : APP_URL,
                setup: function (editor) {
                    editor.ui.registry.addButton('customCheckBox', {
                        icon: 'gamma',
                        tooltip: 'Insert Custom TextBox',
                        onAction: function (_) {
                            editor.insertContent('<span class="d-inline-block" style="width: 55px; white-space: nowrap; margin-left: 15px;">Y <input type="checkbox" class="checkbox">&nbsp;</span>&nbsp;');
                        }
                    });
                },
            });
        }

        function callback_create_master(j)
        {
            if(j.status === 'success')
            {
                window.onunload = refreshParent;
                function refreshParent() {
                    window.opener.location.href = j.redirect;
                }
                window.close();
            }
        }

    </script>
    </body>
</html>

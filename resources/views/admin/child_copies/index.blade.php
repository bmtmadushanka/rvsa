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
<form class="form ajax scrollable" method="POST" action="admin/child-copy/{{ $child_copy_id }}/update-index" data-callback="callback_create_master">
   {{ method_field('PATCH') }}
    @csrf
    <div class="document">
        @foreach ($pages AS $page => $content)
            <div class="page">
                <div class="header text-center">
                    {{ $page === 2 ? 'Index' : 'AVV Summary Checklist' }}
                </div>
                <textarea class="tinymce" name="content[{{ $page }}]" style="height: 21cm">{!! json_decode(html_entity_decode($content)) !!}</textarea>
            </div>
        @endforeach
        <div class="page footer">
            <div class="text-center">
                <button type="button" onclick="window.close()" style="margin-top: 3px; padding: 8px 10px; width: 100px">Close</button>
                <button type="submit" style="margin-top: 3px; padding: 8px 10px; width: 100px">Submit</button>
            </div>
        </div>
    </div>
</form>
<script>

    $(document).ready(function () {
        initTinyMCE();

        setTimeout(function() {
            $('#overlay').hide();
        }, 1000);
    })

    function initTinyMCE(selector = 'textarea.tinymce') {
        tinymce.init({
            selector: selector,
            object_resizing: false,
            menubar: false,
            max_height: 790,
            min_height: 790,
            plugins: 'autolink code',
            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist checklist | bullchecklist code pageembed permanentpen table image | customCheckBox ',
            toolbar_mode: 'floating',
            content_css: "/css/tinymce_blueprint.css?v=1.6",
            auto_focus: false,
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

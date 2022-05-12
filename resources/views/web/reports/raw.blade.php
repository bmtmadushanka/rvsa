<!DOCTYPE html>
<html style="background-color:#f5f5f5">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>{{ Company::get('code') }} - Model Report</title>
<!-- CSS only -->
<!-- StyleSheets  -->
<link rel="stylesheet" href="/assets/css/dashlite.min.css?ver=2.8.0">
<link rel="stylesheet" href="/assets/css/theme.css?ver=2.8.0">
{{--<link rel="stylesheet" href="/css/app.css?v=1">--}}
<link rel="stylesheet" href="/css/main.css">
@stack('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    const APP_URL = "{!! url('/') !!}/";
</script>
@stack('scripts-pre')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        @font-face {
            font-family: 'Calibri';
            font-weight: normal;
            src: url({{ config('app.url') . '/fonts/Calibri Regular.ttf' }})  format('truetype');
        }
        @font-face {
            font-family: 'Calibri';
            font-weight: bold;
            src: url({{ config('app.url') . '/fonts/Calibri Bold.ttf' }})  format('truetype');
        }

        @page {
            margin: 2.2cm 1.5cm 2cm 1.5cm ;
        }

        html, body  {
            font-family: 'Calibri';
            font-size: 12pt;
            line-height: 1;
            background-color: #fff;
        }

        header {
            position: fixed;
            top: -65px;
            left: 0px;
            right: 0px;
            height: 45px;
            color: #888888;
        }

        footer {
            position: fixed;
            bottom: -65px;
            left: 0px;
            right: 0px;
            height: 50px;
            color: #888888;
        }

        .page {
            position: relative;
        }

        .page-num:before {
            content: counter(page);
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        div.page-break {
            page-break-after: always;
        }

        h1, h2, h3, h4, h5, h6 {
            page-break-after: avoid;
        }
        p {
            margin: 0 0 10px;
            display: inline-block;
            width: 100%;
            min-height: 16px;
        }

        table {
            height: auto !important;
        }
    </style>

    <style>
        .text-left { text-align: left }
        .text-center { text-align: center }
        .text-right { text-align: right }
        .text-justify { text-align: justify }
        .report-heading { margin-top: 0 }
        .align-top { vertical-align: top }

        .w-50 { width: 50% }
        .w-100 { width: 100% }
        .fs-14 { font-size: 13pt }
        .fw-bold { font-weight: bold }

        .m-0 { margin: 0 }
        .mt-0 { margin-top: 0px}
        .mt-1 { margin-top: 5px }
        .mt-2 { margin-top: 10px }
        .mt-3 { margin-top: 15px }
        .mt-4 { margin-top: 20px }
        .mt-5 { margin-top: 25px }
        .mr-1 { margin-right: 5px }
        .mr-2 { margin-right: 10px }
        .mr-3 { margin-right: 15px }
        .mr-4 { margin-right: 20px }
        .mr-5 { margin-right: 25px }
        .mb-1 { margin-bottom: 5px }
        .mb-2 { margin-bottom: 5px }
        .mb-3 { margin-bottom: 15px }
        .mb-4 { margin-bottom: 20px }
        .mb-5 { margin-bottom: 25px }
        .ml-2 { margin-left: 10px }
        .ml-3 { margin-left: 15px }
        .ml-4 { margin-left: 20px }
        .ml-75 { margin-left: 100px }
        .pt-1 { padding-top: 5px }
        .pt-2 { padding-top: 10px }
        .pt-3 { padding-top: 15px }
        .pt-4 { padding-top: 20px }
        .pb-2 { padding-bottom: 10px }
        .pb-3 { padding-bottom: 15px }
        .pl-0 { padding-left: 0px }
        .pl-3 { padding-left: 15px }
        .pl-4 { padding-left: 20px }
        .py-6 { padding-top: 50px; padding-bottom: 40px }
        .px-3 { padding-right: 15px; padding-left: 15px}
        .py-2 { padding-top: 10px; padding-bottom: 10px }
        .p-2 { padding-top: 10px; padding-bottom: 10px; padding-right: 10px; padding-left: 10px }

        .label {
            font-weight: bold;
            margin-right: 15px;
        }

        .d-inline-block { display: inline-block }
        .float-left { float: left }
        .float-right { float: right }

        div.clearfix {
            overflow: auto;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        h1 { margin-top: 0; font-size: 1.4em !important }
        h2 {
            margin-top: 0;
            font-size: 1.15em !important;
        }


        .checkbox {
            margin-left: 5px;
            margin-right: 15px;
            display: inline-block;
            height: 20px;
            width: 20px;
            border: 1px solid #000;
            position: relative;
            bottom: -2px
        }

        .checkbox-inline {
            margin-top: 4px;
        }

        .report-sub-heading {
            margin-top: 0;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .dashed-line {
            display: inline-block;
            border-bottom: 1px solid;
            border-bottom-style: dashed;
            margin-top: 5px;
        }

        .placeholder-box {
            border: 1px solid #000;
            height: 40px;
            width: 150px;
            display: inline-block;
        }

        #placeholder-date {
            border: 1px solid #000;
            display: inline-block;
            height: 40px;
            width: 200px;
        }

        .table.table-fixed {table-layout: fixed}
        .table.table-bordered { border-collapse: collapse }
        .table.table-bordered tr th, .table.table-bordered tr td { border: 1px solid #777; }
        .table.table-borderless tr th, .table.table-borderless tr td { border: 0 }
        .table.table-padded tr th, .table.table-padded tr td { padding: 5px }
        table#table-consumer-notice tr th, table.table-adr-content tr td {
            text-align: left;
        }

        .page-adr tr > td:last-child {
            text-align: center;
        }

        .table-index tr th {
            padding-top: 8px;
            padding-bottom: 8px;
            font-size: 15pt;
            font-weight: bold;
            padding-left: 0px;
            text-align: left;
        }

        .table-index tr td {
            padding-top: 6.5px;
            padding-bottom: 6.5px;
            padding-left: 100px;
            height: auto !important;
        }

        .border-right { border-right: 1px solid #000 !important }

        a {
            text-decoration: none;
            color: inherit;
        }

        .tinymce table tr td.text-center {
            text-align: center;
        }

        .tinymce table {
            border-style: hidden
        }

        .tinymce table tr td.text-center .mx-3 {
            margin-left: 75px
        }

        .tinymce table tr td.text-center .checkbox {
            margin-left: 0px
        }

        .no-header h1 {
            display: none;
        }

        /* Checkbox wrapper */
        span.mr-3.d-inline-block {
            display: inline !important;
            position: relative;
            width: 35px !important;
            margin-right: 0 !important;
        }

        .placeholder {
            display: inline-block;
            min-height: 1em;
            vertical-align: middle;
            cursor: wait;
            background-color: white !important;
            opacity: .5;
        }
    </style>
</head>

<body class="document" style="background-color:#f5f5f5">
    <div class="content" style="margin:50px;">
    <form class="form ajax scrollable" method="POST" action="report/report-mark/{{$report->id}}" data-callback="callback_create_master">
        @csrf
        <div class="card">
            <div class="card-body" style="margin:50px;">
            @if ($has_headers)
            <header class="header">
                <div class="clearfix">
                    <div class="float-left" style="display: inline-block">
                        <a href="/" class="logo-link">
                            <img class="logo-light logo-img" src="{{ config('app.url') }}{{ config('app.asset_url') }}images/logos/{{ Company::get('logo') }}" alt="Logo" style="height: 45px; margin-top: 6.5px">
                        </a>
                    </div>
                    <div class="float-left" style="width: 960px">
                        MASTER MODEL REPORT No: MR{{ $report['name'] }} <div class="float-right mr-1">Model Report Vehicle ID No: MR{{ !empty($vin) ? $vin : '[VIN]' }}</div><br/>
                        <div style="margin-top:4px; width: 100%">Copyright of {{ Company::get('code') }} & is for authorized use only & is information contained within is not be given to any third parties.</div>
                    </div>
                </div>
                <!-- <div class="text-center" style="color: rgba(136,136,136,0.5); font-size: 18pt; transform:rotate(-45deg); position: absolute; top: 225px; left: 20%; line-height: 2.5rem">
                    {{ !empty($vin) ? $user->client->raw_company_name ?? Company::get('raw_company_name') : '[RAW Company Name]' }}<br/>
                    {{ !empty($vin) ? $vin : '[VIN]' }}<br/>
                    Document Author: {{ Company::get('name') }} ({{ Company::get('code') }})
                </div> -->
            </header>
            <footer class="clearfix">
                @isset($verify_link)
                <div class="float-left">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=45x45&data={{ $verify_link }}?id={{ $vin ?? 0 }}"/>
                    {{--<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(40)->generate($verify_link)) !!} ">--}}
                </div>
                @endisset
                <div class="float-left">
                    <div>
                        <div style="margin-bottom:0px; margin-left: 10px; display: inline-block">{{ Company::get('name') }} ({{ Company::get('code') }}) Model Report</div>
                        <span style="margin-left: 247px">
                            @isset($show_version)
                            Version : VS{{ $report->version }}
                            @endisset
                        </span>
                    </div>
                    <div style="width: 960px">
                        <div class="float-left" style="margin-left: 10px">This document is not to be reproduced without written permission from {{ Company::get('code') }} Author</div>
                        <div class="float-left" style="margin-left: 620px">
                            @isset($verify_link)
                            Verify: {{ $verify_link }}
                            @endisset
                        </div>
                        @if (empty($pages) || count($pages) > 1)
                            <span class="float-right page-num"></span>
                        @endif
                    </div>
                </div>
            </footer>
            @endif
            @foreach ($pages AS $page)
                @if ($page->blueprint_id > 24) @continue @endif
                {{-- ** inject only the dimensions that are selected by the admin **--}}
                @if (in_array($page->blueprint_id, [13, 14, 15, 16, 17]) && !in_array($page->blueprint_id, array_values($report['data']['dimensions']))) @continue @endif

                {{-- ** skip the post modifications and the dimension A&B pages. They are injecting with separete settings **--}}
                @if (!in_array($page->blueprint_id, [10, 13]))
                <div class="page page-break" style="page-break-after: always">
                    @include('web.reports.partials.pages')
                </div>
                @endif

                {{-- ** inject pre modifications, if available ** --}}
                @if ($page->blueprint_id == 7)
                    @foreach ($report->mods()->active()->where('variant_id', '!=', 1)->orderBy('sort_order')->get() AS $mod)
                        @foreach ($pages->whereIn('blueprint_id', [6, 7]) AS $page)
                            <div class="page page-break no-header" style="page-break-after: always">
                            @include('web.reports.partials.pages', ['mod' => json_decode($mod->pre, true), 'variant' => $mod['variant_id'] ?? ''])
                            </div>
                        @endforeach
                    @endforeach
                @endif

                {{-- ** inject post modifications, if available ** --}}
                @if ($page->blueprint_id == 10)
                    <div class="page page-break" style="page-break-after: always;">
                    @foreach ($report->mods()->active()->whereNull('post_visible_columns')->orderBy('variant_id')->get() AS $k => $mod)
                        <?php /*print_r(json_decode($mod->post, true)); exit;*/ ?>
                            <div class="{{ $k > 0 ? 'no-header' : '' }}" style="{{ empty($mod->visible_columns) ? 'margin-bottom: 50px' : '' }}">
                            @include('web.reports.partials.pages', [
                                'mod' => json_decode($mod->post, true),
                                'visible_columns' => is_array($mod->visible_columns) ? $mod->visible_columns : json_decode($mod->visible_columns),
                                'variant' => $mod->variant_id,
                            ])
                        </div>
                    @endforeach
                    </div>
                    @foreach ($report->mods()->active()->whereNotNull('post_visible_columns')->orderBy('variant_id')->get() AS $k => $mod)
                        <div class="page page-break" style="page-break-after: always;">
                            <div class="{{ $report->mods()->active()->whereNull('post_visible_columns')->count() || $k > 0 ? 'no-header' : '' }}" style="{{ empty($mod->visible_columns) ? 'margin-bottom: 50px' : '' }}">
                                @include('web.reports.partials.pages', [
                                    'mod' => json_decode($mod->post, true),
                                    'visible_columns' => is_array($mod->visible_columns) ? $mod->visible_columns : json_decode($mod->visible_columns),
                                    'variant' => $mod->variant_id,
                                ])
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- ** inject under bonnet measurements,  if available ** --}}
                @if ($page->blueprint_id == 13)
                    @if ($report->data['dimensions']['ub'] === 'A-B')
                    <div class="page page-break" style="page-break-after: always">
                        @include('web.reports.partials.pages', ['key' => 'A-B'])
                    </div>
                    @else
                        @foreach (['A', 'B'] AS $key)
                            <div class="page page-break" style="page-break-after: always">
                                @include('web.reports.partials.pages', ['key' => $key])
                            </div>
                        @endforeach
                    @endif
                @endif
            @endforeach
            @foreach($adrs AS $adr)
                <div class="page mb-4 {{ isset($ignore_page_breaks) ? '' : 'page-break'}}" {{ isset($ignore_page_breaks) ? '' : 'style="page-break-after: always"' }}>
                    <?php eval("?>" . html_entity_decode(str_replace('&nbsp;', ' ', $adr)) . "<?php ") ?>
                </div>
            @endforeach
            @foreach ($pages AS $page)
                @if ($page->blueprint_id < 25) @continue @endif
                <div class="page {{ !$loop->last ? 'page-break' : '' }}" {{ !$loop->last ? 'style="page-break-after: always"' : '' }}>
                    @include('web.reports.partials.pages')
                </div>
            @endforeach
            </div>
            <div class="card-footer" style="background-color:white;">
                <button type="button" class="btn btn-outline-primary justify-content-center align-middle btn-update-child-adr" style="width: 120px"><em class="icon ni ni-save mr-1"></em>Mark</button>
                <button type="submit" style="display: none"></button>
            </div>
        </form>
        </div>
    </div>
<!-- JavaScript -->
<script src="/assets/js/bundle.js?ver=2.8.0"></script>
<script src="/assets/js/scripts.js?ver=2.8.0"></script>
<script src="/js/script.js?ver=1.1.2"></script>
@ifBackEnd
<script src="/assets/js/libs/datatable-btns.js?ver=2.8.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slideReveal/1.1.2/jquery.slidereveal.min.js" integrity="sha256-JQtNmjHa+w6OHuebNtc1xrE8KD1Oqd9ohbxeaKLFhdw=" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/js/admin.js?ver=1.1.5"></script>
@notBackEnd
<script src="/js/web.js?ver=1.1.1"></script>
@endIfBackEnd
@stack('scripts-post')
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    $( document ).ready(function() {
        $('<span class="checkbox checkbox-inline"> </span>').replaceWith( '<span><input type="checkbox">&nbsp;</span>');
        $('.avvcheck').attr('disabled',true);
    
        $('body').on('click', '.btn-update-child-adr', function() {

        let $$ = $(this);
       // loadingButton($$);
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
    });
</script>
</body>
</html>

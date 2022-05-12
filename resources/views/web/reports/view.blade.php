<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>Model Report</title>
    <link rel="stylesheet" type="text/css" href="/css/plugins/a4-configs.css">

    <style>
        .text-left { text-align: left }
        .text-center { text-align: center }
        .text-justify { text-align: justify }
        .align-top { vertical-align: top }

        .w-100 { width: 100% }

        .fs-13 { font-size: 13pt }
        .fs-14 { font-size: 14pt }
        .fw-bold { font-weight: bold }

        .d-flex { display: flex }
        .w-50 { width: 50% }

        .mt-0 { margin-top: 0 !important }
        .mt-1 { margin-top: 5px !important }
        .mt-2 { margin-top: 10px !important }
        /*.mt-3 { margin-top: 15px }*/
        .mt-4 { margin-top: 20px !important }
        .mt-5 { margin-top: 25px !important }

        .mb-0 { margin-bottom: 0 !important }
        .mb-2 { margin-bottom: 10px !important }
        .mb-3 { margin-bottom: 15px !important }

        .mr-3 { margin-right: 15px !important }
        .mr-4 { margin-right: 20px !important }
        .mr-5 { margin-right: 25px !important }

        .ml-4 { margin-left: 20px !important }

        .p-2 { padding: 10px !important;}
        .px-3 { padding-right: 15px !important; padding-left: 15px !important}

        .px-1 { padding-left: 5px !important; padding-right: 5px !important}
        .pt-2 { padding-top: 10px !important }
        .pt-3 { padding-top: 15px !important }
        .pt-4 { padding-top: 20px !important }

        .pb-3 { padding-bottom: 15px !important }
        .pb-4 { padding-bottom: 20px !important }
        .pb-5 { padding-bottom: 25px !important }

        .pl-0 { padding-left: 0!important }
        .pl-4 { padding-left: 20px !important }

        .border-top-0 { border-top: none !important }
        .border-bottom-0 { border-bottom: none !important}
        .border { border: 1px solid #000 !important }
        .border-right { border-right: 1px solid #000 !important }

        .float-right { float: right }

        .checkbox-inline .checkbox {
            top: 5px !important;
        }

        .checkbox {
            position: relative;
            top: 0px;
            margin-left: 5px;
            display: inline-block;
            height: 20px;
            width: 20px;
            border: 1px solid #000;
        }
        .dashed-line {
            display: inline-block;
            border-bottom: 1px solid;
            border-bottom-style: dashed;
        }

        .table.table-bordered { border-collapse: collapse; }
        .table.table-bordered tr th, .table.table-bordered tr td { border: 1px solid #777; }
        .table.table-borderless tr th, .table.table-borderless tr td {
            border: 0
        }

        .table tr th, .table tr td { padding: 7px }

        .table.table-sm tr td { padding: 0 }
        .label { font-weight: bold; margin-right: 15px }

        .d-inline-block { display: inline-block }
        .d-t { display: table }
        .table-index .page-heading, .table-index .page-number { display: table-cell; white-space: nowrap }

        .table-index .page-heading {
            font-weight: bold;
            padding-right: 15px;
            width: 100%;
            font-size: 12.5pt;
        }

        .table-index .sub-heading {
            padding-left: 90px;
            font-weight: initial;
        }

        .table-index .page-number {
            float:right;
            width: 350px;
            text-align: center;
        }

        .report-heading { margin-top: 0 }

        .table-seat-count {
            font-weight: bold;
        }

        .report-sub-heading {
            margin-top: 0;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .placeholder-box {
            border: 1px solid #000;
            height: 40px;
            width: 150px;
            display: inline-block;
            position: relative;
            top: 12px;
            margin-left: 20px;
        }

        #placeholder-date {
            border: 1px solid #000;
            padding: 15px 5px;
            display: inline-block;
            height: 40px;
            position: relative;
            width: 170px;
            top: 5px;
        }

        .d-inline-block {
            display: inline-block;
        }

        .float-left {
            float: left
        }

    </style>

</head>

<body class="document">
@for ($i =1; $i < 29; $i++)
<div class="page" data-page="1">
    @include('admin.child_copies.car-31102021.partials.page_' . $i)
</div>
@endfor
@foreach($adrs AS $adr)
    {!! $adr !!}
@endforeach
</html>


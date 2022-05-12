<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>Model Report</title>
    <link rel="stylesheet" type="text/css" href="/css/plugins/a4-configs.css">

    <style>

        .text-center { text-align: center }
        .align-top { vertical-align: top }
        .w-100 { width: 100% }
        .fw-bold { font-weight: bold }

        .m-0 { margin: 0 }
        .mr-3 { margin-right: 15px !important }
        .mr-5 { margin-right: 25px !important }
        .ml-4 { margin-left: 20px !important }

        .p-0 { padding: 0 !important;}
        .p-1 { padding: 5px !important }
        .px-1 { padding-left: 5px !important; padding-right: 5px !important}
        .pt-3 { padding-top: 15px !important }

        .pl-0 { padding-left: 0!important }
        .d-flex { display: flex }
        .flex-basis-0 {
            flex-basis: 0;
        }

        .border-right { border-right: 1px solid #000}
        .border-top { border-top: 1px solid #000}
        .border-bottom { border-bottom: 1px solid #000}
        .border-top-0 { border-top: none !important }
        .border-bottom-0 { border-bottom: none !important}

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

        .table.table-bordered { border-collapse: collapse; }
        .table.table-bordered tr th, .table.table-bordered tr td { border: 1px solid #777; }
        .table.table-borderless tr th, .table.table-borderless tr td {
            border: 0
        }

        .table tr th, .table tr td { padding: 7px }

        .table.table-sm tr td { padding: 0 }

        .d-inline-block { display: inline-block }

        #tinymce table tr td.text-center {
            text-align: center;
        }

        #tinymce table {
            border-style: hidden
        }

    </style>
</head>
<body class="document">
    <div class="page" data-page="1">
    @include('admin.adr.print')
    </div>
<script type="text/javascript">
    // window.print();
</script>
</body>
</html>


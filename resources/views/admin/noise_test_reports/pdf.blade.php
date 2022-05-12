<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>Model Report</title>

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

        @page {
            margin: 2.2cm 1.5cm ;
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
            height: 50px;
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
            margin: 0;
        }

        p + p {
            margin-top: 0.5cm;
        }

        #tinymce p + p {
            margin-top: 0.25cm;
        }

        /*table {
            page-break-inside: avoid;
        }*/

    </style>

    <style>
        .text-left { text-align: left }
        .text-center { text-align: center }
        .text-right { text-align: right }
        .report-heading { margin-top: 0 }
        .align-top { vertical-align: top }

        .w-50 { width: 50% }
        .w-100 { width: 100% }
        .fs-14 { font-size: 14pt }
        .fw-bold { font-weight: bold }

        .m-0 { margin: 0 }
        .mt-0 { margin-top: 0px}
        .mt-2 { margin-top: 10px }
        .mt-3 { margin-top: 15px }
        .mt-4 { margin-top: 20px }
        .mt-5 { margin-top: 25px }
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

        .d-inline-block {
            display: inline-block;
        }

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

        .border-right { border-right: 1px solid #000 !important }

    </style>
</head>

<body class="document">
<header>
    Department of Infrastructure, Transport, Regional Development and Communications<br/>
    {{ Company::get('code') }} Test Facility Report
</header>
<footer>
    {{ Company::get('code') }} trading as {{ Company::get('default_raw_company_name') }}
    Test Facility approval no. TFA-018206
</footer>
<div class="page page-break" style="page-break-after: avoid">
    <div class="fs-14 clearfix mb-3">
        <div class="float-left fw-bold">ADR 83/00 External Noise - Stationary noise test</div>
        <div class="float-right">
            <span class="fw-bold">Test Date: </span> {{ date('d/m/Y', strtotime($report->noise_test->data['date_test'])) }}
        </div>
    </div>
    <div class="mb-3">
        <span class="fs-14 fw-bold">Model Report No.:</span> MR{{ $report->child->name }}
    </div>
    <div class="mb-3">
        <span class="fs-14 fw-bold mb-3">Vehicle:</span> {{ $report->child->make }} {{ $report->child->model }}
        <span class="fs-14 fw-bold ml-4">VIN:</span> {{ $report->vin }}
    </div>
    <div class="mb-3">
        <span class="fs-14 fw-bold">Test Location:</span> Truck City Drive Campbellfield - 10 x 12 metre open area (End of side road)
    </div>
    <div class="mb-3 text-justify">
        <span class="fs-14 fw-bold">Test Equipment/Setup:</span> Integrating Sound Level Meter IEC61672:2002 Class 1 with windshield fitted. Calibration checked with 114 dB(A) SV33 IEC60942:2003 Acoustic calibrator.
    </div>
    <p class="text-justify">
        Tripod/spacer block was used to mount microphone 500mm behind exhaust outlet at 45 +/- 10 degrees to the longitudinal centreline of the vehicle & at {{ $report->noise_test->data['height_of_mic'] }}mm (200mm minimum) above the ground level to the centreline of the exhaust outlet.
    </p>
    <p>
        Meter set to ‘’A’’ Frequency weighting & ‘’F’’ Time weighting (Fast).
    </p>
    <p>
        <div class="clearfix">
            <div class="float-left">
                <span class="fw-bold">Temperature:</span> {{ $report->noise_test->data['temperature'] }} degrees centigrade.
            </div>
            <div class="float-right">
                <span class="fw-bold">Wind direction/strength:</span> {{ $report->noise_test->data['wind_direction']}}
            </div>
        </div>
    </p>
    <p>
        <span class="fw-bold">Ambient Noise Level:</span> {{ $report->noise_test->data['noise_level'] }} dB(A) NB> maximum allowed when testing {{ $report->child->data['vehicle']['category'] }} category vehicle is 64 dB(a).
    </p>
    <p>
        <span>NEP engine speed:</span> {{ $report->noise_test->data['engine_speed_nep'] }} RPM X 0.75 = engine speed at the start of test cycle: {{ $report->noise_test->data['engine_speed_starts'] }} RPM.
    </p>
    <p>
        3 PEAK test readings are to be taken during the drop in engine RPM, from the point at ¾ of the NEP speed back to the idle position. The mean average is then determined.
    </p>
    <p>
        <span class="fw-bold">Test 1:</span> {{ $report->noise_test->data['test_1'] }} dB(A) +
        <span class="fw-bold">Test 2:</span> {{ $report->noise_test->data['test_2'] }} dB(A) +
        <span class="fw-bold">Test 3:</span> {{ $report->noise_test->data['test_2'] }} dB(A)
    </p>
    <p>
        Therefore, the <span class="fw-bold">Mean average</span> is {{ $report->noise_test->data['test_1'] }} +  {{ $report->noise_test->data['test_2'] }} + {{ $report->noise_test->data['test_3'] }} divided by 3 = <span class="fw-bold">{{ ($report->noise_test->data['test_1'] + $report->noise_test->data['test_2'] + $report->noise_test->data['test_3'])/3 }} dB(A)</span>
    </p>
    <p>
        <span class="fw-bold">Maximum allowed </span> for {{ $report->child->data['vehicle']['category'] }} category vehicle is <span class="fw-bold">{{ $report->noise_test->data['sound_intensity'] }} dB(A)</span>
    </p>
    <p class="mt-4">
        The tests above have been conducted in accordance with the requirements of ADR 83/00 & the results clearly show a <span class="fs-14 fw-bold">PASS</span> status.
    </p>
    <p>
        <div class="clearfix">
            <div class="float-left">
                <span class="fw-bold">Test conducted by:</span> Mike Godavitarane
                <span class="fw-bold ml-4">Signed:</span>
            </div>
            <div class="float-right">
                <span class="fw-bold">Test Date: </span> {{ date('d/m/Y', strtotime($report->noise_test->data['date_test'])) }}
            </div>
        </div>
    </p>
    <p>
        <span class="fw-bold">Unique report no:</span> ADR 83/00 MR6U90WE2116013123A
    </p>
    <p>
        <span class="fw-bold text-justify">Comments:</span> Noise test RPM could only be carried out at <span class="fw-bold">2500 RPM</span> instead of the ADR specified value of 3900 RPM as the engine speed is computer limited by the integrated Hybrid system which prevents over revving in the stationary run condition of the vehicle.
    </p>
</div>
</body>
</html>

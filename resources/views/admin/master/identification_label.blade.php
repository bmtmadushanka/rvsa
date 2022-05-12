<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vehicle Identification Label</title>

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
            font-size: 11pt;
            line-height: 0.8;
            background-color: #fff;
        }

    </style>
</head>

<body>
    <div style="width: 400px">
        <div style="text-align: center">
            <h2>SECURE VEHICLE IDENTIFICATION LABEL</h2>
            <h2>{{ $report->child->make }} {{ $report->child->model }}</h2>
            <h1>VIN: {{ $report->vin }}</h1>

            <p style="font-size: 20px">Subject to Vehicle Standards Act 2018</p>
        </div>
        <div style="text-align: right; margin-right: 45px">{{ Company::get('code') }} SVIL</div>
    </div>
</body>
</html>

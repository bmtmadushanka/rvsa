<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Welcome - {{ Company::get('web') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,600" rel="stylesheet" type="text/css">
    <style>
        * {
            font-family: 'Roboto', sans-serif !important;
        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,600" rel="stylesheet" type="text/css">
    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-family: 'Roboto', sans-serif !important;
            font-size: 14px;
            margin-bottom: 10px;
            line-height: 24px;
            font-weight: 400;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }
        table td {
            padding: 20px 20px 0;
        }
        .table-condensed td {
            padding: 10px;
        }
        a {
            text-decoration: none;
        }
        img {
            -ms-interpolation-mode:bicubic;
        }
        .text-muted {
            color:#8094ae;
        }
        .bg-light-grey {
            background: #f5f5f5;
        }
        .btn {
            padding: 7px 10px !important;
            background: #f2f2f2;
            border: 1px solid #c5c5c5;
            margin-right: 5px;
            cursor: pointer;
            color: initial;
        }
        .btn:hover {
            background: #e2e2e2;
        }
    </style>

</head>

<body class="text-center" width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f5f6fa;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f5f6fa">
    <tr>
        <td style="padding: 40px 0;">
            <table style="width:100%; max-width:620px; margin:0 auto; background-color:#ffffff;">
                <tbody>
                <tr>
                    <td>
                        <img class="logo-light logo-img" src="{{ config('app.url') }}/{{ config('app.asset_url') }}images/logos/{{ Company::get('logo') }}" alt="{{ Company::get('code') }} Logo">
                    </td>
                </tr>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="js">
<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Road Vehicle Standards - Australia">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="/images/favicon.png">
    <!-- Page Title  -->
    <title>Road Vehicle Standards - Australia</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" type="text/css" href="/assets/css/libs/fontawesome-icons.css">
    <link rel="stylesheet" href="/assets/css/dashlite.min.css?ver=2.8.0">
    <link id="skin-default" rel="stylesheet" href="/assets/css/theme.css?ver=2.8.0">
    <link id="skin-default" rel="stylesheet" href="/css/main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body class="nk-body npc-invest bg-lighter ">
<div class="nk-app-root">
    <div class="nk-wrap ">
        <div class="nk-app-root">
            <!-- main header @s -->
            <div class="nk-header nk-header-fluid is-theme">
                <div class="container-xl wide-xl">
                    <div class="nk-header-wrap">
                        <div class="nk-header-brand">
                            <a href="/" class="logo-link">
                                <img class="logo-light logo-img" src="{{ config('app.asset_url') }}images/logos/{{ Company::get('logo') }}" alt="Logo" style="width: auto; height: 55px; max-height: 55px">
                            </a>
                        </div><!-- .nk-header-brand -->
                        <div class="nk-header-menu" data-content="headerNav">
                            <div class="nk-header-mobile">
                                <div class="nk-header-brand">
                                    <a href="/dashboard" class="logo-link">
                                        <img class="logo-light logo-img" src="{{ config('app.asset_url') }}images/logos/{{ Company::get('logo') }}" alt="Logo" style="width: 130px; height: 40px">
                                    </a>
                                </div>
                                <div class="nk-menu-trigger mr-n2">
                                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-main ">
                <div class="nk-wrap nk-wrap-nosidebar">
                    <div class="nk-content">
                        <div class="nk-block mt-4 pt-2 pb-5 nk-auth-body wide-md">
                            <div class="card card-bordered">
                                <div class="card-inner card-inner-lg">
                                    @if (isset($_GET['id']) && !empty($_GET['id'] && empty($report)))
                                    <div class="d-flex justify-content-center">
                                        <div class="mb-3">
                                            <div class="alert alert-danger }} alert-icon">
                                                <em class="icon ni ni-cross-circle"></em> Sorry! We are unable to find any record. Please check whether the entered report number is correct.
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if(empty($report))
                                    <div class="text-center pb-5">
                                        <h4 class="nk-block-title d-inline-block mb-5 mt-2">Verify the Model Report</h4>

                                        <form class="form" action="/verify" method="GET">
                                            <div class="form-group">
                                                <label class="form-label text-muted" for="input-report-no">Please enter the model report no to verify the details</label>
                                                <div class="form-control-wrap d-flex justify-content-center mt-2">
                                                    <div class="input-group" style="width: 500px">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">MR</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-lg rounded-0" id="input-report-no" name="id" maxlength="17" minlength="17" required placeholder="Model Report No">
                                                        <button type="submit" class="btn btn-outline-primary rounded-0">Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    @else
                                    <div class="pb-4 d-flex justify-content-center text-success">
                                        <div class="" style="font-size: 2rem">
                                            <em class="icon ni ni-check-circle-cut"></em>
                                        </div>
                                        <h4 class="nk-block-title d-inline-block ml-2 mt-2">Model Report Verified</h4>
                                    </div>

                                    <div class="text-center border py-4" style="background: #f9f9f9">
                                        <div>
                                            <h5>MODEL REPORT VEHICLE ID NO</h5>
                                            <h5>MR{{ $report->vin }}</h5>
                                        </div>
                                        <div style="margin-top: 50px">
                                            <p>The RAW Work Instruction Identifier is</p>
                                            <h6 class="mb-2">{{ $report->child->make }} {{ $report->child->model }} {{ $report->child->model_code }}</h6>
                                            <h6 class="mt-0 text-center" style="line-height: 2rem; max-width: 320px; margin: 0 auto">{!! $report->child->description !!}</h6>
                                        </div>
                                    </div>
                                    <table class="mt-4 table table-bordered text-left">
                                            <tbody>
                                            <tr>
                                                <th class="align-middle" style="width: 180px">Model Report Author</th>
                                                <td class="align-middle">{{ Company::get('code') }} - {{ Company::get('name') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle">Approval No</th>
                                                <td class="align-middle">{{ $report->child->approval_code }}</td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle" style="width: 180px">Authorized User</th>
                                                <td class="align-middle">{{ $report->order->user->client->raw_company_name }} ({{ $report->order->user->client->raw_id }})</td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle" style="width: 180px">Latest Version</th>
                                                <td class="align-middle">VS31102021</td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle">Date of Purchased</th>
                                                <td class="align-middle">{{ date('d/m/Y', strtotime($report->order->payments->firstWhere('status', 'paid')->updated_at)) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="align-middle">VIN</th>
                                                <td class="align-middle">{{ $report->vin }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

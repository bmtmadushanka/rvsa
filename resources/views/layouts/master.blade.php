<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="js">
<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Road Vehicle Standards - Australia">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="/images/favicon.png">
    <!-- Page Title  -->
    <title>{{ $isBackEnd ? 'Admin - RVSA' : 'Road Vehicle Standards - Australia' }} {{ !empty($page_title) ? '/ ' . $page_title : ''}}</title>
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
</head>
<body class="nk-body npc-invest bg-lighter ">
<div class="nk-app-root">
    <!-- wrap @s -->
    <div class="nk-wrap ">
        @include('layouts.header')
        <!-- content @s -->
        <div class="nk-content nk-content-fluid">
            <div class="container-xl wide-xl">
                <div class="nk-content-inner">
                    <div class="nk-content-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- content @s -->
        <!-- footer @s -->
        <div class="nk-footer nk-footer-fluid bg-lighter">
            <div class="container-xl">
                <div class="nk-footer-wrap justify-content-center">
                    @include('layouts.footer')
                </div>
            </div>
        </div>
        <!-- footer @e -->
        @ifBackEnd
        @include('drawers.drawer_sm')
        @include('drawers.drawer_md')
        @include('drawers.drawer_lg')
        @include('drawers.drawer_xl')
        @endIfBackEnd
    </div>
    <!-- wrap @e -->
</div>
<!-- app-root @e -->
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
</body>
</html>

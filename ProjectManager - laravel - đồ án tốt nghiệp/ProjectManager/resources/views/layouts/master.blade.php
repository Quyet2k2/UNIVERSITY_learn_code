<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', '@Master Layout'))</title>

    <!-- q-read: Favicon -->
    <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}" type="image/svg+xml" />
    {{-- Styles css common --}}
    <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"> -->

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome_v6_7_1/css/all_z.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- q-read: Custom css -->
    <link href="{{ asset('__custom.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body class="">
    <div id="wrapper">
        @include('layouts.partial.left-sidebar')
        <div id="page-wrapper" class="gray-bg">
            @include('layouts.partial.header', ['notification_count' => $notification_count ?? ''])
            <div class="wrapper wrapper-content animated fadeInRight">
                @yield('content')
            </div>

            @include('layouts.partial.footer')
        </div>

        @include('layouts.partial.right-sidebar')
    </div>
    <!-- q-read: scripts -->
    {{-- Scripts js common --}}
    <!-- <script src="{{ asset('assets/js/jquery-3.4.1.js') }}"></script> -->

    <!-- Mainly scripts -->
    <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('assets/js/inspinia.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    {{-- Scripts link to file or js custom --}}
    @yield('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaiadmin Dashboard</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @yield('ExtraCSS')
</head>
<body>

<div class="wrapper">
    @include('layouts.sidebar')

    <div class="main-panel">
        @include('layouts.header')

        <div class="container">
            @yield('content')
        </div>
    </div>
</div>

<!-- JS CORE -->
<script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

<!-- PAGE SCRIPT (INI HARUS PALING BAWAH) -->
@yield('ExtraJS')

</body>

</html>

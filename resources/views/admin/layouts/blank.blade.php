<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Import Google Icon Font -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/admin.bundle.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('/css/admin.css') }}" type="text/css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('/js/admin.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/admin.js') }}" type="text/javascript"></script>

    @yield('head_scripts')

    <style type="text/css">
        @media print {
            .navbar {
                display: block !important;
            }
        }
    </style>

    <title>@yield('title', 'Администрирование - Ликойл')</title>
</head>
<body>
<div id="app">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('admin') }}">
                    <img src="/img/logo.png" class="img-responsive" style="height: 35px;">
                    <img class="img-responsive" src="{{ asset('img/brand-name.png') }}" style="height: 30px;" />
                </a>
            </div>
        </div>
    </nav>

    <main class="container-fluid">
        @include('admin.partials._status')
        @include('admin.partials._errors')

        @yield('content')
    </main>

    @include('admin.partials._flash')
</div>

@yield('footer_scripts')

</body>
</html>
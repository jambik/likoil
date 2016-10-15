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

    <title>@yield('title', 'Администрирование - Ликойл')</title>
</head>
<body>
<div id="app">

    <p>&nbsp;</p>
    <main class="container">
        <div class="row">
            <div class="col s12 m8 l6 offset-m2 offset-l3">
                <div class="row card-panel">
                    <div class="center">
                        <img src="/img/logo.png">
                    </div>
                    <h4 class="center">Администрирование</h4>
                    @include('admin.partials._status')
                    @include('admin.partials._errors')

                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    @include('admin.partials._flash')

    <footer class="page-footer teal">
        <div class="container-fluid">
            <div class="row">
                <div class="col s12 center white-text">
                    <i class="material-icons">verified_user</i>
                </div>
            </div>
        </div>
    </footer>
</div>

@yield('footer_scripts')

</body>
</html>
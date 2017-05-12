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
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

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
            <div class="col-lg-6 col-md-8 col-sm-12 col-lg-offset-3 col-md-offset-2">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img src="{{ asset('img/logo.png') }}" class="img-responsive center-block" style="height: 100px;" />

                            <h2 class="text-center">Администрирование</h2>

                            @include('admin.partials._status')
                            @include('admin.partials._errors')

                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('admin.partials._flash')

    <footer class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">

            </div>
        </div>
    </footer>
</div>

@yield('footer_scripts')

</body>
</html>
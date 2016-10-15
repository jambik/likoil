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

    <header class="container-fluid">
        <div class="row">
            <nav class="red darken-3">
                <div class="nav-wrapper">
                    <div class="col s12">
                        <a href="{{ url('/admin') }}" class="brand-logo"><img src="/img/logo.png" class="img-responsive" style="height: 35px;"> <img class="img-responsive" src="{{ asset('img/brand-name.png') }}" /></a>
                        <ul id="nav-mobile" class="right hide-on-med-and-down">
                            <li><a class="dropdown-button" href="#" data-activates="user-dropdown"><i class="material-icons left">account_circle</i> {{ Auth::user()->name }}</a></li>
                            <li><a class="dropdown-button" href="#" data-activates="settings-dropdown"><i class="material-icons left">settings</i> Настройки</a></li>
                        </ul>
                        <ul id="user-dropdown" class="dropdown-content">
                            <li><a href="{{ route('admin.logout') }}" class="red-text"><i class="material-icons left">exit_to_app</i> Выход</a></li>
                        </ul>
                        <ul id="settings-dropdown" class="dropdown-content" style="min-width: 250px;">
                            <li><a href="/" target="_blank" class="red-text"><i class="material-icons left">open_in_new</i> Открыть сайт</a></li>
                            <li><a href="{{ route('admin.settings') }}" class="red-text"><i class="material-icons left">settings</i> Настройки сайта</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="container-fluid">
        <div class="row">
            <div class="col l3 m4 s4">
                <ul class="collection">
                    <a class="collection-item red-text" href="{{ route('admin.pages.index') }}"><i class="material-icons left">content_copy</i> Страницы</a>
                    <a class="collection-item red-text" href="{{ route('admin.blocks.index') }}"><i class="material-icons left">text_format</i> Текстовые блоки</a>
                    <a class="collection-item red-text" href="{{ route('admin.news.index') }}"><i class="material-icons left">featured_play_list</i> Новости</a>
                </ul>

                <ul class="collection">
                    <a class="collection-item red-text" href="{{ route('admin.users.index') }}"><i class="material-icons left">account_box</i>Карты</a>
                </ul>

                <ul class="collection">
                    <a class="collection-item red-text" href="{{ route('admin.settings') }}"><i class="material-icons left">settings</i>Настройки</a>
                    <a class="collection-item red-text" href="{{ route('admin.administrators.index') }}"><i class="material-icons left">verified_user</i>Администраторы</a>
                </ul>
            </div>
            <div class="col l9 m8 s8">
                @include('admin.partials._status')
                @include('admin.partials._errors')

                @yield('content')

                <p>&nbsp;</p>
            </div>
        </div>
    </main>

    @include('admin.partials._flash')

    <footer class="page-footer red">
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
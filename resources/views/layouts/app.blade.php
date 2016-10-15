<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('/css/app.bundle.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" type="text/css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Scripts -->
    <script src="{{ asset('/js/app.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script>window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?></script>

    @yield('header_scripts')

    <title>@yield('title')</title>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                <span class="sr-only">Меню</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('index') }}"><img alt="Brand" src="{{ asset('img/logo.png') }}" style="width: 30px; display: inline-block; vertical-align: middle;" class="img-responsive"> Ликойл</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('page.show', 'about') }}">О компании</a></li>
                <li><a href="{{ route('page.show', 'contacts') }}">Контакты</a></li>
                <li><a href="{{ route('news') }}">Новости</a></li>
                <li><a href="{{ route('feedback') }}">Обратная связь</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" id="dropdownUser" data-toggle="dropdown" aria-expanded="true">
                            <img class="avatar img-circle img-thumbnail" src="{{ Auth::user()->avatar ?: asset('img/avatar.png') }}">
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownUser">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('profile.personal') }}"><i class="fa fa-user"></i> Личный кабинет</a></li>
                            <li class="divider"></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('logout') }}"><i class="fa fa-sign-out"></i> Выход</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ url('login') }}"><i class="fa fa-sign-in"></i> Вход</a></li>
                    <li><a href="{{ url('register') }}"><i class="fa fa-user"></i> Регистрация</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div>Телефон: {{ $settings->phone }}</div>
                <div>Email: {{ $settings->email }}</div>
            </div>
            <div class="col-sm-4 text-center">
                <div class="lead">
                    <a href="#" data-toggle="modal" data-target="#callbackModal"><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Обратный звонок</a>
                </div>
            </div>
            <div class="col-sm-4 text-right">
                {{--текст в шапке справа--}}
            </div>
        </div>
    </div>
</header>

{!! $blocks['header']->text !!}

<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <p class="lead">меню</p>
            </div>
            <div class="col-lg-9 col-md-8">
                @include('partials._status')
                @include('partials._errors')

                @yield('content')
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="copyright">
                {!! $blocks['copyright']->text !!}
            </div>
        </div>
        <div class="row">
            <ul>
                <li><a href="{{ route('index') }}">Главная</a></li>
                <li><a href="{{ route('page.show', 'o-kompanii') }}">О компании</a></li>
                <li><a href="{{ route('page.show', 'kontakty') }}">Контакты</a></li>
                <li><a href="{{ route('news') }}">Новости</a></li>
                <li><a href="{{ route('feedback') }}">Обратная связь</a></li>
            </ul>
        </div>
    </div>
</footer>

@include('partials._callback')
@include('partials._flash')
@include('partials._metrika')

@yield('footer_scripts')

</body>
</html>
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

    <nav class="navbar navbar-default hidden-print">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('admin') }}">
                    <img src="/img/logo.png" class="img-responsive" style="height: 35px;">
                    <img class="img-responsive" src="{{ asset('img/brand-name.png') }}" style="height: 30px;" />
                </a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('admin.logout') }}" class="red-text" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i> Выход</a></li>
                        </ul>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Настройки <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/" target="_blank" class="red-text"><i class="material-icons">open_in_new</i> Открыть сайт</a></li>
                            <li><a href="{{ route('admin.settings') }}" class="red-text"><i class="material-icons">settings</i> Настройки сайта</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 hidden-print">
                <div class="list-group">
                    <a class="list-group-item" href="#"><i class="material-icons">credit_card</i> <strong>Настройки системы</strong></a>
                    <a class="list-group-item" href="{{ route('admin.cards.index') }}"><i class="material-icons">credit_card</i> Карты</a>
                    <a class="list-group-item" href="{{ route('admin.discounts.index') }}"><i class="material-icons">local_gas_station</i> Заливы</a>
                    <a class="list-group-item" href="{{ route('admin.withdrawals.index') }}"><i class="material-icons">card_giftcard</i> Использованные баллы</a>
                    <a class="list-group-item" href="{{ route('admin.campaigns.index') }}"><i class="material-icons">event_note</i> Акции</a>
                    <a class="list-group-item" href="{{ route('admin.users_export.index') }}"><i class="material-icons">account_box</i> Пользователи выгрузки</a>
                    <a class="list-group-item" href="{{ route('admin.users_azs.index') }}"><i class="material-icons">account_box</i> Пользователи АЗС</a>
                    <a class="list-group-item" href="{{ route('admin.rates.index') }}"><i class="material-icons">attach_money</i> Курсы</a>
                    <a class="list-group-item" href="{{ route('admin.settings') }}"><i class="material-icons">settings</i> Настройки</a>
                </div>

                <div class="list-group">
                    <a class="list-group-item list-group-item-warning" href="#"><i class="material-icons">web</i> <strong>Настройки сайта</strong></a>
                    <a class="list-group-item list-group-item-warning" href="{{ route('admin.gas_stations.index') }}"><i class="material-icons">local_gas_station</i> Список АЗС</a>
                    <a class="list-group-item list-group-item-warning" href="{{ route('admin.feedbacks.index') }}"><i class="material-icons">feedback</i> Отзывы</a>
                    <a class="list-group-item list-group-item-warning" href="{{ route('admin.pages.index') }}"><i class="material-icons">content_copy</i> Страницы</a>
                    <a class="list-group-item list-group-item-warning" href="{{ route('admin.blocks.index') }}"><i class="material-icons">text_format</i> Текстовые блоки</a>
                    <a class="list-group-item list-group-item-warning" href="{{ route('admin.news.index') }}"><i class="material-icons">featured_play_list</i> Новости</a>
                    <a class="list-group-item list-group-item-warning" href="{{ route('admin.web_settings') }}"><i class="material-icons">settings</i> Настройки</a>
                    <a class="list-group-item list-group-item-warning" href="{{ route('admin.administrators.index') }}"><i class="material-icons">verified_user</i> Администраторы сайта</a>
                    {{--<a class="list-group-item list-group-item-warning" href="{{ route('admin.roles.index') }}"><i class="material-icons">perm_identity</i> Роли</a>--}}
                    {{--<a class="list-group-item list-group-item-warning" href="{{ route('admin.permissions.index') }}"><i class="material-icons">security</i> Разрешения</a>--}}
                </div>

                <div class="list-group">
                    <a class="list-group-item list-group-item-danger" href="{{ route('admin.initialization') }}"><i class="material-icons">error_outline</i> <strong>ИНИЦИАЛИЗАЦИЯ</strong></a>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-8">
                @include('admin.partials._status')
                @include('admin.partials._errors')

                @yield('content')

                <p>&nbsp;</p>
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
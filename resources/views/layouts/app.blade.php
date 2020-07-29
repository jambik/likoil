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

    <!-- Custom Fonts -->
    <link href="//fonts.googleapis.com/css?family=Philosopher:400,400i,700,700i|Roboto+Slab:300,400,700|Scada:400,700&amp;subset=cyrillic" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('/js/app.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
    <script>window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?></script>

    @yield('header_scripts')

    <title>@yield('title')</title>
</head>
<body id="page-top" class="index">

<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Меню <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand  page-scroll" href="#page-top">
                <img src="{{ asset('img/logo-inverse.png') }}" class="img-responsive" style="height: 35px;">
{{--                <img class="img-responsive" src="{{ asset('img/brand-name-inverse.png') }}" style="height: 30px;" />--}}
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li>
                    <a class="page-scroll" href="#about">О карте</a>
                </li>
                <li>
                    <a class="page-scroll" href="#get">Как получить</a>
                </li>
                <li>
                    <a class="page-scroll" href="#save">Как накопить</a>
                </li>
                <li>
                    <a class="page-scroll" href="#spend">Как потратить</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact">Контакты</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<!-- Header -->
<header>
    <div class="container">
        <div class="intro-text">
            <div class="intro-lead-in">Выбирайте самое лучшее!</div>
            <div class="intro-heading">ДИСКОНТНЫЕ КАРТЫ Asko</div>
            <a href="#about" class="page-scroll btn btn-xl">подробнее</a>
        </div>
    </div>
</header>

<!-- Services Section -->
<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Дисконтная карта Asko</h2>
                <h3 class="section-subheading text-muted">За обслуживание и техническое сопровождение плата не взимается</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-map fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">ШИРОКАЯ СЕТЬ ПРИЕМА КАРТ</h4>
                <p class="text-muted">Более 60 АЗС в республик Дагестан.</p>
            </div>
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-percent fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">ВЫГОДНЫЕ УСЛОВИЯ РАБОТЫ</h4>
                <p class="text-muted">Гибкая тарифная программа. Комплексные решения для бизнеса.</p>
            </div>
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-check-square-o fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">КАЧЕСТВО ТОПЛИВА</h4>
                <p class="text-muted">Высокое качество достигается благодаря контролю всех этапов производственного цикла.</p>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Grid Section -->
<section id="get" class="bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Как получить карту</h2>
                <h3 class="section-subheading text-muted">Мы высоко ценим Вашу лояльность и стремимся быть полезными каждому владельцу Дисконтной Карты Asko!</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-credit-card fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">ПОЛУЧИТЕ КАРТУ</h4>
                <p class="text-muted">Получить карту Вы можете на любой АЗС «Asko»</p>
            </div>
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-vcard fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">ЗАРЕГИСТРИРУЙТЕ КАРТУ</h4>
                <p class="text-muted">Заполните анкету и Ваша карта будет зарегистрирована только за Вами</p>
            </div>
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-bookmark-o fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">СРАЗУ НАКАПЛИВАЙТЕ БАЛЛЫ</h4>
                <p class="text-muted">Предъявите карту оператору на АЗС и накапливайте бонусы</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="save">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Как накопить баллы</h2>
                <h3 class="section-subheading text-muted">Накапливайте больше баллов, используя дисконтную карту Asko</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-car fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">ВЫ ЗАПРАВЛЯЕТЕСЬ</h4>
                <p class="text-muted">При покупке топлива на АЗС «Asko» Вы предъявляете карту дисконтную карту</p>
            </div>
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-percent fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">НАЧИСЛЕНИЕ</h4>
                <p class="text-muted">Начисляются баллы на Вашу карту за каждый купленный литр топлива</p>
            </div>
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-credit-card fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">НАКАПЛИВАЙТЕ БАЛЛЫ</h4>
                <p class="text-muted">Чем больше Вы заправляетесь, тем больше баллов на карте</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section id="spend" class="bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Как потратить баллы</h2>
                <h3 class="section-subheading text-muted">Баллами можно воспользоваться только после регистрации карты</h3>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-credit-card fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">ПРЕДЪЯВИТЕ ВАШУ КАРТУ НА АЗС</h4>
                <p class="text-muted">Попросите оплатить покупку баллами с карты</p>
            </div>
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-percent fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">ОДИН БАЛЛ</h4>
                <p class="text-muted">Один балл равен одному рублю скидки</p>
            </div>
            <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                    </span>
                <h4 class="service-heading">ОПЛАТИТЕ ВСЮ ПОКУПКУ БАЛЛАМИ</h4>
                <p class="text-muted">Не внося в кассу ни одного рубля</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">КОНТАКТЫ</h2>
                <p>&nbsp;</p>
                <p><strong>Телефоны:</strong><br/><i class="fa fa-phone-square">&nbsp;</i> +7 (8722) 55-54-63<br/><i class="fa fa-phone-square">&nbsp;</i> +7 989 665-20-75</p>
                <p><strong>Email:</strong><br/><i class="fa fa-envelope">&nbsp;</i> nmm888@gmail.com</p>
                <p><strong>Факс:</strong><br/><i class="fa fa-fax">&nbsp;</i> +7 988 293-00-38</p>
                <p><strong>Адрес:</strong><br/><i class="fa fa-map-marker">&nbsp;</i> г. Махачкала, пр-кт Акушинского, 34а (19 линия)</p>
                <p><strong>Юридическая информация:</strong><br/>ОГРН - 1020502463464<br/>ИНН -&nbsp;0560024903<br/>КПП - 057301001</p>
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form name="sentMessage" id="contactForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Ваше имя *" id="name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Ваш Email *" id="email" required>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Ваш телефон *" id="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Ваше сообщение *" id="message" required ></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <div id="success"></div>
                            <button type="submit" class="btn btn-xl">Отправить сообщение</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright">Copyright &copy; Asko 2016</span>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</footer>

@include('partials._flash')
@include('partials._metrika')

<!-- Plugin JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

@yield('footer_scripts')

</body>
</html>
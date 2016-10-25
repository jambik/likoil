@extends('admin.layouts.auth')

@section('title', 'Администрирование - Вход - Ликойл')

@section('content')
    <form class="col s12" method="POST" action="{{ route('admin.login') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="validate">
            <label for="email">Email</label>
        </div>

        <div class="form-group">
            <input id="password" name="password" type="password" class="validate">
            <label for="password">Пароль</label>
        </div>

        <p class="col s12">
            <input type="checkbox" id="remember" name="remember" />
            <label for="remember">Запомнить меня</label>
        </p>

        <p class="col s12 center">
            <button type="submit" class="btn btn-lg btn-primary">Вход</button>
        </p>
    </form>
@endsection
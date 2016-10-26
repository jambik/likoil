@extends('admin.layouts.auth')

@section('title', 'Администрирование - Вход - Ликойл')

@section('content')

    <form method="POST" action="{{ route('admin.login') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input id="password" name="password" type="password" class="form-control">
        </div>

        <div class="form-group">
            <input type="checkbox" id="remember" name="remember" />
            <label for="remember">Запомнить меня</label>
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-lg btn-primary">Вход</button>
        </div>
    </form>
@endsection
@extends('layouts.app')

@section('title', 'Личный кабинет - Смена пароля')

@section('content')
    @include('partials._personal_menu', ['passwordActive' => true])

    <form class="form-horizontal" role="form" method="POST" action="{{ route('profile.password.save') }}">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Старый пароль</label>

            <div class="col-md-6">
                <input type="password" class="form-control" name="old_password">

                @if ($errors->has('old_password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('old_password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Новый пароль</label>

            <div class="col-md-6">
                <input type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Новый пароль еще раз</label>

            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation">

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-block btn-primary">Сменить пароль</button>
            </div>
        </div>
    </form>
@endsection
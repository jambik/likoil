@extends('layouts.app')

@section('title', 'Личный кабинет - Персональные данные')

@section('content')
    @include('partials._personal_menu', ['personalActive' => true])

    <form class="form-horizontal" role="form" method="POST" action="{{ route('profile.personal.save') }}">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Имя</label>

            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">E-Mail</label>

            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Телефон</label>

            <div class="col-md-6">
                <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}">

                @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-block btn-primary">Обновить данные</button>
            </div>
        </div>
    </form>
@endsection
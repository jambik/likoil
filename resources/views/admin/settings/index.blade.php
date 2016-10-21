@extends('admin.layouts.full')

@section('title', 'Администрирование - Настройки')

@section('content')
    <h4 class="center">Настройки</h4>
    <div class="row">
        <div class="col l6 offset-l3 m8 offset-m2">
            {!! Form::model($settings, ['url' => route('admin.settings.save'), 'method' => 'POST', 'files' => true]) !!}
                <div class="input-field col s12">
                    {!! Form::label('step', 'Шаг увеличения/уменьшения балов') !!}
                    {!! Form::text('step', null, ['class' => 'validate']) !!}
                </div>

                <div class="input-field col s12">
                    {!! Form::label('min', 'Минимальный порог') !!}
                    {!! Form::text('min', null, ['class' => 'validate']) !!}
                </div>

                <div class="input-field col s12">
                    {!! Form::label('max', 'Максимальный порог') !!}
                    {!! Form::text('max', null, ['class' => 'validate']) !!}
                </div>

                <div class="col s12 center">
                    <button type="submit" class="btn-large red waves-effect waves-light"><i class="material-icons left">check_circle</i>Сохранить настройки</button>
                </div>

                <div>&nbsp;</div>

                <div class="col s12 center">
                    <a href="{{ route('admin') }}" class="btn grey waves-effect waves-light">Отмена</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('head_scripts')
    <script src="/library/ckeditor/ckeditor.js"></script>
@endsection

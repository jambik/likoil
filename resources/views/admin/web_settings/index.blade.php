@extends('admin.layouts.full')

@section('title', 'Администрирование - Настройки')

@section('content')
    <h2 class="text-center">Настройки</h2>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            {!! Form::model($settings, ['url' => route('admin.settings.save'), 'method' => 'POST', 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('phone', 'Телефон') !!}
                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group input-html">
                    {!! Form::label('description', 'Описание сайта') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i>Сохранить настройки</button>
                </div>

                <div class="form-group text-center">
                    <a href="{{ route('admin') }}" class="btn btn-default">Отмена</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('head_scripts')
    <script src="/library/ckeditor/ckeditor.js"></script>
@endsection

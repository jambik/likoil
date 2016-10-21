@extends('admin.layouts.full')

@section('title', 'Администрирование - Инициализация')

@section('content')
    <h4 class="center">Инициализация</h4>
    <div class="row">
        <div class="col l6 offset-l3 m8 offset-m2">
            <form action="{{ route('admin.initialization.save') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="input-field file-field col s12">
                    <h5 class="center">Расход</h5>
                    <div class="btn">
                        <span>Файл</span>
                        {!! Form::file('file_withdrawal') !!}
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate{{ $errors->has('file_withdrawal') ? ' invalid' : '' }}" type="text" placeholder="Выберите файл (CSV) с расходами">
                    </div>
                </div>

                <div class="input-field file-field col s12">
                    <h5 class="center">Данные о картах</h5>
                    <div class="btn">
                        <span>Файл</span>
                        {!! Form::file('file_cards') !!}
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate{{ $errors->has('file_cards') ? ' invalid' : '' }}" type="text" placeholder="Выберите файл (CSV) с данными о картах">
                    </div>
                </div>

                <div class="input-field col s12 center">
                    <button type="submit" class="btn-large red waves-effect waves-light"><i class="material-icons left">check_circle</i>Инициализировать</button>
                </div>
            </form>
        </div>
    </div>
@endsection

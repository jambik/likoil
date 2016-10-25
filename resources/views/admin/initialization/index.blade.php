@extends('admin.layouts.full')

@section('title', 'Администрирование - Инициализация')

@section('content')
    <h2 class="text-center">Инициализация</h2>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            <form action="{{ route('admin.initialization.save') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="file_withdrawal">Расход</label>
                    <input type="file" name="file_withdrawal" id="file_withdrawal" class="filestyle" data-buttonBefore="true" data-buttonText="Выберите файл">
                    <small>Выберите файл (CSV) с расходами</small>
                </div>

                <div class="form-group">
                    <label for="file_cards">Данные о картах</label>
                    <input type="file" name="file_cards" id="file_cards" class="filestyle" data-buttonBefore="true" data-buttonText="Выберите файл">
                    <small>Выберите файл (CSV) с данными о картах</small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i>Инициализировать</button>
                </div>
            </form>
        </div>
    </div>
@endsection

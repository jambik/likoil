@extends('admin.layouts.full')

@section('title', 'Администрирование - Удаление')

@section('content')
    <h2 class="text-center">Удаление</h2>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            <form action="{{ route('admin.delete.post') }}" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="delete_cards">Номер карты</label>
                    <textarea class="form-control" name="cards" id="cards"></textarea>
                    <small>Введите номера карт, через запятую</small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-danger"><i class="material-icons">delete_forever</i> Удалить</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('admin.layouts.full')

@section('title', 'Администрирование - АЗС')

@section('content')
    <h2 class="text-center">Страницы</h2>
    <p><a href="{{ route('admin.gas_stations.create') }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Название</th>
                    <th>Местоположение</th>
                    <th>Адрес</th>
                    <th>Телефон</th>
                    <th>Координаты</th>
                    <th>Коды</th>
                    <th>Услуги</th>
                    <th>Виды топлива</th>
                    <th data-orderable="false" class="btn-collumn"></th>
                    <th data-orderable="false" class="btn-collumn"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->city }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->lat }}, {{ $item->lng }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->tags_service }}</td>
                        <td>{{ $item->tags_fuel }}</td>
                        <td><a href="{{ route('admin.gas_stations.edit', $item->id) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>
                        <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection

@extends('admin.layouts.full')

@section('title', 'Администрирование - Акции')

@section('content')
    <h2 class="text-center">Акции</h2>
    <p><a href="{{ route('admin.campaigns.create') }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Название</th>
                    <th>Дата начала</th>
                    <th>Дата конца</th>
                    <th>Курс</th>
                    <th>Время</th>
                    <th>АЗС</th>
                    <th>Вид топлива</th>
                    <th>Дни</th>
                    <th data-orderable="false" class="btn-collumn"></th>
                    <th data-orderable="false" class="btn-collumn"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->start_at ? $item->start_at->toDateString() : '' }}</td>
                        <td>{{ $item->end_at ? $item->end_at->toDateString() : '' }}</td>
                        <td>{{ $item->rate }}</td>
                        <td>{{ $item->time_start }} - {{ $item->time_end }}</td>
                        <td>{{ $item->azs_names ?: '-' }}</td>
                        <td>{{ $item->fuels_names ?: '-' }}</td>
                        <td>{{ $item->days ?: '-' }}</td>
                        <td><a href="{{ route('admin.campaigns.edit', $item->id) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>
                        <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection

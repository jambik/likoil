@extends('admin.layouts.full')

@section('title', 'Администрирование - Добавленные бонусы')

@section('content')
    <h2 class="text-center">Добавленные бонусы</h2>
    <p><a href="{{ route('admin.bonus.create') }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover" data-order="[[ 4, &quot;desc&quot; ]]">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Номер карта</th>
                    <th>Баллы</th>
                    <th>Комментарий</th>
                    <th>Администратор</th>
                    <th>Дата</th>
                    <th data-orderable="false" class="btn-collumn"></th>
                    <th data-orderable="false" class="btn-collumn"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->card->code }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->comment }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td><a href="{{ route('admin.bonus.edit', $item->id) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>
                        <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection

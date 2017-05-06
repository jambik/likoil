@extends('admin.layouts.full')

@section('title', 'Администрирование - Отзывы')

@section('content')
    <h2 class="text-center">Отзывы</h2>

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover" data-order="[[ 3, &quot;desc&quot; ]]">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Пользователь</th>
                    <th>Отзыв</th>
                    <th>Дата</th>
                    <th data-orderable="false" class="btn-collumn"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->message }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection
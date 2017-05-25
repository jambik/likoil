@extends('admin.layouts.full')

@section('title', 'Администрирование - Пользователи')

@section('content')
    <h4 class="text-center">Пользователи</h4>
    <p><a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Аватар</th>
                    <th>Имя</th>
                    <th>Логин (Карта)</th>
                    <th data-orderable="false" class="btn-collumn"></th>
                    {{--<th data-orderable="false" class="btn-collumn"></th>--}}
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>@if ($item->avatar)<img src='{{ $item->avatar }}' alt='' />@endif</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td><a href="{{ route('admin.notification', ['user' => $item->id]) }}" class="btn btn-primary btn-small"><i class="material-icons">phonelink_ring</i></a></td>
                        {{--<td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>--}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection

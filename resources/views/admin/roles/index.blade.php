@extends('admin.layouts.full')

@section('title', 'Администрирование - Роли')

@section('content')
    <h2 class="text-center">Роли</h2>
    <p><a href="{{ route('admin.roles.create') }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Название роли</th>
                    <th>Отображаемое имя</th>
                    <th>Описание роли</th>
                    <th>Разрешения роли</th>
                    <th data-orderable="false" class="btn-collumn"></th>
                    <th data-orderable="false" class="btn-collumn"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->display_name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->permissions_display_names }}</td>
                        <td><a href="{{ route('admin.roles.edit', $item->id) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>
                        <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection

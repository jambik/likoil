@extends('admin.layouts.full')

@section('title', 'Администрирование - Страницы')

@section('content')
    <h2 class="text-center">Страницы</h2>
    <p><a href="{{ route('admin.pages.create') }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Название</th>
                    <th>Title</th>
                    <th>Alias</th>
                    <th>Текст</th>
                    <th data-orderable="false" class="btn-collumn"></th>
                    <th data-orderable="false" class="btn-collumn"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->slug }}</td>
                        <td>{{ str_limit(strip_tags($item->text), 300) }}</td>
                        <td><a href="{{ route('admin.pages.edit', $item->id) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>
                        <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection

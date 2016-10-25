@extends('admin.layouts.full')

@section('title', 'Администрирование - Новости')

@section('content')
    <h2 class="text-center">Новости</h2>
    <p><a href="{{ route('admin.news.create') }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover" data-order="[[ 4, &quot;desc&quot; ]]">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Фото</th>
                    <th>Заголовок</th>
                    <th>Текст новости</th>
                    <th>Дата публикации</th>
                    <th data-orderable="false" class="btn-collumn"></th>
                    <th data-orderable="false" class="btn-collumn"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>@if ($item->image)<img src='/images/small/{{ $item->img_url.$item->image }}' alt='' />@endif</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ str_limit(strip_tags($item->text), 300) }}</td>
                        <td>{{ $item->published_at }}</td>
                        <td><a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>
                        <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection

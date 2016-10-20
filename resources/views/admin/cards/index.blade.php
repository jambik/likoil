@extends('admin.layouts.full')

@section('title', 'Администрирование - Карты')

@section('content')
    <h4 class="center">Карты</h4>
    <p><a href="{{ route('admin.cards.create') }}" class="btn red waves-effect waves-light"><i class="material-icons left">add_circle</i> Добавить</a></p>

    {{--@if ($items->count())--}}
        <div class="table-responsive table-ajax">
            <table id="table_items_ajax" class="striped bordered highlight responsive-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Номер карты</th>
                        <th>Бонусы</th>
                        <th>Имя</th>
                        <th>Пол</th>
                        <th>Телефон</th>
                        <th>Дата рождения</th>
                        <th>Подтвержден</th>
                    </tr>
                </thead>
                <tbody>
                    {{--@foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->bonus }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->birthday_at }}</td>
                            <td>{{ $item->verified }}</td>
                            <td><a href="{{ route('admin.cards.edit', $item->id) }}" class="btn btn-small waves-effect waves-light"><i class="material-icons">edit</i></a></td>
                            <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-small waves-effect waves-light red darken-2"><i class="material-icons">delete</i></button></td>
                        </tr>
                    @endforeach--}}
                </tbody>
            </table>
        </div>
    {{--@else--}}
        {{--<div class="no-items"></div>--}}
    {{--@endif--}}
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        // Применяем плагин DataTable к таблице элементов
        if ($('#table_items_ajax').length) {

            $('#table_items_ajax').DataTable({
                "language": {
                    "url": "{{ asset('js/DataTable.Russian.json') }}"
                },
                "pagingType": "full",
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.cards.index') }}"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "code" },
                    { "data": "bonus" },
                    { "data": "name" },
                    { "data": "gender" },
                    { "data": "phone" },
                    { "data": "birthday_at" },
                    { "data": "verified" }
                ]
            });

        }
    </script>
@endsection
@extends('admin.layouts.full')

@section('title', 'Администрирование - Использованные баллы')

@section('content')
    <h4 class="center">Использованные баллы</h4>
    <p><a href="{{ route('admin.withdrawals.create') }}" class="btn red waves-effect waves-light"><i class="material-icons left">add_circle</i> Добавить</a></p>

    {{--@if ($items->count())--}}
        <div class="table-responsive table-ajax">
            <table id="table_items_ajax" class="striped bordered highlight responsive-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Карта</th>
                        <th>Баллы</th>
                        <th>Тип</th>
                        <th>АЗС</th>
                        <th>Дата использования</th>
                    </tr>
                </thead>
                <tbody>
                    {{--@foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->card->code }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->azs }}</td>
                            <td>{{ $item->use_at }}</td>
                            <td><a href="{{ route('admin.withdrawals.edit', $item->id) }}" class="btn btn-small waves-effect waves-light"><i class="material-icons">edit</i></a></td>
                            <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-small waves-effect waves-light red darken-2"><i class="material-icons">delete</i></button></td>
                        </tr>
                    @endforeach--}}
                </tbody>
            </table>
        </div>
    {{--@else
        <div class="no-items"></div>
    @endif--}}
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
                    "url": "{{ route('admin.withdrawals.index') }}"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "code" },
                    { "data": "amount" },
                    { "data": "type" },
                    { "data": "azs" },
                    { "data": "use_at" }
                ]
            });
        }
    </script>
@endsection
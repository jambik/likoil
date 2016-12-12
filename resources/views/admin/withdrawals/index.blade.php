@extends('admin.layouts.full')

@section('title', 'Администрирование - Использованные баллы')

@section('content')
    <h2 class="text-center">Использованные баллы</h2>
{{--    <p><a href="{{ route('admin.withdrawals.create') }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>--}}

    {{--@if ($items->count())--}}
    <div class="table-responsive">
        <table id="table_items_ajax" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Карта</th>
                        <th>Баллы</th>
                        <th>Тип</th>
                        <th>АЗС</th>
                        <th>Дата использования</th>
                        <th>Печать</th>
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
                            <td><a href="{{ route('admin.withdrawals.edit', $item->id) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>
                            <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
                        </tr>
                    @endforeach--}}
                </tbody>
            </table>
        </div>
    {{--@else
        <div class="no-items"></div>
    @endif--}}
    <input type="text" value="1" name="date_start" id="date_start">
    <input type="text" value="99" name="date_end" id="date_end">
    <button class="check-btn">check</button>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        // Применяем плагин DataTable к таблице элементов
        if ($('#table_items_ajax').length) {

            var table = $('#table_items_ajax').DataTable({
                "language": {
                    "url": "{{ asset('js/DataTable.Russian.json') }}"
                },
                "pagingType": "full",
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.withdrawals.index') }}",
                    "data": function ( d ) {
                        d.date_start = $('#date_start').val();
                        d.date_end = $('#date_end').val();
                    }
                },
                searchDelay: 500,
                "columns": [
                    { "data": "id" },
                    { "data": "code" },
                    { "data": "amount" },
                    { "data": "type" },
                    { "data": "azs" },
                    { "data": "use_at" },
                    {
                        "className":      'btn-collumn td-print',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent" : '<button style="padding: 0 5px;" class="btn btn-default"><i class="material-icons">print</i></button>'
                    },
                ],
                "order": [[ 5, "desc" ]]
            });

            $('.check-btn').on('click', function(){
                table.search($('#table_items_ajax_filter input').val()).draw();
            });

            // Добавление события на нажатие кнопки Печать
            $('#table_items_ajax tbody').on('click', 'td.td-print', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                var location = '/admin/withdrawals/' +  row.data().id;

                var win = window.open(location, '_blank');
                win.focus();
            });
        }
    </script>
@endsection
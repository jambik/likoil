@extends('admin.layouts.full')

@section('title', 'Администрирование - Использованные баллы')

@section('content')
    <h2 class="text-center">Использованные баллы</h2>

    <div class="daterange-picker-wrapper">
        <label for="daterange">Дата:</label>
        <input type="text" name="daterange" id="daterange" class="daterange-picker form-control input-sm pull-right">
    </div>
    <div class="clearfix"></div>

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
    </table>
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
                        d.daterange = $('#daterange').val();
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

            });

            $('.daterange-picker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY.MM.DD') + ' - ' + picker.endDate.format('YYYY.MM.DD'));
                table.search($('#table_items_ajax_filter input').val()).draw();
            });

            $('.daterange-picker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
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
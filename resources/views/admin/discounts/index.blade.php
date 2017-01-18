@extends('admin.layouts.full')

@section('title', 'Администрирование - Заливы')

@section('content')
    <h2 class="text-center">Заливы</h2>

    <table id="table_items_ajax" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Карта</th>
                <th>Дата</th>
                <th>Объем</th>
                <th>Цена</th>
                <th>Сумма</th>
                <th>Топливо</th>
                <th>Код АЗС</th>
                <th>Бонус</th>
            </tr>
        </thead>
    </table>
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
                    "url": "{{ route('admin.discounts.index') }}"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "code" },
                    { "data": "date" },
                    { "data": "volume" },
                    { "data": "price" },
                    { "data": "amount" },
                    { "data": "fuel_name" },
                    { "data": "azs" },
                    { "data": "point" }
                ]
            });
        }
    </script>
@endsection
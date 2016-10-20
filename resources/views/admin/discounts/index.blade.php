@extends('admin.layouts.full')

@section('title', 'Администрирование - Заливы')

@section('content')
    <h4 class="center">Заливы</h4>
    <p><a href="{{ route('admin.discounts.create') }}" class="btn red waves-effect waves-light"><i class="material-icons left">add_circle</i> Добавить</a></p>

    {{--@if ($items->count())--}}
        <div class="table-responsive table-ajax">
            <table id="table_items_ajax" class="striped bordered highlight responsive-table">
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
                <tbody>
                    {{--@foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->card->code }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->volume }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->fuel_name }}</td>
                            <td>{{ $item->azs }}</td>
                            <td><strong class="red-text text-darken-2">{{ $item->point }}</strong></td>
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
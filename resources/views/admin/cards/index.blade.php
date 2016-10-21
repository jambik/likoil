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
                    { "data": "info.full_name" },
                    { "data": "info.gender" },
                    { "data": "info.phone" },
                    { "data": "info.birthday_at" }
                ]
            });
        }

        $.fn.dataTableExt.sErrMode = "console";

        $.fn.dataTableExt.oApi._fnLog = function (oSettings, iLevel, sMesg, tn) {
            var sAlert = (oSettings === null)
                            ? "DataTables warning: "+sMesg
                            : "DataTables warning (table id = '"+oSettings.sTableId+"'): "+sMesg
                    ;

            if (tn) {
                sAlert += ". For more information about this error, please see "+
                        "http://datatables.net/tn/"+tn
                ;
            }

            if (iLevel === 0) {
                if ($.fn.dataTableExt.sErrMode == "alert") {
                    alert(sAlert);
                } else if ($.fn.dataTableExt.sErrMode == "thow") {
                    throw sAlert;
                } else  if ($.fn.dataTableExt.sErrMode == "console") {
                    console.log(sAlert);
                } else  if ($.fn.dataTableExt.sErrMode == "mute") {}

                return;
            } else if (console !== undefined && console.log) {
                console.log(sAlert);
            }
        }
    </script>
@endsection
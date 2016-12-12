@extends('admin.layouts.full')

@section('title', 'Администрирование - Карты')

@section('content')
    <h2 class="text-center">Карты</h2>
{{--    <p><a href="{{ route('admin.cards.create') }}" class="btn btn-default btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>--}}

    {{--@if ($items->count())--}}
        <div class="table-responsive">
            <table id="table_items_ajax" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Номер карты</th>
                        <th>Бонусы</th>
                        <th>Имя</th>
                        <th>Пол</th>
                        <th>Телефон</th>
                        <th>Дата рождения</th>
                        <th>Инфо</th>
                        <th>Логин</th>
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
                            <td><a href="{{ route('admin.cards.edit', $item->id) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>
                            <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>
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

            var table = $('#table_items_ajax').DataTable({
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
                    { "data": "bonus", "orderable": false },
                    { "data": "info.full_name", "orderable": false },
                    { "data": "info.gender_letter", "orderable": false },
                    { "data": "info.phone", "orderable": false },
                    { "data": "info.birthday_at_formatted", "orderable": false },
                    {
                        "className":      'btn-collumn card-info',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent" : '<button style="padding: 0 5px;" class="btn btn-success"><i class="material-icons">info_outline</i></button>'
                    },
                    {
                        "className":      'btn-collumn card-login',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent" : '<button style="padding: 0 5px;" class="btn btn-success"><i class="material-icons">vpn_key</i></button>'
                    },
                ],
                "createdRow": function ( row, data, index ) {
                    if ( ! data.info) {
                        $(row).find('.card-info button').removeClass('btn-success').addClass('btn-primary');
                        $(row).find('.card-login button').hide();
                    } else if ( ! data.info.user_id) {
                        $(row).find('.card-login button').removeClass('btn-success').addClass('btn-primary');
                    }
                }
            });

            // Добавление события на нажатие кнопки Инфо
            $('#table_items_ajax tbody').on('click', 'td.card-info', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                var location = '/admin/cards/' +  row.data().id + '/info';

                document.location = location;
            });

            // Добавление события на нажатие кнопки Логин
            $('#table_items_ajax tbody').on('click', 'td.card-login', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                var location = '/admin/cards/' +  row.data().id + '/login';

                document.location = location;
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
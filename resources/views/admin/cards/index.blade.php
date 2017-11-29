@extends('admin.layouts.full')

@section('title', 'Администрирование - Карты')

@section('content')
    <h2 class="text-center">Карты</h2>

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
                <th>Масло</th>
                <th>Замена<br>карты</th>
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
                    {
                        "className":      'btn-collumn card-oil',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent" : '<button style="padding: 0 5px;" class="btn btn-default"><i class="material-icons">opacity</i></button>'
                    },
                    {
                        "className":      'btn-collumn card-exchange',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent" : '<button style="padding: 0 5px;" class="btn btn-default"><i class="material-icons">find_replace</i></button>'
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

            // Добавление события на нажатие кнопки Замена масла
            $('#table_items_ajax tbody').on('click', 'td.card-oil', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                var location = '/admin/oil_changes?card=' +  row.data().id;

                document.location = location;
            });

            // Добавление события на нажатие кнопки Замена карты
            $('#table_items_ajax tbody').on('click', 'td.card-exchange', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                var location = '/admin/cards/' +  row.data().id + '/card_exchange';

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
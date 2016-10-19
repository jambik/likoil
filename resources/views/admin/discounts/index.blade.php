@extends('admin.layouts.full')

@section('title', 'Администрирование - Заливы')

@section('content')
    <h4 class="center">Заливы</h4>
    <p><a href="{{ route('admin.discounts.create') }}" class="btn red waves-effect waves-light"><i class="material-icons left">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <div class="table-responsive">
            <table id="table_items">
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
                        <th class="filter-false btn-collumn" data-sorter="false"></th>
                        <th class="filter-false btn-collumn" data-sorter="false"></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="11" class="pager form-inline">
                            <button type="button" class="btn btn-small red waves-effect waves-light first"><i class="material-icons">first_page</i></button>
                            <button type="button" class="btn btn-small red waves-effect waves-light prev"><i class="material-icons">navigate_before</i></button>
                            <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
                            <button type="button" class="btn btn-small red waves-effect waves-light next"><i class="material-icons">navigate_next</i></button>
                            <button type="button" class="btn btn-small red waves-effect waves-light last"><i class="material-icons">last_page</i></button>
                            <select class="pagesize" title="Размер страницы">
                                <option selected="selected" value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <select class="gotoPage" title="Номер страницы"></select>
                        </th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($items as $item)
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
                            <td><a href="{{ route('admin.discounts.edit', $item->id) }}" class="btn btn-small waves-effect waves-light"><i class="material-icons">edit</i></a></td>
                            <td><button onclick="confirmDelete(this, '{{ $item->id }}')" class="btn btn-small waves-effect waves-light red darken-2"><i class="material-icons">delete</i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="no-items"></div>
    @endif
@endsection

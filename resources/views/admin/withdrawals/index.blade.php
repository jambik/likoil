@extends('admin.layouts.full')

@section('title', 'Администрирование - Использованные баллы')

@section('content')
    <h4 class="center">Использованные баллы</h4>
    <p><a href="{{ route('admin.withdrawals.create') }}" class="btn red waves-effect waves-light"><i class="material-icons left">add_circle</i> Добавить</a></p>

    @if ($items->count())
        <div class="table-responsive">
            <table id="table_items">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Карта</th>
                        <th>Баллы</th>
                        <th>Тип</th>
                        <th>АЗС</th>
                        <th>Дата использования</th>
                        <th class="filter-false btn-collumn" data-sorter="false"></th>
                        <th class="filter-false btn-collumn" data-sorter="false"></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="8" class="pager form-inline">
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
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->azs }}</td>
                            <td>{{ $item->use_at }}</td>
                            <td><a href="{{ route('admin.withdrawals.edit', $item->id) }}" class="btn btn-small waves-effect waves-light"><i class="material-icons">edit</i></a></td>
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
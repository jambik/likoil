@extends('admin.layouts.blank')

@section('title', 'Администрирование - Использованные баллы')

@section('content')
    <h2 class="text-center">Использование баллов</h2>
    <p>&nbsp;</p>
    <div class="text-center">
        <table class="table table-nonfluid text-left" style="margin: 0 auto;">
            <tbody>
                <tr>
                    <td>Карта:</td>
                    <td>{{ $item->card->code }}</td>
                </tr>
                <tr>
                    <td>Количество списанных баллов:</td>
                    <td>{{ $item->amount }}</td>
                </tr>
                <tr>
                    <td>Тип операции:</td>
                    <td>{{ $item->type }}</td>
                </tr>
                <tr>
                    <td>АЗС:</td>
                    <td>{{ $item->azs }}</td>
                </tr>
                <tr>
                    <td>Дата:</td>
                    <td>{{ $item->use_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p>&nbsp;</p>
    <div class="text-center hidden-print">
        <button onclick="window.print();" class="btn btn-default"><i class="material-icons">print</i> Печать</button>
    </div>
@endsection

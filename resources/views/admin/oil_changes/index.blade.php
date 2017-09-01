@extends('admin.layouts.full')

@section('title', 'Администрирование - Замена масла')

@section('content')
    <h2 class="text-center">Замена масла</h2>
    @if($card)
        <h3 class="text-center">Карта: {{ $card->code }}</h3>
        <p><a href="{{ route('admin.oil_changes.create', ['card' => request()->get('card')]) }}" class="btn btn-success"><i class="material-icons">add_circle</i> Добавить</a></p>
    @endif

    @if ($items->count())
        <table id="table_items" class="table table-stripped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Карта</th>
                    <th>Пробег</th>
                    <th>Дата замены</th>
                    @if(request()->exists('card'))<th data-orderable="false" class="btn-collumn"></th>@endif
                    @if(request()->exists('card'))<th data-orderable="false" class="btn-collumn"></th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->card->code }}</td>
                        <td>{{ $item->mileage }}</td>
                        <td>{{ $item->change_at }}</td>
                        @if(request()->exists('card'))<td><a href="{{ route('admin.oil_changes.edit', ['id' => $item->id, 'card' => request()->get('card')]) }}" class="btn btn-primary btn-small"><i class="material-icons">edit</i></a></td>@endif
                        @if(request()->exists('card'))<td><button onclick="confirmDelete(this, '{{ $item->id }}', '{{ route('admin.oil_changes.destroy', ['id' => $item->id, 'card' => request()->get('card')]) }}')" class="btn btn-danger btn-small"><i class="material-icons">delete</i></button></td>@endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-items"></div>
    @endif
@endsection

@extends('admin.layouts.full')

@section('title', 'Администрирование - Заливы')

@section('content')
	<h4 class="center">Редактировать</h4>
	<div class="row">
        <div class="col l6 offset-l3 m8 offset-m2">
			<div class="row">
                {!! Form::model($item, ['url' => route('admin.discounts.update', $item->id), 'method' => 'PUT', 'files' => true]) !!}
                    @include('admin.discounts.form', ['submitButtonText' => 'Сохранить'])
                {!! Form::close() !!}
            </div>
		</div>
	</div>
@endsection

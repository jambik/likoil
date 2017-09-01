@extends('admin.layouts.full')

@section('title', 'Администрирование - Замена масла')

@section('content')
	<h2 class="text-center">Редактировать</h2>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
			<div class="row">
                {!! Form::model($item, ['url' => route('admin.oil_changes.update', ['id' => $item->id, 'card' => request()->get('card')]), 'method' => 'PUT', 'files' => true]) !!}
                    @include('admin.oil_changes.form', ['submitButtonText' => 'Сохранить'])
                {!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection

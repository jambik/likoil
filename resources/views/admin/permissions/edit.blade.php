@extends('admin.layouts.full')

@section('title', 'Администрирование - Разрешения')

@section('content')
	<h2 class="text-center">Редактировать</h2>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
			<div class="row">
				{!! Form::model($item, ['url' => route('admin.permissions.update', $item->id), 'method' => 'PUT', 'files' => true]) !!}
					@include('admin.permissions.form', ['submitButtonText' => 'Обновить'])
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection

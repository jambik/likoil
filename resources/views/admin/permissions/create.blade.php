@extends('admin.layouts.full')

@section('title', 'Администрирование - Разрешения')

@section('content')
	<h2 class="text-center">Создать</h2>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
			<div class="row">
				{!! Form::open(['url' => route('admin.permissions.store'), 'method' => 'POST', 'files' => true]) !!}
				@include('admin.permissions.form', ['submitButtonText' => 'Добавить'])
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection

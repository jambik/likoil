@extends('admin.layouts.full')

@section('title', 'Администрирование - Пользователи АЗС')

@section('content')
	<h2 class="text-center">Редактировать</h2>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
			<div class="row">
				{!! Form::model($item, ['url' => route('admin.users_azs.update', $item->id), 'method' => 'PUT', 'files' => true]) !!}
					@include('admin.users_azs.form', ['submitButtonText' => 'Обновить'])
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection

@extends('admin.layouts.full')

@section('title', 'Администрирование - Карты')

@section('content')
	<h2 class="text-center">Логин для карты - {{ $card->code }}</h2>
	<p>&nbsp;</p>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2">
			<form action="{{ route('admin.cards.login.save', $card->id)}}" method="POST">
				{{ csrf_field() }}

				<div class="row">
					<div class="form-group">
						{!! Form::label('login', 'Логин (Номер карты - 13 цифр)') !!}
						{!! Form::text('login', $card->info->user && $card->info->user->email ? $card->info->user->email : $card->code, ['class' => 'form-control']) !!}
{{--						<small>Номер вводится без +7 или 8</small>--}}
					</div>

					<div class="form-group">
						{!! Form::label('password', 'Пароль') !!}
						{!! Form::text('password', $card->info ? $card->info->password : '', ['class' => 'form-control']) !!}
					</div>
				</div>

				<div class="row">
					<div class="form-group text-center">
						<button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> Обновить информацию</button>
					</div>

					<div class="form-group text-center">
						<a href="{{ route('admin.cards.index') }}" class="btn btn-default">Отмена</a>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

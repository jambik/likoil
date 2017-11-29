@extends('admin.layouts.full')

@section('title', 'Администрирование - Карты')

@section('content')
	<h2 class="text-center">Смена карты #{{ $card->code }}</h2>
	<p>&nbsp;</p>
	<h4 class="text-center text-danger">Найдено {{ $card->discounts->count() }} заливов по карте</h4>
	<h4 class="text-center text-danger">На сумму {{ $card->discounts->sum('amount') }} руб.</h4>
	<p>&nbsp;</p>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4 col-md-8 col-md-offset-2">
			<form action="{{ route('admin.cards.exchange.save', $card->id)}}" method="POST">
				{{ csrf_field() }}

				<div class="row">
					<div class="form-group">
						{!! Form::label('card_exchange', 'Новый номер карты') !!}
						{!! Form::text('card_exchange', null, ['class' => 'form-control']) !!}
						<small>13 цифр</small>
					</div>
				</div>

				<div class="row">
					<div class="form-group text-center">
						<button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> Сменить карту</button>
					</div>

					<div class="form-group text-center">
						<a href="{{ route('admin.cards.index') }}" class="btn btn-default">Отмена</a>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

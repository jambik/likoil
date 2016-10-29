@extends('admin.layouts.full')

@section('title', 'Администрирование - Карты')

@section('content')
	<h2 class="text-center">Информация о карте - {{ $card->code }}</h2>
	<div class="row">
        <div class="col-lg-6 col-lg-offset-3">
			{!! Form::model($card, ['url' => route('admin.cards.info.save', $card->id), 'method' => 'POST', 'files' => true]) !!}
				<div class="row">
					<div class="form-group col-md-6">
						{!! Form::label('info[name]', 'Имя') !!}
						{!! Form::text('info[name]', null, ['class' => 'form-control'.($errors->has('info[name]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[last_name]', 'Фамилия') !!}
						{!! Form::text('info[last_name]', null, ['class' => 'form-control'.($errors->has('info[last_name]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[patronymic]', 'Отчество') !!}
						{!! Form::text('info[patronymic]', null, ['class' => 'form-control'.($errors->has('info[last_name]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[gender]', 'Пол') !!}
						<select name="info[gender]" id="info[gender]" class="form-control">
							<option value="0">- Выберите пол -</option>
							@foreach (trans('vars.gender') as $key => $val)<option value="{{ $key }}"{{ isset($card->info) && $card->info->gender == $key ? ' selected' : '' }}>{{ $val }}</option>@endforeach
						</select>
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[phone]', 'Телефон (10 цифр)') !!}
						{!! Form::text('info[phone]', null, ['class' => 'form-control'.($errors->has('info[phone]') ? ' invalid' : '')]) !!}
						<small>Номер вводится без +7 или 8</small>
					</div>

					<div class="input-field col-md-6 input-date">
						{!! Form::label('info[birthday_at]', 'Дата рождения') !!}
						{!! Form::text('info[birthday_at]', null, ['class' => 'form-control'.($errors->has('info[birthday_at]') ? ' invalid' : '')]) !!}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6">
						{!! Form::label('info[issue_place]', 'Место выдачи карты') !!}
						{!! Form::text('info[issue_place]', null, ['class' => 'form-control'.($errors->has('info[issue_place]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[type]', 'Тип карты') !!}
						{!! Form::text('info[type]', null, ['class' => 'form-control'.($errors->has('info[type]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col-md-6 input-date">
						{!! Form::label('info[issued_at]', 'Дата выдачи карты') !!}
						{!! Form::text('info[issued_at]', null, ['class' => 'form-control'.($errors->has('info[issued_at]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[document_type]', 'Вид документа') !!}
						{!! Form::text('info[document_type]', null, ['class' => 'form-control'.($errors->has('info[document_type]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[document_number]', 'Номер документа') !!}
						{!! Form::text('info[document_number]', null, ['class' => 'form-control'.($errors->has('info[document_number]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col-md-6 input-date">
						{!! Form::label('info[document_at]', 'Дата выдачи документа') !!}
						{!! Form::text('info[document_at]', null, ['class' => 'form-control'.($errors->has('info[document_at]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[document_issued]', 'Кем выдан документ') !!}
						{!! Form::text('info[document_issued]', null, ['class' => 'form-control'.($errors->has('info[document_issued]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[car_brand]', 'Марка автомобиля') !!}
						{!! Form::text('info[car_brand]', null, ['class' => 'form-control'.($errors->has('info[car_brand]') ? ' invalid' : '')]) !!}
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('info[car_number]', 'Номера автомобиля') !!}
						{!! Form::text('info[car_number]', null, ['class' => 'form-control'.($errors->has('info[car_number]') ? ' invalid' : '')]) !!}
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
			{!! Form::close() !!}
		</div>
	</div>
@endsection

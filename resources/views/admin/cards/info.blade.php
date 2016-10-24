@extends('admin.layouts.full')

@section('title', 'Администрирование - Карты')

@section('content')
	<h4 class="center">Информация о карте - {{ $card->code }}</h4>
	<div class="row">
        <div class="col l6 offset-l3 m8 offset-m2">
			<div class="row">
				{!! Form::model($card, ['url' => route('admin.cards.info.save', $card->id), 'method' => 'POST', 'files' => true]) !!}
					<div class="input-field col s12">
						{!! Form::label('info[name]', 'Имя') !!}
						{!! Form::text('info[name]', null, ['class' => 'validate'.($errors->has('info[name]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[last_name]', 'Фамилия') !!}
						{!! Form::text('info[last_name]', null, ['class' => 'validate'.($errors->has('info[last_name]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[patronymic]', 'Отчество') !!}
						{!! Form::text('info[patronymic]', null, ['class' => 'validate'.($errors->has('info[last_name]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						<select name="info[gender]" id="info[gender]">
							<option value="0">- Выберите пол -</option>
							@foreach (trans('vars.gender') as $key => $val)<option value="{{ $key }}"{{ isset($card->info) && $card->info->gender == $key ? ' selected' : '' }}>{{ $val }}</option>@endforeach
						</select>
						{!! Form::label('info[gender]', 'Пол') !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[phone]', 'Телефон') !!}
						{!! Form::text('info[phone]', null, ['class' => 'validate'.($errors->has('info[phone]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12 input-date">
						{!! Form::label('info[birthday_at]', 'Дата рождения') !!}
						{!! Form::text('info[birthday_at]', null, ['class' => 'validate'.($errors->has('info[birthday_at]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[issue_place]', 'Место выдачи карты') !!}
						{!! Form::text('info[issue_place]', null, ['class' => 'validate'.($errors->has('info[issue_place]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[type]', 'Тип карты') !!}
						{!! Form::text('info[type]', null, ['class' => 'validate'.($errors->has('info[type]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12 input-date">
						{!! Form::label('info[issued_at]', 'Дата выдачи карты') !!}
						{!! Form::text('info[issued_at]', null, ['class' => 'validate'.($errors->has('info[issued_at]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[document_type]', 'Вид документа') !!}
						{!! Form::text('info[document_type]', null, ['class' => 'validate'.($errors->has('info[document_type]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[document_number]', 'Номер документа') !!}
						{!! Form::text('info[document_number]', null, ['class' => 'validate'.($errors->has('info[document_number]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12 input-date">
						{!! Form::label('info[document_at]', 'Дата выдачи документа') !!}
						{!! Form::text('info[document_at]', null, ['class' => 'validate'.($errors->has('info[document_at]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[document_issued]', 'Кем выдан документ') !!}
						{!! Form::text('info[document_issued]', null, ['class' => 'validate'.($errors->has('info[document_issued]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[car_brand]', 'Марка автомобиля') !!}
						{!! Form::text('info[car_brand]', null, ['class' => 'validate'.($errors->has('info[car_brand]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12">
						{!! Form::label('info[car_number]', 'Номера автомобиля') !!}
						{!! Form::text('info[car_number]', null, ['class' => 'validate'.($errors->has('info[car_number]') ? ' invalid' : '')]) !!}
					</div>

					<div class="input-field col s12 center">
						<button type="submit" class="btn-large red waves-effect waves-light"><i class="material-icons left">check_circle</i> Обновить информацию</button>
					</div>

					<div class="input-field col s12 center">
						<a href="{{ route('admin.cards.index') }}" class="btn grey waves-effect waves-light">Отмена</a>
					</div>
				{!! Form::close() !!}
            </div>
		</div>
	</div>
@endsection

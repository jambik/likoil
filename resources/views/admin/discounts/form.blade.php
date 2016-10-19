<div class="input-field col s12 input-datetime">
    {!! Form::label('date', 'Дата') !!}
    {!! Form::text('date', null, ['class' => 'validate'.($errors->has('date') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('volume', 'Объем') !!}
    {!! Form::text('volume', null, ['class' => 'validate'.($errors->has('volume') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('price', 'Цена') !!}
    {!! Form::text('price', null, ['class' => 'validate'.($errors->has('price') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('amount', 'Сумма') !!}
    {!! Form::text('amount', null, ['class' => 'validate'.($errors->has('amount') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('fuel_name', 'Топливо') !!}
    {!! Form::text('fuel_name', null, ['class' => 'validate'.($errors->has('fuel_name') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('azs', 'Код АЗС') !!}
    {!! Form::text('azs', null, ['class' => 'validate'.($errors->has('azs') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 center">
    <button type="submit" class="btn-large red waves-effect waves-light"><i class="material-icons left">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="input-field col s12 center">
    <a href="{{ route('admin.discounts.index') }}" class="btn grey waves-effect waves-light">Отмена</a>
</div>
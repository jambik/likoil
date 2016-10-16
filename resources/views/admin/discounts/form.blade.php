<div class="input-field col s12 input-datetime">
    {!! Form::label('Date', 'Дата') !!}
    {!! Form::text('Date', null, ['class' => 'validate'.($errors->has('Date') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('Volume', 'Объем') !!}
    {!! Form::text('Volume', null, ['class' => 'validate'.($errors->has('Volume') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('Price', 'Цена') !!}
    {!! Form::text('Price', null, ['class' => 'validate'.($errors->has('Price') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('Amount', 'Сумма') !!}
    {!! Form::text('Amount', null, ['class' => 'validate'.($errors->has('Amount') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('FuelName', 'Топливо') !!}
    {!! Form::text('FuelName', null, ['class' => 'validate'.($errors->has('FuelName') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('AZSCode', 'Код АЗС') !!}
    {!! Form::text('AZSCode', null, ['class' => 'validate'.($errors->has('AZSCode') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 center">
    <button type="submit" class="btn-large red waves-effect waves-light"><i class="material-icons left">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="input-field col s12 center">
    <a href="{{ route('admin.discounts.index') }}" class="btn grey waves-effect waves-light">Отмена</a>
</div>
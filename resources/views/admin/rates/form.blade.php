<div class="input-field col s12">
    {!! Form::label('name', 'Название') !!}
    {!! Form::text('name', null, ['class' => 'validate'.($errors->has('name') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('rate', 'Курс') !!}
    {!! Form::text('rate', null, ['class' => 'validate'.($errors->has('rate') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 input-datetime">
    {!! Form::label('start_at', 'Дата начала') !!}
    {!! Form::text('start_at', null, ['class' => 'validate'.($errors->has('start_at') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 center">
    <button type="submit" class="btn-large red waves-effect waves-light"><i class="material-icons left">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="input-field col s12 center">
    <a href="{{ route('admin.rates.index') }}" class="btn grey waves-effect waves-light">Отмена</a>
</div>
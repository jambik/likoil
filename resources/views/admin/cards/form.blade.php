<div class="input-field col s12">
    {!! Form::label('code', 'Номер карты') !!}
    {!! Form::text('code', null, ['class' => 'validate'.($errors->has('code') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 input-checkbox">
    {!! Form::checkbox('verified', 0, null, ['id' => 'verified', 'class' => $errors->has('verified') ? ' invalid' : '']) !!}
    {!! Form::label('verified', 'Подтвержден') !!}
</div>

<div class="input-field col s12 center">
    <button type="submit" class="btn-large red waves-effect waves-light"><i class="material-icons left">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="input-field col s12 center">
    <a href="{{ route('admin.cards.index') }}" class="btn grey waves-effect waves-light">Отмена</a>
</div>
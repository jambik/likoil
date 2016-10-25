<div class="form-group">
    {!! Form::label('code', 'Номер карты') !!}
    {!! Form::text('code', null, ['class' => 'form-control'.($errors->has('code') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 input-checkbox">
    {!! Form::checkbox('verified', 0, null, ['id' => 'verified', 'class' => $errors->has('verified') ? ' invalid' : '']) !!}
    {!! Form::label('verified', 'Подтвержден') !!}
</div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="form-group text-center">
    <a href="{{ route('admin.cards.index') }}" class="btn btn-default">Отмена</a>
</div>
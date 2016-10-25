<div class="form-group">
    {!! Form::label('name', 'Название') !!}
    {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' invalid' : '')]) !!}
</div>

<div class="form-group">
    {!! Form::label('rate', 'Курс') !!}
    {!! Form::text('rate', null, ['class' => 'form-control'.($errors->has('rate') ? ' invalid' : '')]) !!}
</div>

<div class="form-group input-datetime">
    {!! Form::label('start_at', 'Дата начала') !!}
    {!! Form::text('start_at', null, ['class' => 'form-control'.($errors->has('start_at') ? ' invalid' : '')]) !!}
</div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="form-group text-center">
    <a href="{{ route('admin.rates.index') }}" class="btn btn-default">Отмена</a>
</div>
<div class="form-group">
    {!! Form::label('Code', 'Номер карты') !!}
    {!! Form::text('Code', null, ['class' => 'form-control'.($errors->has('Code') ? ' invalid' : '')]) !!}
</div>

<div class="form-group">
    {!! Form::label('name', 'Имя') !!}
    {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' invalid' : '')]) !!}
</div>

<div class="form-group">
    <select name="gender" id="gender">
        <option value="0">- Выберите пол -</option>
        @foreach (trans('vars.gender') as $key => $val)<option value="{{ $key }}"{{ isset($item) && $item->gender == $key ? ' selected' : '' }}>{{ $val }}</option>@endforeach
    </select>
    {!! Form::label('gender', 'Пол') !!}
</div>

<div class="form-group">
    {!! Form::label('phone', 'Телефон') !!}
    {!! Form::text('phone', null, ['class' => 'form-control'.($errors->has('phone') ? ' invalid' : '')]) !!}
</div>

<div class="form-group input-datetime">
    {!! Form::label('birthday_at', 'День рождения') !!}
    {!! Form::text('birthday_at', null, ['class' => 'form-control'.($errors->has('birthday_at') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 input-checkbox">
    {!! Form::checkbox('verified', 0, null, ['id' => 'verified', 'class' => $errors->has('verified') ? ' invalid' : '']) !!}
    {!! Form::label('verified', 'Подтвержден') !!}
</div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="form-group text-center">
    <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-default">Отмена</a>
</div>
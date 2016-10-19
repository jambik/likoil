<div class="input-field col s12">
    {!! Form::label('Code', 'Номер карты') !!}
    {!! Form::text('Code', null, ['class' => 'validate'.($errors->has('Code') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    {!! Form::label('name', 'Имя') !!}
    {!! Form::text('name', null, ['class' => 'validate'.($errors->has('name') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12">
    <select name="gender" id="gender">
        <option value="0">- Выберите пол -</option>
        @foreach (trans('vars.gender') as $key => $val)<option value="{{ $key }}"{{ isset($item) && $item->gender == $key ? ' selected' : '' }}>{{ $val }}</option>@endforeach
    </select>
    {!! Form::label('gender', 'Пол') !!}
</div>

<div class="input-field col s12">
    {!! Form::label('phone', 'Телефон') !!}
    {!! Form::text('phone', null, ['class' => 'validate'.($errors->has('phone') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 input-datetime">
    {!! Form::label('birthday_at', 'День рождения') !!}
    {!! Form::text('birthday_at', null, ['class' => 'validate'.($errors->has('birthday_at') ? ' invalid' : '')]) !!}
</div>

<div class="input-field col s12 input-checkbox">
    {!! Form::checkbox('verified', 0, null, ['id' => 'verified', 'class' => $errors->has('verified') ? ' invalid' : '']) !!}
    {!! Form::label('verified', 'Подтвержден') !!}
</div>

<div class="input-field col s12 center">
    <button type="submit" class="btn-large red waves-effect waves-light"><i class="material-icons left">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="input-field col s12 center">
    <a href="{{ route('admin.withdrawals.index') }}" class="btn grey waves-effect waves-light">Отмена</a>
</div>
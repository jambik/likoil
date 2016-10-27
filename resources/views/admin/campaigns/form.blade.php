<div class="form-group">
    {!! Form::label('name', 'Название') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group input-date">
    {!! Form::label('start_at', 'Дата начала') !!}
    {!! Form::text('start_at', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group input-date">
    {!! Form::label('end_at', 'Дата окончания') !!}
    {!! Form::text('end_at', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group input-time">
    {!! Form::label('time_start', 'Время начала') !!}
    {!! Form::text('time_start', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group input-time">
    {!! Form::label('time_end', 'Время окончания') !!}
    {!! Form::text('time_end', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('rate', 'Курс') !!}
    {!! Form::text('rate', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group input-select2">
    {!! Form::label('azs_ids[]', 'АЗС') !!}
    {!! Form::select('azs_ids[]', $azs, null, ['multiple', 'class' => 'form-control']) !!}
</div>

<div class="form-group input-select2">
    {!! Form::label('fuels_ids[]', 'Вид топлива') !!}
    {!! Form::select('fuels_ids[]', $fuels, null, ['multiple', 'class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label>Дни</label>
    <div class="checkbox"><label><input type="checkbox" value="1" name="days[]">Понедельник</label></div>
    <div class="checkbox"><label><input type="checkbox" value="2" name="days[]">Вторник</label></div>
    <div class="checkbox"><label><input type="checkbox" value="3" name="days[]">Среда</label></div>
    <div class="checkbox"><label><input type="checkbox" value="4" name="days[]">Четверг</label></div>
    <div class="checkbox"><label><input type="checkbox" value="5" name="days[]">Пятница</label></div>
    <div class="checkbox"><label><input type="checkbox" value="6" name="days[]">Суббота</label></div>
    <div class="checkbox"><label><input type="checkbox" value="0" name="days[]">Воскресенье</label></div>
</div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="form-group text-center">
    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-default">Отмена</a>
</div>
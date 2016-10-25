<div class="form-group">
    {!! Form::label('name', 'Имя') !!}
    {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' invalid' : '')]) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control'.($errors->has('email') ? ' invalid' : '')]) !!}
</div>

<div class="form-group">
    {!! Form::label('password', 'Пароль') !!}
    {!! Form::text('password', null, ['class' => 'form-control'.($errors->has('password') ? ' invalid' : '')]) !!}
    @if (isset($item))<small>Если оставить пароль пустым, то он не изменится</small>@endif
</div>

@include('admin.partials._imageable')

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="form-group text-center">
    <a href="{{ route('admin.users.index') }}" class="btn btn-default">Отмена</a>
</div>
<div class="form-group">
    {!! Form::label('name', 'Название роли') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('display_name', 'Отображаемое имя') !!}
    {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Описание роли') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group input-select2">
    {!! Form::label('permissions_ids[]', 'Разрешения') !!}
    {!! Form::select('permissions_ids[]', $permissions, null, ['multiple', 'class' => 'form-control']) !!}
</div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="form-group text-center">
    <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Отмена</a>
</div>
<div class="form-group">
    {!! Form::label('card', 'Номер карты') !!}
    {!! Form::text('card', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('amount', 'Количество бонусов') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('comment', 'Комментарий') !!}
    {!! Form::text('comment', null, ['class' => 'form-control']) !!}
</div>

@if (isset($item))
    <div class="form-group">
        {!! Form::label('comment', 'Администратор') !!}
        <div>{{ $item->user->name }}</div>
    </div>
@endif

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="form-group text-center">
    <a href="{{ route('admin.bonus.index') }}" class="btn btn-default">Отмена</a>
</div>
<div class="form-group">
    <label class="control-label">Карта</label>
    <p class="form-control-static">{{ $card->code }}</p>
</div>

<div class="form-group">
    {!! Form::label('mileage', 'Пробег') !!}
    {!! Form::text('mileage', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group input-date">
    {!! Form::label('change_at', 'Дата замены') !!}
    {!! Form::text('change_at', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="text-center">
	<a href="{{ route('admin.oil_changes.index', ['card' => request()->get('card')]) }}" class="btn btn-default">Отмена</a>
</div>
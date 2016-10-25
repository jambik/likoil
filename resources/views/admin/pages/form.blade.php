<div class="form-group">
    {!! Form::label('name', 'Название') !!}
    {!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' invalid' : '')]) !!}
</div>

@if (isset($item))
    <div class="form-group">
        {!! Form::label('slug', 'Alias') !!}
        {!! Form::text('slug', null, ['class' => 'form-control'.($errors->has('slug') ? ' invalid' : '')]) !!}
        <small>alias для красивого отображения url</small>
    </div>
@endif

<div class="form-group input-html">
    {!! Form::label('text', 'Текст страницы') !!}
    {!! Form::textarea('text', null, ['class' => 'materialize-textarea validate'.($errors->has('text') ? ' invalid' : '')]) !!}
</div>

@include('admin.partials._headerable')

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="text-center">
	<a href="{{ route('admin.pages.index') }}" class="btn btn-default">Отмена</a>
</div>

@section('head_scripts')
    <script src="/library/ckeditor/ckeditor.js"></script>
@endsection
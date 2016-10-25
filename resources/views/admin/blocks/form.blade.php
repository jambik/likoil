<div class="form-group">
    {!! Form::label('alias', 'Alias') !!}
    {!! Form::text('alias', null, ['class' => 'form-control'.($errors->has('alias') ? ' invalid' : '')]) !!}
</div>

<div class="form-group">
    {!! Form::label('title', 'Название') !!}
    {!! Form::text('title', null, ['class' => 'form-control'.($errors->has('title') ? ' invalid' : '')]) !!}
</div>

<div class="form-group input-html">
    {!! Form::label('text', 'Текст') !!}
    {!! Form::textarea('text', null, ['class' => 'materialize-textarea validate'.($errors->has('text') ? ' invalid' : '')]) !!}
</div>

<div class="form-group text-center">
    <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> {{ $submitButtonText }}</button>
</div>

<div class="form-group text-center">
    <a href="{{ route('admin.blocks.index') }}" class="btn btn-default">Отмена</a>
</div>

@section('head_scripts')
    <script src="/library/ckeditor/ckeditor.js"></script>
@endsection
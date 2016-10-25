<div class="headerable">
    <div class="title">Настройки Хидера</div>

    <div class="form-group">
        {!! Form::label('header_title', 'Title (META)') !!}
        {!! Form::text('header[title]', isset($item) && $item->header->count() ? $item->header->first()->title : '', ['class' => 'form-control', 'id' => 'header_title']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('header_keywords', 'Keywords (META)') !!}
        {!! Form::text('header[keywords]', isset($item) && $item->header->count() ? $item->header->first()->keywords : '', ['class' => 'form-control', 'id' => 'header_keywords']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('header_description', 'Description (META)') !!}
        {!! Form::text('header[description]', isset($item) && $item->header->count() ? $item->header->first()->description : '', ['class' => 'form-control', 'id' => 'header_description']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('header_caption', 'Надпись на странице') !!}
        {!! Form::text('header[caption]', isset($item) && $item->header->count() ? $item->header->first()->caption : '', ['class' => 'form-control', 'id' => 'header_caption']) !!}
    </div>

    <div class="form-group">
        <label for="header[image]">Фото</label>
        <input type="file" class="filestyle" data-buttonText="Выберите файл" data-buttonBefore="true" name="header[image]" id="header[image]">
    </div>

    @if (isset($item) && $item->header->count() && $item->header->first()->image)
        <div class="col s12">
            <div><img src="/images/medium/{{ $item->header->first()->img_url . $item->header->first()->image }}" alt="" /></div>
            <div>&nbsp;</div>
            <button class="btn btn-danger" type="button" title="Удалить фото" onclick="deleteImage(this)" data-request-url="{{ route('headerable.delete') }}" data-model-class="{{ get_class($item) }}" data-model-id="{{ $item->id }}"><i class="material-icons">delete</i></button>
            <div class="preloader-wrapper small active preloader" style="display: none;"><div class="spinner-layer spinner-red-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>
        </div>
    @endif
</div>
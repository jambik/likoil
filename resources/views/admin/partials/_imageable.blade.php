<div class="form-group">
    <label for="image">Фото</label>
    <input type="file" class="filestyle" data-buttonText="Выберите файл" data-buttonBefore="true" name="image" id="image">
</div>

@if (isset($item) && $item->image)
    <div class="col s12">
        <div><img src="/images/medium/{{ $item->img_url.$item->image }}" alt="" /></div>
        <div>&nbsp;</div>
        <button class="btn btn-danger" type="button" title="Удалить фото" onclick="deleteImage(this)" data-request-url="{{ route('imageable.delete') }}" data-model-class="{{ get_class($item) }}" data-model-id="{{ $item->id }}"><i class="material-icons">delete</i></button>
        <div class="preloader-wrapper small active preloader" style="display: none;"><div class="spinner-layer spinner-red-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>
    </div>
@endif
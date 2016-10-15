<form action="{{ route('photoable.save') }}" method="POST" class="dropzone teal lighten-5" id="photos-dropzone">
    {{ csrf_field() }}
    <input type="hidden" name="model_class" value="{{ get_class($item) }}">
    <input type="hidden" name="model_id" value="{{ $item->id }}">
    <div class="dz-message">
        <h5>Перетащите файлы или нажмите сюда, чтобы закачать фото.</h5>
    </div>
</form>

@if ($item->photos->count())
    <p>&nbsp;</p>
    <table id="table_photos" class="striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Фото</th>
            <th>Описание</th>
            <th>Порядок</th>
            <th class="filter-false btn-collumn" data-sorter="false"></th>
        </tr>
        </thead>
        <tbody>
            @foreach($item->photos as $photo)
                <tr>
                    <td>{{ $photo->id }}</td>
                    <td><img src='/images/small/{{ $item->photo_url.$photo->image }}'></td>
                    <td>{{ $photo->name }}</td>
                    <td>{{ $photo->order }}</td>
                    <td><button onclick="confirmDelete(this, '{{ $photo->id }}', '{{ route('photoable.delete', $photo->id) }}')" class="btn btn-small waves-effect waves-light red darken-2"><i class="material-icons">delete</i></button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
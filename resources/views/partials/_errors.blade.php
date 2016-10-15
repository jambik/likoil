@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Возникла ошибка при записи</strong><br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
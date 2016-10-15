<ul class="nav nav-pills">
    <li role="presentation"{!! isset($personalActive) ? ' class="active"' : '' !!}><a href="{{ route('profile.personal') }}">Персональные данные</a></li>
    <li role="presentation"{!! isset($passwordActive) ? ' class="active"' : '' !!}><a href="{{ route('profile.password') }}">Смена пароля</a></li>
    <li role="presentation"{!! isset($avatarActive)   ? ' class="active"' : '' !!}><a href="{{ route('profile.avatar') }}">Аватар</a></li>
</ul>
<hr>
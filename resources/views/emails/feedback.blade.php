Пользователь: {{ $user->name }}
Номер карты: {{ $user->cardInfo->card->code }}
Телефон: +7{{ $user->cardInfo->phone }}
-------------------------------

Сообщение:

{{ $text }}
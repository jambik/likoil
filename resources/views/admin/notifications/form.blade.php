@extends('admin.layouts.full')

@section('title', 'Администрирование - Push')

@section('content')
    <h2 class="text-center">Отправка Push сообщения</h2>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            <div class="row">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
                        {{ session('status') }}
                    </div>
                @else
                    {!! Form::open(['url' => route('admin.notification.send'), 'method' => 'POST']) !!}
                        @if (isset($user))
                            <h3>Push сообщение пользователю - {{ $user->name }} ({{ $user->cardInfo->card->code }})</h3>
                            <p>&nbsp;</p>
                            {!! Form::hidden('user', $user->id) !!}
                        @else
                            {{--<div class="form-group">--}}
                                {{--{!! Form::label('device', 'Выберите устройство') !!}--}}
                                {{--{!! Form::select('device', ['' => 'Все устройства', 'android' => 'Android', 'ios' => 'iOS'], null, ['class' => 'form-control']) !!}--}}
                            {{--</div>--}}
                        @endif
                        <div class="form-group">
                            {!! Form::label('message', 'Push сообщение') !!}
                            {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-lg btn-primary"><i class="material-icons">check_circle</i> Отправить сообщение</button>
                        </div>
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>
@endsection

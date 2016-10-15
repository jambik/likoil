@extends('layouts.app')

@section('title', 'Личный кабинет - Аватар')

@section('content')
    @include('partials._personal_menu', ['avatarActive' => true])

    <form class="form-horizontal" role="form" action="{{ route('profile.avatar.save') }}" id="form_avatar" accept-charset="UTF-8" method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row">
            <div class="form-group col-lg-12">
                <!-- Current avatar -->
                <div class="avatar-current" id="avatar_current">
                    <div class="avatar-view">
                        <img class="img-thumbnail" src="{{ Auth::user()->avatar ?: asset('img/avatar.png') }}">
                        &nbsp;
                        <button type="button" class="btn btn-sm btn-default" onclick="$('#avatar_file').trigger('click')">Изменить аватарку <i class="fa fa-upload"></i></button>
                    </div>

                    <!-- Upload image and data -->
                    <div class="avatar-upload">
                        <input type="hidden" name="avatar_data" id="avatar_data">
                        <input type="file" accept="image/*" id="avatar_file" name="image" style="display: none;" onchange="avatarSelected()">
                    </div>
                </div>

                <!-- Crop and preview -->
                <div class="row" id="avatar_cropper" style="display: none;">
                    <div class="text-center lead">Новая аватарка</div>
                    <div class="col-sm-8">
                        <div class="avatar-wrapper" id="avatar_wrapper"></div>
                        <div>&nbsp;</div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Сохранить аватарку</button>
                            <button type="button" class="btn btn-danger" onclick="cancelAvatarUpload()">Отмена</button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="avatar-preview preview-lg"></div>
                        <div class="avatar-preview preview-md"></div>
                        <div class="avatar-preview preview-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
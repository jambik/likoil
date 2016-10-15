@extends('layouts.app')

@section('title', $page->header->count() ? ($page->header->first()->title ?: $page->name) : $page->name)
@section('keywords', $page->header->count() ? $page->header->first()->keywords : '')
@section('description', $page->header->count() ? $page->header->first()->description : '')

@section('content')
    @include('partials._status')
    @include('partials._errors')

    {!! $page->text !!}
@endsection

@section('header_scripts')
    <script src='https://www.google.com/recaptcha/api.js?hl=ru'></script>
@endsection
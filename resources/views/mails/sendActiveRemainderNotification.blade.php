@extends('mails.layout')

@section('title')
    {{ $details['title'] ?? "" }}
@endsection

@section('logo')
    {{ $logo ?? "" }}
@endsection

@section('body')
    USER: {{ $user->name }}
    SERRVICE REQUEST: {{$request->id}}
    {!! $body ?? "" !!}
@endsection

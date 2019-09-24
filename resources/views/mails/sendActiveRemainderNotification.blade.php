@extends('mails.layout')

@section('title')
    {{ $details['title'] ?? "" }}
@endsection

@section('logo')
    {{ $logo ?? "" }}
@endsection

@section('body')
    USER: {{ $user->name }}
    SERRVICE REQUEST: {{$serviceRequest->id}}
    {!! $body ?? "" !!}
@endsection

@extends('mails.layout')

@section('title')
    {{ $subject ?? "" }}
@endsection

@section('body')
    {!! $body ?? "" !!}
    <p><a href="{{$activationUrl}}">Activate Account</a></p>
	<p>Code {{$activationCode}}</p>
@endsection

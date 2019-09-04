@extends('pdfs.layout')

@section('title')
    {{ __("tenant.tenant_credentials") }}
@endsection

@section('body')
    <p>@lang("tenant.url", [], $language): <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    <p>@lang("tenant.username", [], $language): {{ $tenant->user->email }}</p>
    <p>@lang("tenant.url", [], $language): {{ $url }}</p>
    <p>@lang("tenant.code", [], $language): {{ $code }}</p>
@endsection

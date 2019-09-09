@extends('pdfs.layout')

@section('title')
    {{ __("models.tenant.credentials_pdf.tenant_credentials") }}
@endsection

@section('body')
    <p>@lang("models.tenant.credentials_pdf.url", [], $language): <a href="{{ url('/') }}">{{ url('/') }}</a></p>
    <p>@lang("models.tenant.credentials_pdf.username", [], $language): {{ $tenant->user->email }}</p>
    <p>@lang("models.tenant.credentials_pdf.url", [], $language): {{ $url }}</p>
    <p>@lang("models.tenant.credentials_pdf.code", [], $language): {{ $code }}</p>
@endsection

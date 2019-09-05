@extends('pdfs.layout')

@section('title')
    {{ __("tenant.tenant_credentials") }}
@endsection

@section('body')
<table>
  <tr>
    <td>
      <p id="tenant-header">
        @lang("tenant.dear", [], $language)
        <br>
        <b>{{ $tenant->first_name . ' ' . $tenant->last_name }}</b>
      </p>

      @if ($tenant->address)
       <p>{{ $tenant->address->street_nr }}, {{ $tenant->address->street }} {{ $tenant->address->city }}</p>
      @endif
    </td>
    <td id="real-estate">
      <img class="logo" src="{{ asset('images/logo3.png') }}"/>
      <p>{{ $re->name }}</p>
      <p>{{ $re->address->street_nr }}, {{ $re->address->street }}<br />
        {{ $re->address->city }}, {{ $re->address->state->name }}</p>
      <p>
        @lang('tenant.telephone', [], $language): {{ $re->phone }}
        <br>
        @lang('tenant.email', [], $language): {{ $re->email }}</p>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <br>
      <br>
      <br>
      @lang('tenant.born', [], $language), {{$tenant->birth_date ? $tenant->birth_date->format('d.m.Y') : ''}}
      <br>
      <br>
      <br>
      <b>@lang('tenant.welcome', [], $language) {{ $re->name }}</b>
      <br>
      <br>
      @lang('tenant.dear_sir', [], $language) {{ $tenant->last_name }}
      <br>
      <br>
      @lang('tenant.content_1', [], $language)
      <br>
      <br>
      <p class="offer"><b>@lang('tenant.offer', [], $language)</b></p>
      <ul class="offer">
        <li>@lang('tenant.offer_1', [], $language)</li>
        <li>@lang('tenant.offer_2', [], $language)</li>
        <li>@lang('tenant.offer_3', [], $language)</li>
        <li>@lang('tenant.offer_4', [], $language)</li>
        <li>@lang('tenant.offer_5', [], $language)</li>
      </ul>

      <b>@lang('tenant.register', [], $language)</b>
      <br>
      @lang('tenant.content_2', [], $language)
      <br>
      <br>
    </td>
  </tr>
  <tr>
    <td>@lang("tenant.link_application", [], $language)</td>
    <td>{{ url('/') }}</td>
  </tr>
  <tr>
    <td>{{ __("tenant.code") }}</td>
    <td>{{ $code }}</td>
  </tr>
  <tr>
    <td>{{ __("tenant.your_email") }}</td>
    <td>{{ $tenant->user->email }}</td>
  </tr>
  <tr>
    <td colspan="4">
      <br>
      @lang('tenant.content_3', [], $language)
      <br>
      <br>
      @lang('tenant.content_4', [], $language)
      <br>
      <br>
      <br>
      @lang('tenant.your_sincerely', [], $language)
      <br>
      @lang('tenant.your_administration', [], $language)
    </td>
  </tr>
</table>
@endsection

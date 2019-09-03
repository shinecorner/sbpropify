@extends('pdfs.layout')

@section('title')
    {{ __("tenant.tenant_credentials") }}
@endsection

@section('body')
<table>
  <tr>
    <td class="tenant">
      <p>
        @lang("tenant.dear")
        <br>
        <b>{{ $tenant->first_name . ' ' . $tenant->last_name }}</b>
      </p>

      @if ($tenant->address)
       <p>{{ $tenant->address->street_nr }}, {{ $tenant->address->street }} {{ $tenant->address->city }}</p>
      @endif
    </td>
    <td class="contact">
      <img src="{{ asset('images/logo3.png') }}" />
      <p>{{ $re->name }}</p>
      <p>{{ $re->address->street_nr }}, {{ $re->address->street }}<br />
        {{ $re->address->city }}, {{ $re->address->state->name }}</p>
      <p>
        @lang('tenant.telephone'): {{ $re->phone }}
        <br>
        @lang('tenant.email'): {{ $re->email }}</p>
    </td>
  </tr>
</table>

<table>
  <tr>
    <td colspan="4">
      @lang('tenant.born'), {{$tenant->birth_date ? $tenant->birth_date->format('d.m.Y') : ''}}
      <br>
      <br>
      <br>
      <b>@lang('tenant.welcome') {{ $re->name }}</b>
      <br>
      <br>
      @lang('tenant.dear_sir') {{ $tenant->last_name }}
      <br>
      <br>
      @lang('tenant.content_1')
      <br>
      <br>
      <b>@lang('tenant.offer')</b>
      <ul>
        <li>@lang('tenant.offer_1')</li>
        <li>@lang('tenant.offer_2')</li>
        <li>@lang('tenant.offer_3')</li>
        <li>@lang('tenant.offer_4')</li>
        <li>@lang('tenant.offer_5')</li>
      </ul>

      <b>@lang('tenant.register')</b>
      <br>
      <br>
      @lang('tenant.content_2')
      <br>
      <br>
    </td>
  </tr>
  <tr>
    <td colspan="1">{{ __("tenant.link_application") }}</td>
    <td colspan="3">{{ url('/') }}</td>
  </tr>
  <tr>
    <td colspan="1">{{ __("tenant.code") }}</td>
    <td colspan="3">{{ $code }}</td>
  </tr>
  <tr>
    <td colspan="1">{{ __("tenant.your_email") }}</td>
    <td colspan="3">{{ $tenant->user->email }}</td>
  </tr>
  <tr>
    <td colspan="4">
      <br>
      @lang('tenant.content_3')
      <br>
      <br>
      @lang('tenant.content_4')
      <br>
      <br>
      <br>
      @lang('tenant.your_sincerely')
      <br>
      @lang('tenant.your_administration')
    </td>
  </tr>
</table>
@endsection

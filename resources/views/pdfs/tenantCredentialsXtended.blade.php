@extends('pdfs.layout')

@section('title')
    {{ __("models.tenant.credentials_pdf.tenant_credentials") }}
@endsection

@section('body')
<table>
  <tr>
    <td>
      <p id="tenant-header">
        @lang("general.salutation_option." . $tenant->title, [], $language)
        <br>
        <b>{{ $tenant->first_name . ' ' . $tenant->last_name }}</b>
      </p>

      @if ($tenant->address)
       <p>
         {{ $tenant->address->street }} {{ $tenant->address->street_nr }}
         <br>
         {{ $tenant->address->zip }} {{ $tenant->address->city }}
       </p>
      @endif
    </td>
    <td id="real-estate">
      <img class="logo" src="{{ $re->logo ? asset($re->logo) : asset('images/logo3.png') }}"/>
      <p>{{ $re->name }}</p>
      <p>
        {{ $re->address->street }}<br />
        {{ $re->address->zip }} {{ $re->address->city }}
      </p>
      <p>
        @lang('models.tenant.credentials_pdf.telephone', [], $language): {{ $re->phone }}
        <br>
        @lang('models.tenant.credentials_pdf.email', [], $language): {{ $re->email }}</p>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <br>
      <br>
      <br>
      {{ $re->address->city }}, {{now()->format('d.m.Y')}}
      <br>
      <br>
      <br>
      <b>@lang('models.tenant.credentials_pdf.welcome', [], $language) {{ $re->name }}</b>
      <br>
      <br>
      @if(\App\Models\Tenant::TitleCompany == $tenant->title)
        @lang('general.pdf_salutation.' . $tenant->title, [], $language)
      @else
        @lang('general.pdf_salutation.' . $tenant->title, ['name' => $tenant->last_name], $language)
      @endif
      <br>
      <br>
      @lang('models.tenant.credentials_pdf.content_1', [], $language)
      <br>
      <br>
      <p class="offer"><b>@lang('models.tenant.credentials_pdf.offer', [], $language)</b></p>
      <ul class="offer">
        {!! __('models.tenant.credentials_pdf.offers', [], $language) !!}
      </ul>

      <b>@lang('models.tenant.credentials_pdf.register', [], $language)</b>
      <br>
      @lang('models.tenant.credentials_pdf.content_2', [], $language)
      <br>
      <br>
    </td>
  </tr>
  <tr>
    <td>@lang("models.tenant.credentials_pdf.link_application", [], $language)</td>
    <td>{{ url('/activate') }}</td>
  </tr>
  <tr>
    <td>{{ __("models.tenant.credentials_pdf.code") }}</td>
    <td>{{ $code }}</td>
  </tr>
  <tr>
    <td>{{ __("models.tenant.credentials_pdf.your_email") }}</td>
    <td>{{ $tenant->user->email }}</td>
  </tr>
  <tr>
    <td colspan="4">
      <br>
      @lang('models.tenant.credentials_pdf.content_3', [], $language)
      <br>
      <br>
      @lang('models.tenant.credentials_pdf.content_4', [], $language)
      <br>
      <br>
      <br>
      @lang('models.tenant.credentials_pdf.your_sincerely', [], $language)
      <br>
      @lang('models.tenant.credentials_pdf.your_administration', [], $language)
    </td>
  </tr>
</table>
@endsection

@extends('pdfs.servicerequest.layout')
@section('title')
    {{ __("models.request.download_pdf.service_request") }}
@endsection

@section('body')
    <table class="data_table" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td colspan="2" width="100%" class="no_border">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td class="table_header" valign="middle">

                                    <p>{{ $request->service_request_format }}</p>
                                    <p>{{ ($category->parentCategory != null) ? $category->parentCategory->{'name'.($language != 'en' ? '_'.$language : '') } . ' > ' : ''  }}

                                    {{ $category->{'name'.($language != 'en' ? '_'.$language : '') } }}
                                    </p>
                                    <p> @lang('models.request.status.'.\App\Models\ServiceRequest::Status[$request->status],[],$language) ({{ now()->format('d.m.Y H:i a') }})</p>

                                    <p> {{ @$tenant->address->street }},
                                        {{ @$tenant->building_id }} ,
                                        {{ @$tenant->address->zip }},
                                        {{ @$tenant->address->city }}

                                    </p>
                                </td>

                                <td style="text-align:right;vertical-align:top;" class="table_header">
                                    <img class="logo" src="http://dev.propify.ch/storage/fortimo-ag-1.png"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" width="100%" class="no_border">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="100%" class="no_border">
                                    <table class="inner_table" width="100%">
                                        <tbody>

                                        <tr>
                                            @if($category->acquisition == 1 || ($category->parentCategory != null && $category->parentCategory->acquisition))

                                            <td class="no_border">
                                                <strong>
                                                    @lang('models.request.category_options.acquisition',[],$language):
                                                </strong>
                                            </td>

                                            <td class="no_border">
                                                @lang('models.request.category_options.acquisitions.'.$request->capture_phase,[],$language)
                                            </td>

                                            @endif
                                                @if($category->has_qualifications == 1 || ($category->parentCategory != null && $category->parentCategory->has_qualifications))
                                                    <td class="no_border">
                                                        <strong>
                                                            @lang('models.request.qualification.label',[],$language):
                                                        </strong>
                                                    </td>
                                                    <td class="no_border">
                                                        @lang('models.request.qualification.'.\App\Models\ServiceRequest::Qualification[$request->qualification],[],$language)
                                                    </td>
                                               @endif
                                        </tr>


                                        <tr>
                                            <td class="border_btm"><strong>@lang('models.request.category_options.component',[],$language):</strong></td>
                                            <td class="border_btm">{{ $request->component }}</td>



                                            @if($category->location == 1 || ($category->parentCategory != null && $category->parentCategory->location))
                                                <td class="border_btm"><strong> @lang('models.request.category_options.range',[],$language):</strong></td>
                                                <td class="border_btm"> {{ array_values(__('models.request.category_options.building_locations',[],$language))[$request->location] }}</td>
                                            @endif

                                            @if($category->room == 1 || ($category->parentCategory != null && $category->parentCategory->room))
                                             <td class="border_btm"><strong>@lang('models.request.category_options.room',[],$language):</strong></td>
                                                <td class="border_btm">
                                                    @lang('models.request.category_options.apartment_rooms.'.$request->room,[],$language)
                                                </td>
                                            @endif

                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>

            </tr>
            <tr>
                <td class="no_border" width="100%">
                    <h4 style="margin-bottom:0">@lang('general.title',[],$language):</h4>
                    <p style="display:block;width:100%;margin-top:5px;">{{ $request->title }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="no_border" width="100%">
                    <h4 style="margin-bottom:0">@lang('general.description',[],$language):</h4>
                    <p style="display:block;width:100%;margin-top:0;">{!!  $request->description !!} </p>
                </td>
            </tr>
            <tr>
                <td class="no_border">
                    <h4 style="margin-bottom:0">@lang('models.request.download_pdf.contact_details',[],$language):</h4>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="no_border" width="100%">
                    <p style="display:block;width:100%;margin-top:0;">@lang('models.request.download_pdf.contact_text',[],$language)</p>
                </td>
            </tr>
        <tr>
            <td colspan="2" width="100%" class="no_border">
                <table width="100%">
                <tbody>
                    <tr>
                        <td colspan="5" class="no_border" width="100%">
                            <table class="info_table" width="100%">
                                <tbody>
                                <tr>
                                    <td class="no_border"><strong>@lang('general.name',[],$language):</strong></td>
                                    <td class="no_border" width="200px">{{ $tenant->user->name }}</td>

                                    <td class="no_border" style="padding-left:38px;"><strong>@lang('general.email',[],$language):</strong></td>
                                    <td  class="no_border" style="padding-left:38px;">{{ $tenant->user->email }}</td>
                                    <td class="no_border"></td>

                                </tr>

                               {{-- <tr>
                                    <td><strong>@lang('models.request.visibility.label',[],$language)</strong></td>
                                    <td>@lang('models.request.visibility.'.\App\Models\ServiceRequest::Visibility[$request->visibility],[],$language)</td>

                                    <td><strong>@lang('models.request.priority.label',[],$language)</strong></td>
                                    <td>@lang('models.request.priority.'.\App\Models\ServiceRequest::Priority[$request->priority],[],$language)</td>

                                </tr>--}}

                                <tr>
                                    @if($tenant->mobile != null)
                                        <td class="border_btm"><strong>@lang('models.tenant.mobile_phone',[],$language):</strong></td>
                                        <td class="border_btm">{{ $tenant->mobile }}</td>
                                    @else
                                        <td class="border_btm"><strong>@lang('models.tenant.private_phone',[],$language):</strong></td>
                                        <td class="border_btm">{{ $tenant->private_phone }}</td>
                                    @endif

                                        <td class="border_btm"></td>
                                        <td class="border_btm"></td>
                                        <td class="border_btm"></td>


                                </tr>

                                <tr>
                                    <td colspan="4" class="no_border" width="100%" style="margin-top:50px;">
                                        <span style="margin-top:20px;border-bottom:2px dotted #888;padding-bottom:30px;display:inline-block;width:48%;float:left;">
                                            @lang('models.request.download_pdf.customer_signature',[],$language)
                                        </span>
                                        <span style="margin-top:20px;border-bottom:2px dotted #888;padding-bottom:30px;display:inline-block;width:48%;float:right;">
                                            @lang('models.request.download_pdf.entrepreneur_signature',[],$language)
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        </tbody>
    </table>

@endsection
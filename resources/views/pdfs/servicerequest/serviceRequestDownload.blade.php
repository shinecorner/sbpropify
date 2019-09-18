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
                                <td class="table_header">
                                    @lang('models.request.category',[],$language) >

                                    {{ ($category->parentCategory != null) ? $category->parentCategory->{'name'.($language != 'en' ? '_'.$language : '') } . ' > ' : ''  }}

                                    {{ $category->{'name'.($language != 'en' ? '_'.$language : '') } }}</td>

                                <td style="text-align:right;" class="table_header">
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

                                            <td>
                                                <strong>
                                                    @lang('models.request.category_options.acquisition',[],$language)
                                                </strong>
                                            </td>

                                            <td>
                                                @lang('models.request.category_options.acquisitions.'.$request->capture_phase,[],$language)
                                            </td>

                                            @endif
                                                @if($category->has_qualifications == 1 || ($category->parentCategory != null && $category->parentCategory->has_qualifications))
                                                    <td>
                                                        <strong>
                                                            @lang('models.request.qualification.label',[],$language)
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        @lang('models.request.qualification.'.\App\Models\ServiceRequest::Qualification[$request->qualification],[],$language)
                                                    </td>
                                               @endif
                                        </tr>


                                        <tr>
                                            <td><strong>@lang('models.request.category_options.component',[],$language)</strong></td>
                                            <td>{{ $request->component }}</td>



                                            @if($category->location == 1 || ($category->parentCategory != null && $category->parentCategory->location))
                                                <td><strong> @lang('models.request.category_options.range',[],$language)</strong></td>
                                                <td> {{ array_values(__('models.request.category_options.building_locations',[],$language))[$request->location] }}</td>
                                            @endif

                                            @if($category->room == 1 || ($category->parentCategory != null && $category->parentCategory->room))
                                             <td><strong>@lang('models.request.category_options.room',[],$language)</strong></td>
                                                <td>
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
                <td class="no_border" width="100%" style="padding-left:8px;">
                    <h4>@lang('models.request.download_pdf.contact_details',[],$language)</h4>
                    <p style="display:block;width:100%;">@lang('models.request.download_pdf.contact_text',[],$language)</p>
                </td>
            </tr>
        <tr>
            <td colspan="2" width="100%" class="no_border">
                <table width="100%">
                <tbody>
                    <tr>
                        <td colspan="4" class="no_border" width="100%">
                            <table class="info_table" width="100%">
                                <tbody>
                                <tr>
                                    <td><strong>@lang('general.name',[],$language)</strong></td>
                                    <td>{{ $tenant->name }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>@lang('general.email',[],$language)</strong></td>
                                    <td>{{ $tenant->email }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>@lang('models.request.visibility.label',[],$language)</strong></td>
                                    <td>@lang('models.request.visibility.'.\App\Models\ServiceRequest::Visibility[$request->visibility],[],$language)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>@lang('models.request.priority.label',[],$language)</strong></td>
                                    <td>@lang('models.request.priority.'.\App\Models\ServiceRequest::Priority[$request->priority],[],$language)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="no_border" width="100%">
                                        <table width="100%">
                                            <tbody>
                                            <tr>
                                                <td class="no_border" style="border-bottom:2px dotted #888;padding-bottom:50px;">
                                                    @lang('models.request.download_pdf.customer_signature',[],$language)
                                                </td>
                                                <td class="no_border"></td>
                                                <td class="no_border"></td>
                                                <td class="no_border" style="border-bottom:2px dotted #888;padding-bottom:50px;">
                                                    @lang('models.request.download_pdf.entrepreneur_signature',[],$language)
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
            </td>
        </tr>
        </tbody>
    </table>

@endsection
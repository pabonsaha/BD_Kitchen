@extends('layouts.master')

@section('title', $title ?? _trans('setting.General').' '._trans('setting.Settings'))

@section('content')

    {{-- @include('assets.layouts.breadcrumb' , ['title' => @$title], ['breadcrumb'=>'dashboard']) --}}

    <div class="col-12 mb-4">
        {!! breadcrumb( _trans('setting.General').' '._trans('setting.Settings') ,['#'=>_trans('setting.System').' '._trans('setting.Settings') ,'setting'=>_trans('setting.General').' '._trans('setting.Settings')]) !!}
        <div class="bs-stepper vertical wizard-vertical-icons-example mt-2">
            <div class="bs-stepper-header">
                <div class="step" data-target="#system-info-setting">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class="ti ti-file-description"></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{_trans('setting.System Info')}}</span>
                            <span class="bs-stepper-subtitle">{{_trans('setting.Setup').' '._trans('setting.System Info')}}</span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <!-- System Info -->
                <div id="system-info-setting" class="content">
                    <form method="POST" id="system-info-setting-form">
                        @csrf
                        <div class="content-header mb-3">
                            <h6 class="mb-0">{{_trans('setting.System').' '._trans('common.Info')}}</h6>
                            <small>{{_trans('common.Enter').' '._trans('common.Your').' '._trans('setting.System').' '._trans('common.Info')}}</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="siteName">{{_trans('common.Site').' '._trans('common.Name')}}</label>
                                <input type="text" id="siteName" name="siteName" class="form-control"
                                    placeholder="House Brand" value="{{ $setting->site_name }}" />

                                <span class="text-danger siteNameError error"></span>

                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="siteTitle">{{_trans('common.Site').' '._trans('common.Title')}}</label>
                                <input type="text" id="siteTitle" name="siteTitle" class="form-control"
                                    value="{{ $setting->site_title }}"
                                    placeholder="A social media platform where users can find designer." aria-label="" />
                                <span class="text-danger siteTitleError error"></span>

                            </div>

                            <div class="col-sm-6">
                                <label class="form-label" for="timeZone">{{_trans('setting.Time Zone')}}</label>
                                <select class="select2" id="timeZone" name="timeZone">
                                    @foreach ($time_zones as $time_zone)
                                        <option value="{{ $time_zone->id }}"
                                            @if ($setting->time_zone_id == $time_zone->id) selected @endif>{{ $time_zone->time_zone }}
                                        </option>
                                    @endforeach
                                </select>

                                <span class="text-danger timeZoneError error"></span>

                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="currence">{{_trans('common.Currency')}}</label>
                                <select class="select2" id="currence" name="currence">
                                    @foreach ($currences as $currence)
                                        <option value="{{ $currence->id }}"
                                            @if ($setting->currency_id == $currence->id) selected @endif>{{ $currence->symbol }}
                                            {{ $currence->name }}</option>
                                    @endforeach
                                </select>

                                <span class="text-danger currenceError error"></span>

                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="dateFormat">{{_trans('setting.Date Format')}}</label>
                                <select class="select2" id="dateFormat" name="dateFormat">
                                    @foreach ($date_formats as $date_format)
                                        <option value="{{ $date_format->id }}"
                                            @if ($setting->date_format_id == $date_format->id) selected @endif>{{ $date_format->format }}
                                        </option>
                                    @endforeach
                                </select>

                                <span class="text-danger dateFormatError error"></span>

                            </div>

                            <div class="col-sm-12">
                                <label class="form-label" for="copyRightText">{{_trans('setting.Copy Right Text')}}</label>
                                <div class="input-group input-group-merge">
                                    <textarea id="copy_right" name="copy_right" class="form-control" placeholder="2024 copyright reserved"
                                        rows="3">{{ $setting->copyright_text }}</textarea>
                                </div>

                                <span class="text-danger copy_rightError error"></span>

                            </div>
                            @if(hasPermission('general_settings_update'))
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">{{_trans('common.Submit')}}</span>
                                        <i class="ti ti-arrow-up"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection


@push('scripts')
    {{-- form submit ajax --}}

    <script>
        $('#system-info-setting-form').on('submit', function(e) {
            e.preventDefault();

            $('.error').text('');
            $.ajax({
                url: '{{ route('setting.general-setting.system_info.store') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    // element = $('input[name="element_name"]');
                    siteName: $('#siteName').val(),
                    siteTitle: $('#siteTitle').val(),
                    // address: $('#address').val(),
                    // phone: $('#phone').val(),
                    // email: $('#email').val(),
                    timeZone: $('#timeZone').val(),
                    currence: $('#currence').val(),
                    dateFormat: $('#dateFormat').val(),
                    // map_location: $('#map_location').val(),
                    copy_right: $('#copy_right').val(),
                },
                success: function(response) {
                    if (response.status == 403) {
                        console.log(response.errors.phone[0]);

                        $('.siteNameError').text(response.errors?.siteName ? response.errors?.siteName[
                            0] : '');
                        $('.siteTitleError').text(response.errors?.siteTitle ? response.errors
                            ?.siteTitle[0] : '');
                        // $('.addressError').text(response.errors?.address ? response.errors?.address[0] :
                        //     '');
                        // $('.phoneError').text(response.errors?.phone ? response.errors?.phone[0] : '');
                        // $('.emailError').text(response.errors?.email ? response.errors?.email[0] : '');
                        $('.timeZoneError').text(response.errors?.timeZone ? response.errors?.timeZone[
                            0] : '');
                        $('.currenceError').text(response.errors?.currence ? response.errors?.currence[
                            0] : '');
                        $('.dateFormatError').text(response.errors?.dateFormatence ? response.errors
                            ?.dateFormatence[0] : '');
                        // $('.map_locationError').text(response.errors?.map_location ? response.errors
                        //     ?.map_location[0] : '');
                        $('.copy_rightError').text(response.errors?.copy_right ? response.errors
                            ?.copy_right[0] : '');
                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.message);
                }
            });
        });


    </script>




@endpush


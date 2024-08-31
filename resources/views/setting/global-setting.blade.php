@extends('layouts.master')

@section('title', $title ?? _trans('setting.Global') . ' ' . _trans('setting.Settings'))

@section('content')

    <div class="col-12 mb-4">
        {!! breadcrumb('Global Settings', [
            '#' => _trans('setting.System') . ' ' . _trans('setting.Settings'),
            'setting' => _trans('setting.Global') . ' ' . _trans('setting.Settings'),
        ]) !!}

        <!-- Setting Radios Row -->
        <div class="row">
            @foreach ($settings as $setting)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <h5 class="card-header">{{ $setting->description }}</h5>
                        <div class="card-body">
                            <div class="individual-section{{ $setting->id }}">
                                <div class="row">
                                    @foreach (json_decode($setting->options, true) as $optionValue => $optionLabel)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check custom-option custom-option-basic">
                                                <label class="form-check-label custom-option-content"
                                                    for="customRadioTemp{{ $optionValue }}_{{ $setting->id }}">
                                                    <input name="customRadioTemp_{{ $setting->id }}"
                                                        class="form-check-input"
                                                        onchange="changeStatus('{{ $setting->id }}')" type="radio"
                                                        value="{{ $optionValue }}"
                                                        id="customRadioTemp{{ $optionValue }}_{{ $setting->id }}"
                                                        data-setting-id="{{ $setting->id }}"
                                                        {{ $setting->value == $optionValue ? 'checked' : '' }} />
                                                    <span class="custom-option-header">
                                                        <span class="h6 mb-0">{{ textCapitalize($optionLabel) }}</span>
                                                    </span>
                                                    <span class="custom-option-body">
                                                        <small>Note: {{ textCapitalize($setting->key) }}
                                                            {{ textCapitalize($optionLabel) }}</small>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- /Setting Radios Row -->
    </div>

@endsection

@push('scripts')
    <script src='{{ asset('backend/js/backend_custom.js') }}'></script>
@endpush

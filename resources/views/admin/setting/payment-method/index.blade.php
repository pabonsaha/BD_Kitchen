@extends('layouts.master')

@section('title', $title ?? _trans('setting.Payment').' '._trans('setting.Method'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('setting.Payment').' '._trans('setting.Method'), ['#' => _trans('setting.Payment').' '._trans('setting.Settings'), 'setting/payment-method' => _trans('setting.Payment').' '._trans('setting.Method')]) !!}
        <div class="app-ecommerce-category">

            <div class="row">

                @foreach ($methods as $method)
                    @if ($method->id == 1 && globalSetting('stripe')->value == 1)
                        <div class="col-md-6">
                            <form action="" id="stripe_form">

                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>{{_trans('order.Stripe')}}</h4>
                                        <img src="{{ asset($method->logo) }}" alt=""
                                            width="100px">
                                        <label class="switch switch-square switch-success">
                                            <input type="checkbox" id="changeStripeStatus" class="switch-input "
                                                {{ optional(Auth()->user()->paymentMethodStatus->where('payment_method_id', $method->id)->first())->active_status == 1 ? 'checked' : '' }} />
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="ti ti-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="ti ti-x"></i>
                                                </span>
                                            </span>
                                            <span class="switch-label">{{_trans('common.Enable')}}</span>
                                        </label>

                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="public_key">{{_trans('order.Public Key')}}</label>
                                            <input type="text" class="form-control" id="public_key" placeholder="key"
                                                value="{{ optional(Auth()->user()->gatewayCredentials->where('payment_method_id', $method->id)->where('key', 'public_key')->first())->value }}"
                                                name="public_key" aria-label="Public Key" />
                                            <span class="text-danger public_keyError error"></span>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label" for="secret_key">{{_trans('order.Secret Key')}}</label>
                                            <input type="text" class="form-control" id="secret_key"
                                                placeholder="Secret Key"
                                                value="{{ optional(Auth()->user()->gatewayCredentials->where('payment_method_id', $method->id)->where('key', 'secret_key')->first())->value }}"
                                                name="secret_key" aria-label="Secret Key" />
                                            <span class="text-danger secret_keyError error"></span>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <button class="btn btn-success" id="paypal_submit">{{_trans('common.Save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    @if ($method->id == 2 && @globalSetting('paypal')->value == 1)
                        <div class="col-md-6">
                            <form action="" id="paypal_form">

                                <div class="card mb-4">

                                    <div class="card-header d-flex justify-content-between">

                                        <h4>{{_trans('order.Paypal')}}</h4>
                                        <img src="{{ asset('assets/img/payment-method/paypal.png') }}" alt=""
                                            width="100px" height="30px">
                                        <label class="switch switch-square switch-success">
                                            <input type="checkbox" class="switch-input" id="changePaypalStatus"
                                            {{ optional(Auth()->user()->paymentMethodStatus->where('payment_method_id', $method->id)->first())->active_status == 1 ? 'checked' : '' }} />

                                            <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                    <i class="ti ti-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="ti ti-x"></i>
                                                </span>
                                            </span>
                                            <span class="switch-label">{{_trans('common.Enable')}}</span>
                                        </label>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label" for="client_id">{{_trans('order.Client ID')}}</label>
                                                    <input type="text" class="form-control" id="client_id"
                                                        value="{{ optional(Auth()->user()->gatewayCredentials->where('payment_method_id', $method->id)->where('key', 'client_id')->first())->value }}"
                                                        placeholder="Client ID" name="client_id" aria-label="Client ID" />
                                                    <span class="text-danger client_idError error"></span>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label" for="client_secret">{{_trans('order.Client Secret')}}</label>
                                                    <input type="text" class="form-control" id="client_secret"
                                                        value="{{ optional(Auth()->user()->gatewayCredentials->where('payment_method_id', $method->id)->where('key', 'client_secret')->first())->value }}"
                                                        placeholder="{{_trans('order.Client Secret')}}" name="client_secret"
                                                        aria-label="{{_trans('order.Client Secret')}}" />
                                                    <span class="text-danger client_secretError error"></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="demo-vertical-spacing">
                                                    <label class="switch">
                                                        <input type="checkbox" id="paypal_mode_input"
                                                            {{ optional(Auth()->user()->gatewayCredentials->where('payment_method_id', $method->id)->where('key', 'mode')->first())->value == 1 ? 'checked' : '' }}
                                                            class="switch-input is-valid" />
                                                        <span class="switch-toggle-slider">
                                                            <span class="switch-on"></span>
                                                            <span class="switch-off"></span>
                                                        </span>
                                                        <span class="switch-label">{{_trans('order.Live Mode')}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <button class="btn btn-success" id="paypal_submit">{{_trans('common.Save')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('#stripe_form').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();
            let public_key = $("#public_key").val();
            let secret_key = $("#secret_key").val();

            formData.append('public_key', public_key);
            formData.append('secret_key', secret_key);
            formData.append('_token', "{{ csrf_token() }}");


            $('.error').text('');
            $.ajax({
                url: '{{ route('setting.payment-method.stripeCredentialStore') }}',
                type: 'POST',
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if (response.status == 403) {
                        $('.public_keyError').text(response.errors?.public_key ? response.errors
                            ?.public_key[0] : '');
                        $('.secret_keyError').text(response.errors?.secret_key ? response.errors
                            ?.secret_key[0] : '');
                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });
        });
        $('#paypal_form').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();
            let client_id = $("#client_id").val();
            let client_secret = $("#client_secret").val();
            let paypal_mode_input = $("#paypal_mode_input").is(":checked");

            formData.append('client_id', client_id);
            formData.append('client_secret', client_secret);
            formData.append('paypal_mode_input', paypal_mode_input);
            formData.append('_token', "{{ csrf_token() }}");


            $('.error').text('');
            $.ajax({
                url: '{{ route('setting.payment-method.paypalCredentialStore') }}',
                type: 'POST',
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if (response.status == 403) {
                        $('.client_secretError').text(response.errors?.client_secret ? response.errors
                            ?.client_secret[0] : '');
                        $('.client_idError').text(response.errors?.client_id ? response.errors
                            ?.client_id[0] : '');
                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });
        });
        $(document).on('change', '#changeStripeStatus', function() {
            const status = $(this).is(":checked");
            const formData = new FormData();
            formData.append('status', status);
            formData.append('_token', "{{ csrf_token() }}");

            Swal.fire({
                title: 'Are you sure?',
                text: "To change the status of the Stripe.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Change it',
                customClass: {
                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('setting.payment-method.stripeChangeStatus') }}',
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success(response.message);

                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }

            });
        })
        $(document).on('change', '#changePaypalStatus', function() {
            const status = $(this).is(":checked");
            const formData = new FormData();
            formData.append('status', status);
            formData.append('_token', "{{ csrf_token() }}");

            Swal.fire({
                title: 'Are you sure?',
                text: "To change the status of the Stripe.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Change it',
                customClass: {
                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('setting.payment-method.paypalChangeStatus') }}',
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success(response.message);

                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }

            });
        })
    </script>
@endpush

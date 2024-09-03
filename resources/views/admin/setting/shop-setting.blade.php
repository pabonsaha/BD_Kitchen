@extends('admin.layouts.master')

@section('title', $title ?? _trans('shop_setting.Shop Setting'))

@section('content')
    <div class="col-12 mb-4">
        {!! breadcrumb(_trans('shop_setting.Shop Setting') . ' ', [
            '#' => _trans('setting.System') . ' ' . _trans('setting.Settings'),
            'setting' => _trans('shop_setting.Shop Setting'),
        ]) !!}
        <div class="bs-stepper vertical wizard-vertical-icons-example mt-2">
            <div class="bs-stepper-header">
                <div class="step" data-target="#system-info-setting">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class="ti ti-file-description"></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span
                                class="bs-stepper-title">{{ _trans('setting.Shop') . ' ' . _trans('setting.Info') }}</span>
                            <span
                                class="bs-stepper-subtitle">{{ _trans('setting.Setup') . ' ' . _trans('setting.Shop') . ' ' . _trans('setting.Info') }}</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#logo-setting">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class="ti ti-user"></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{ _trans('common.Site') . ' ' . _trans('common.Logo') }}</span>
                            <span class="bs-stepper-subtitle">
                                {{ _trans('common.Add') . ' ' . _trans('common.Site') . ' ' . _trans('common.Logo') }}</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#social-links-vertical">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i> </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title"> {{ _trans('shop_setting.Social Links') }}</span>
                            <span
                                class="bs-stepper-subtitle">{{ _trans('common.Add') . ' ' . _trans('shop_setting.Social Links') }}</span>
                        </span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#terms-polices">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle"><i class="ti ti-notes"></i> </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title">{{ _trans('common.Terms & Polices') }}</span>
                            <span
                                class="bs-stepper-subtitle">{{ _trans('common.Add') . ' ' . _trans('common.Terms & Polices') }}</span>
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
                            <h6 class="mb-0">{{ _trans('setting.Shop') . ' ' . _trans('common.Info') }}</h6>
                            <small>{{ _trans('common.Enter') . ' ' . _trans('setting.Shop') . ' ' . _trans('common.Info') }}</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label"
                                    for="shop_name">{{ _trans('setting.Shop') . ' ' . _trans('common.Name') }}</label>
                                <input type="text" id="shop_name" name="shop_name" class="form-control"
                                    placeholder="House Brand" value="{{ $setting->shop_name }}" />

                                <span class="text-danger shop_nameError error"></span>

                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="address">{{ _trans('common.Address') }}</label>
                                <div class="input-group input-group-merge">
                                    <textarea name="address" id="address" class="form-control" placeholder="24/A, Road-6, Miami" rows="3">{{ $setting->location }}</textarea>

                                </div>

                                <span class="text-danger addressError error"></span>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="phone">{{ _trans('common.Phone') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="phone" name="phone" class="form-control" required
                                        placeholder="+88754451415" value="{{ $setting->phone }}" />
                                </div>
                                <span class="text-danger phoneError error"></span>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="email">{{ _trans('common.Email') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="email" id="email" name="email" class="form-control" required
                                        value="{{ $setting->email }}" placeholder="housebrand@example.com" />
                                </div>

                                <span class="text-danger emailError error"></span>

                            </div>
                            <div class="col-sm-12">
                                <label class="form-label"
                                    for="mapLocation">{{ _trans('common.Map') . ' ' . _trans('common.Location') }}</label>
                                <div class="input-group input-group-merge">
                                    <textarea id="map_location" name="map_location" class="form-control" placeholder="Iframe Map Location" rows="3">{{ $setting->map_location }}</textarea>
                                </div>

                                <span class="text-danger map_locationError error"></span>

                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    <span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">{{ _trans('common.Submit') }}</span>
                                    <i class="ti ti-arrow-up"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- eikhane --}}
                <!-- Site Logo -->
                <div id="logo-setting" class="content">
                    <form method="POST" id="logo-setting-form" enctype="multipart/form-data">
                        @csrf
                        <div class="content-header mb-3">
                            <h6 class="mb-0">{{ _trans('common.Site') . ' ' . _trans('common.Logo') }}</h6>
                            <small>{{ _trans('shop_setting.Enter Your Site Logo') }}</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="card mb-4">
                                    <h5 class="card-header">{{ _trans('common.Logo') }}</h5>
                                    <!-- Account -->
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <img src="{{ asset('storage/' . $setting->logo) }}"
                                                onerror="this.onerror=null;this.src='{{ asset('assets/img/illustrations/page-pricing-enterprise.png') }}'"
                                                alt="user-avatar" class="d-block w-px-100 h-px-100 rounded"
                                                id="lightLogo" />

                                            <div class="button-wrapper">
                                                <label for="lightLogoInput"
                                                    class="btn btn-primary me-2 mb-3 waves-effect waves-light"
                                                    tabindex="0">
                                                    <span
                                                        class="d-none d-sm-block">{{ _trans('shop_setting.Upload new light logo') }}</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" id="lightLogoInput" name="light_logo"
                                                        class=" lightLogo-account-file-input" hidden=""
                                                        accept="image/png, image/jpeg, image/jpg" />
                                                </label>
                                                <button type="button"
                                                    class="btn btn-label-secondary  mb-3 waves-effect lightLogo-account-image-reset">
                                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">{{ _trans('common.Reset') }}</span>
                                                </button>

                                                <div class="text-muted">
                                                    {{ _trans('shop_setting.Allowed JPG, GIF or PNG. Max size of 800KB') }}
                                                </div>
                                                <span class="text-danger light_logoError error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Account -->
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card mb-4">
                                    <h5 class="card-header">{{ _trans('common.Favicon') }}</h5>
                                    <!-- Account -->
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">

                                            <img src="{{ asset('storage/' . $setting->favicon) }}"
                                                onerror="this.onerror=null;this.src='{{ asset('assets/img/illustrations/page-pricing-enterprise.png') }}'"
                                                class="d-block w-px-100 h-px-100 rounded" id="feviconLogo" />
                                            <div class="button-wrapper">
                                                <label for="feviconLogoInput"
                                                    class="btn btn-primary me-2 mb-3 waves-effect waves-light"
                                                    tabindex="0">
                                                    <span
                                                        class="d-none d-sm-block">{{ _trans('shop_setting.Upload new favicon') }}</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" id="feviconLogoInput"
                                                        class="fevicon-account-file-input" name="favicon" hidden=""
                                                        accept="image/png, image/jpeg, image/jpg">
                                                </label>
                                                <button type="button"
                                                    class="btn btn-label-secondary fevicon-account-image-reset mb-3 waves-effect">
                                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">{{ _trans('common.Reset') }}</span>
                                                </button>

                                                <div class="text-muted">
                                                    {{ _trans('shop_setting.Allowed JPG, GIF or PNG. Max size of 800KB') }}
                                                </div>
                                                <span class="text-danger faviconError error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Account -->
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="card mb-4">
                                    <h5 class="card-header">{{ _trans('common.Current') . ' ' . _trans('common.Banner') }}
                                    </h5>
                                    <!-- Account -->
                                    <div class="card-body">
                                        <img src="{{ asset('storage/' . $setting->banner) }}" id="darkLogo"
                                            onerror="this.onerror=null;this.src='{{ asset('assets/img/illustrations/page-pricing-enterprise.png') }}'"
                                            alt="user-avatar" class="d-block w-100 h-px-100 rounded" />

                                    </div>
                                    <!-- /Account -->
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card mb-4">
                                    <h5 class="card-header">{{ _trans('common.Banner') }}</h5>
                                    <!-- Account -->
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <div class="button-wrapper">
                                                <label for="darkLogoInput"
                                                    class="btn btn-primary me-2 mb-3 waves-effect waves-light"
                                                    tabindex="0">
                                                    <span
                                                        class="d-none d-sm-block">{{ _trans('common.Upload') . ' ' . _trans('common.New') . ' ' . _trans('common.Banner') }}</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" id="darkLogoInput"
                                                        class="darkLogo-account-file-input" name="banner" hidden=""
                                                        accept="image/png, image/jpeg, image/jpg">
                                                </label>
                                                <button type="button"
                                                    class="btn btn-label-secondary darkLogo-account-image-reset mb-3 waves-effect">
                                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">{{ _trans('common.Reset') }}</span>
                                                </button>

                                                <div class="text-muted">
                                                    {{ _trans('shop_setting.Allowed JPG, GIF or PNG. Max size of 800KB') }}
                                                </div>
                                                <span class="text-danger dark_logoError error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Account -->
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    <span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">{{ _trans('common.Submit') }}</span>
                                    <i class="ti ti-arrow-up"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Social Links -->
                <div id="social-links-vertical" class="content">
                    <form method="POST" id="social-links-vertical-form">
                        @csrf
                        <div class="content-header mb-3">
                            <h6 class="mb-0">{{ _trans('shop_setting.Social Links') }}</h6>
                            <small>Enter Your
                                {{ _trans('common.Enter') . ' ' . _trans('common.Your') . ' ' . _trans('shop_setting.Social Links') }}</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="twitter1">{{ _trans('contact.Twitter') }}</label>
                                <input type="text" id="twitter1" name="twitter" class="form-control"
                                    value="{{ $setting->twitter_url }}" placeholder="https://twitter.com/abc" />
                                <span class="text-danger twitterError error"></span>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="facebook1">{{ _trans('contact.Facebook') }}</label>
                                <input type="text" id="facebook1" name="facebook" class="form-control"
                                    value="{{ $setting->facebook_url }}" placeholder="https://facebook.com/abc" />
                                <span class="text-danger facebookError error"></span>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="facebook1">{{ _trans('contact.Instagram') }}</label>
                                <input type="text" id="instagram" name="instagram" class="form-control"
                                    value="{{ $setting->instagram_url }}" placeholder="https://instagram.com/abc" />
                                <span class="text-danger instagramError error"></span>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="linkedin1">{{ _trans('contact.Linkedin') }}</label>
                                <input type="text" id="linkedin1" name="linkedin" class="form-control"
                                    value="{{ $setting->linkedin }}" placeholder="https://linkedin.com/abc" />
                                <span class="text-danger linkedinError error"></span>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="linkedin1">{{ _trans('contact.Youtube') }}</label>
                                <input type="text" id="youtube" name="youtube" class="form-control"
                                    value="{{ $setting->youtube_url }}" placeholder="https://youtube.com/abc" />
                                <span class="text-danger youtubeError error"></span>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="linkedin1">{{ _trans('contact.Tiktok') }}</label>
                                <input type="text" id="tiktok" name="tiktok" class="form-control"
                                    value="{{ $setting->tiktok_url }}" placeholder="https://tiktok.com/abc" />
                                <span class="text-danger tiktokError error"></span>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    <span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">{{ _trans('common.Submit') }}</span>
                                    <i class="ti ti-arrow-up"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Terms & Polices -->
                <div id="terms-polices" class="content">
                    <!-- Terms & Polices -->
                    <div>
                        <h6 class="mb-3">{{ _trans('common.Terms & Polices') }}</h6>
                        <div class="row mb-3">
                            <div>
                                <small>{{ _trans('common.Shipping Policy') }}</small>
                                <div class="form-control p-0 pt-1">
                                    <div class="shipping-policy-toolbar border-0 border-bottom">
                                        <div class="d-flex justify-content-start">
                                            <span class="ql-formats me-0">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                                <button class="ql-link"></button>
                                                {{-- <button class="ql-image"></button> --}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="shipping_policy border-0 pb-4" id="shipping_policy-description">
                                        {!! $setting->shipping_policy !!}
                                    </div>
                                </div>
                                <span class="text-danger shippingPolicyError error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div>
                                <small>{{ _trans('common.Return Policy') }}</small>
                                <div class="form-control p-0 pt-1">
                                    <div class="return-policy-toolbar border-0 border-bottom">
                                        <div class="d-flex justify-content-start">
                                            <span class="ql-formats me-0">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                                <button class="ql-link"></button>
                                                {{-- <button class="ql-image"></button> --}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="return_policy border-0 pb-4" id="return_policy-description">
                                        {!! $setting->return_policy !!}
                                    </div>
                                </div>
                                <span class="text-danger returnPolicyError error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <small>{{ _trans('common.Disclaimer') }}</small>
                                <div class="form-control p-0 pt-1">
                                    <div class="disclaimer-toolbar border-0 border-bottom">
                                        <div class="d-flex justify-content-start">
                                            <span class="ql-formats me-0">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                                <button class="ql-link"></button>
                                                {{-- <button class="ql-image"></button> --}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="disclaimer border-0 pb-4" id="disclaimer-description">
                                        {!! $setting->disclaimer !!}
                                    </div>
                                </div>
                                <span class="text-danger disclaimerError error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end mt-3">
                        <button id="add-terms-polices" class="btn btn-primary" type="button">
                            <span
                                class="align-middle d-sm-inline-block d-none me-sm-1">{{ _trans('common.Submit') }}</span>
                            <i class="ti ti-arrow-up"></i>
                        </button>
                    </div>
                </div>
                <!-- /Terms & Polices -->
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
                url: '{{ route('admin.setting.shop-setting.system_info.store') }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    // element = $('input[name="element_name"]');
                    shop_name: $('#shop_name').val(),
                    address: $('#address').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val(),
                    map_location: $('#map_location').val(),
                },
                success: function(response) {
                    if (response.status == 403) {
                        console.log(response.errors.phone[0]);

                        $('.shop_nameError').text(response.errors?.shop_name ? response.errors
                            ?.shop_name[
                                0] : '');
                        $('.siteTitleError').text(response.errors?.siteTitle ? response.errors
                            ?.siteTitle[0] : '');
                        $('.addressError').text(response.errors?.address ? response.errors?.address[0] :
                            '');
                        $('.phoneError').text(response.errors?.phone ? response.errors?.phone[0] : '');
                        $('.emailError').text(response.errors?.email ? response.errors?.email[0] : '');

                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });
        });


        $('#logo-setting-form').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();

            let name = $("input[name=name]").val();

            var lightLogo = $('#lightLogoInput').prop('files')[0] ?? '';
            var darkLogo = $('#darkLogoInput').prop('files')[0] ?? '';
            var fevicon = $('#feviconLogoInput').prop('files')[0] ?? '';

            formData.append('light_logo', lightLogo);
            formData.append('banner', darkLogo);
            formData.append('favicon', fevicon);
            formData.append('_token', "{{ csrf_token() }}");


            $('.error').text('');
            $.ajax({
                url: '{{ route('admin.setting.shop-setting.site_logo.store') }}',
                type: 'POST',
                contentType: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if (response.status == 403) {
                        $('.light_logoError').text(response.errors?.light_logo ? response.errors
                            ?.light_logo[0] : '');
                        $('.dark_logoError').text(response.errors?.dark_logo ? response.errors
                            ?.dark_logo[0] : '');
                        $('.faviconError').text(response.errors?.favicon ? response.errors?.favicon[0] :
                            '');
                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });
        });


        $('#social-links-vertical-form').on('submit', function(e) {
            e.preventDefault();

            $('.error').text('');
            $.ajax({
                url: '{{ route('admin.setting.shop-setting.social_link.store') }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    twitter: $('#twitter1').val(),
                    facebook: $('#facebook1').val(),
                    instagram: $('#instagram').val(),
                    linkedin: $('#linkedin1').val(),
                    youtube: $('#youtube').val(),
                    tiktok: $('#tiktok').val(),
                },
                success: function(response) {
                    if (response.status == 403) {
                        $('.twitterError').text(response.errors?.twitter ? response.errors
                            ?.twitter[0] : '');
                        $('.facebookError').text(response.errors?.facebook ? response.errors
                            ?.facebook[0] : '');
                        $('.instagramError').text(response.errors?.instagram ? response.errors
                            ?.instagram[0] :
                            '');
                        $('.linkedinError').text(response.errors?.linkedin ? response.errors?.linkedin[
                                0] :
                            '');
                        $('.youtubeError').text(response.errors?.youtube ? response.errors?.youtube[0] :
                            '');
                        $('.tiktokError').text(response.errors?.tiktok ? response.errors?.tiktok[0] :
                            '');
                    } else if (response.status == 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {

                    toastr.error(error.responseJSON.message);
                }
            });
        });

        $('#add-terms-polices').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('admin.setting.shop-setting.terms_polices.store') }}',
                type: 'POST',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'shipping_policy': $('#shipping_policy-description').children().first().html(),
                    'disclaimer': $('#disclaimer-description').children().first().html(),
                    'return_policy': $('#return_policy-description').children().first().html(),
                },
                success: function(response) {
                    if (response.status === 403) {
                        toastr.error(response.message);
                    } else if (response.status === 200) {
                        toastr.success(response.message);
                    }
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });
        });
    </script>
    {{-- form submit ajax --}}

    <script>
        let lightLogoImage = document.getElementById('lightLogo');
        const lightLogofileInput = document.querySelector('.lightLogo-account-file-input'),
            lightLogoresetFileInput = document.querySelector('.lightLogo-account-image-reset');

        if (lightLogoImage) {
            const resetImage = lightLogoImage.src;
            lightLogofileInput.onchange = () => {
                if (lightLogofileInput.files[0]) {
                    lightLogoImage.src = window.URL.createObjectURL(lightLogofileInput.files[0]);
                }
            };
            lightLogoresetFileInput.onclick = () => {
                lightLogofileInput.value = '';
                lightLogoImage.src = resetImage;
            };
        }

        let darkLogoImage = document.getElementById('darkLogo');
        const darkLogofileInput = document.querySelector('.darkLogo-account-file-input'),
            darkLogoresetFileInput = document.querySelector('.darkLogo-account-image-reset');

        if (darkLogoImage) {
            const resetImage = darkLogoImage.src;
            darkLogofileInput.onchange = () => {
                if (darkLogofileInput.files[0]) {
                    darkLogoImage.src = window.URL.createObjectURL(darkLogofileInput.files[0]);
                }
            };
            darkLogoresetFileInput.onclick = () => {
                darkLogofileInput.value = '';
                darkLogoImage.src = resetImage;
            };
        }


        let feviconImage = document.getElementById('feviconLogo');
        const feviconFileInput = document.querySelector('.fevicon-account-file-input'),
            resetFeviconFileInput = document.querySelector('.fevicon-account-image-reset');

        if (feviconImage) {
            const resetImage = feviconImage.src;
            feviconFileInput.onchange = () => {
                if (feviconFileInput.files[0]) {
                    feviconImage.src = window.URL.createObjectURL(feviconFileInput.files[0]);
                }
            };
            resetFeviconFileInput.onclick = () => {
                feviconFileInput.value = '';
                feviconImage.src = resetImage;
            };
        }
    </script>
@endpush

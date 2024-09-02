@extends('admin.layouts.master')

@section('title', $title ?? __('Add Product'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb('Add New Product', [
            '#' => 'Product Management',
            'product/index' => 'Products',
            'product' => 'Add New Product',
        ]) !!}
        <div class="app-ecommerce">
            <!-- Add Product -->
            <form action="" id="product-add" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <!-- First column-->
                    <div class="col-12 col-lg-8">
                        <!-- Product Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-tile mb-0">{{ _trans('product.Product information') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-9">
                                        <label class="form-label"
                                            for="ecommerce-product-name">{{ _trans('common.Title') }}</label>
                                        <input type="text" class="form-control" id="title"
                                            placeholder="Product title" name="title" aria-label="Product title" />
                                        <span class="text-danger titleError error"></span>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label"
                                            for="ecommerce-product-barcode">{{ _trans('product.Barcode') }}</label>
                                        <input type="text" class="form-control" id="barcode" placeholder="0123-4567"
                                            name="barcode" aria-label="Product barcode" />
                                        <span class="text-danger barcodeError error"></span>
                                    </div>
                                </div>
                                <!-- Description -->
                                <div>
                                    <label class="form-label">{{ _trans('common.Description') }} (Optional)</label>
                                    <div class="form-control p-0 pt-1">
                                        <div class="comment-toolbar border-0 border-bottom">
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
                                        <div class="product-editor border-0 pb-4" id="description"></div>
                                    </div>
                                    <span class="text-danger descriptionError error"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Information -->

                        <!-- Product Image -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ _trans('product.Product Images') }}
                                    <button type="button" class="border border-0 text-primary bg-transparent m-0 p-0"
                                        data-bs-toggle="popover" data-bs-placement="right"
                                        data-bs-content="You can upload multiple image of a product" title="Variants"><small
                                            class="rounded-circle p-0 m-0 px-1 bg-primary"><i
                                                class="fa-solid fa-question text-white"
                                                style="font-size: 10px !important"></i></small>
                                    </button>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="multiple-uploader" id="multiple-uploader">
                                    <div class="mup-msg">
                                        <span class="mup-main-msg">{{ _trans('product.Click to upload images') }}.</span>
                                        <span class="mup-msg"
                                            id="max-upload-number">{{ _trans('product.Upload up to 10 images') }}</span>
                                        <span class="mup-msg">{{ _trans('product.Select multiple image together') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product Image -->


                        <!-- /Diamension & Specifications-->

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ _trans('product.Specifications') }}</h5>
                            </div>
                            <div class="card-body">

                                <div class="row mt-4" id="specificationsContainer">
                                    <div class="row justify-content-between">
                                        <div class="col-6">
                                            <h6>{{ _trans('product.Specifications') }}:</h6>
                                        </div>
                                        <div class="col-3 text-end"><button class="btn btn-primary btn-sm" type="button"
                                                id="addMoreSpecifications"><i class="ti ti-plus ti-xs me-0"></i></button>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label class="form-label"
                                                for="Specifications">{{ _trans('common.Title') }}</label>
                                            <input type="text" class="form-control parentSpecificationsTitle"
                                                id="ecommerce-product-name" placeholder="Specifications title"
                                                name="specifications[title][]" aria-label="Specifications Title" />
                                        </div>
                                        <div class="col-8">
                                            <label class="form-label"
                                                for="ecommerce-product-name">{{ _trans('product.Value') }}</label>
                                            <input type="text" class="form-control parentSpecificationsDescription"
                                                id="ecommerce-product-name" placeholder="Specifications"
                                                name="specifications[value][]" aria-label="Specifications" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Diamension & Specifications -->

                        <!-- Meta -->

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Meta Value</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="ecommerce-product-name">Meta Title</label>
                                        <input type="text" class="form-control" id="mata_title"
                                            placeholder="Meta title" name="mata_title" aria-label="Product title" />
                                        <span class="text-danger metaTitleError error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ecommerce-product-name">Meta Description</label>
                                        <textarea class="form-control" placeholder="Meta Description" name="meta_description" id="meta_description"
                                            cols="30" rows="5"></textarea>
                                        <span class="text-danger metaDescriptionError error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ecommerce-product-name">Meta Image</label>

                                        <input type="file" class="form-control" name="meta_image" id="meta_image">
                                        <span class="text-danger metaImageError error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /Meta -->
                    </div>
                    <!-- /Second column -->

                    <!-- Second column -->
                    <div class="col-12 col-lg-4">

                        <!-- Media -->
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 card-title">{{ _trans('common.Thumbnail') }}</h5>
                            </div>
                            <div class="card-body">

                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="" id="darkLogo"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/img/illustrations/page-pricing-enterprise.png') }}'"
                                        alt="user-avatar" class="d-block w-px-200 h-px-auto rounded" />
                                    <div class="button-wrapper">
                                        <label for="darkLogoInput"
                                            class="btn btn-primary me-2 mb-3 waves-effect waves-light" tabindex="0">
                                            <span class="d-none d-sm-block">{{ _trans('product.Upload Image') }}</span>
                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                            <input type="file" id="darkLogoInput" class="darkLogo-account-file-input"
                                                name="dark_logo" hidden=""
                                                accept="image/png, image/jpeg, image/jpg">
                                        </label>
                                        <button type="button"
                                            class="btn btn-label-secondary darkLogo-account-image-reset mb-3 waves-effect">
                                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">{{ _trans('common.Reset') }}</span>
                                        </button>

                                        <div class="text-muted">
                                            {{ _trans('product.Allowed JPG, GIF or PNG. Max size of 800KB') }}</div>
                                        <span class="text-danger dark_logoError error"></span>
                                    </div>
                                </div>
                                <span class="text-danger thumbnailImageError error"></span>
                                <div class="mb-3 mt-3">
                                    <h6 class="mb-1 card-title">{{ _trans('product.Video Link') }}</h6>
                                    <input type="text" class="form-control" placeholder="ex. www.youtube.com/abc"
                                        id="video_link" name="video_link" aria-label="Product title" />
                                </div>
                            </div>
                        </div>
                        <!-- /Media -->
                        <!-- Pricing Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ _trans('product.Pricing') }}
                                    <button type="button" class="border border-0 text-primary bg-transparent m-0 p-0"
                                        data-bs-toggle="popover" data-bs-placement="right"
                                        data-bs-content="Setting a base price for our essential product is required. If there are no discounts, the base price will stay the same."
                                        title="Pricing"><small class="rounded-circle p-0 m-0 px-1 bg-primary"><i
                                                class="fa-solid fa-question text-white"
                                                style="font-size: 10px !important"></i></small>
                                    </button>
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Base Price -->
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="ecommerce-product-price">{{ _trans('product.Base Price') }}</label>
                                    <input type="number" class="form-control" id="product_price" placeholder="Price"
                                        name="unit_price" aria-label="Product price" />
                                    <span class="text-danger unitPriceError error"></span>
                                </div>

                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="discout_type">
                                        <span>{{ _trans('order.Discount Type') }}</span>
                                    </label>
                                    <select id="discout_type" name="discount_type" class="select2 form-select"
                                        data-placeholder="Select Category">
                                        <option value="0">
                                            {{ _trans('common.Select') . ' ' . _trans('common.Option') }}
                                        </option>
                                        <option value="0">No Discount</option>
                                        <option value="1">{{ _trans('common.Percentage') }} %</option>
                                        <option value="2">{{ _trans('common.Fixed') }}</option>
                                    </select>
                                </div>
                                <span class="text-danger discountTypeError error"></span>


                                <!-- Discounted Price -->
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="ecommerce-product-discount-price">{{ _trans('common.Discount') }}</label>
                                    <input type="number" class="form-control" id="discount_price"
                                        placeholder="Discounted Price" name="discount_value"
                                        aria-label="Product discounted price" />

                                    <span class="text-danger discountValueError error"></span>
                                    <br />
                                    <small class="text-primary"><span
                                            class="text-danger">*</span>{{ _trans('product.Dont need input if product dont have discount') }}.</small>
                                </div>


                            </div>
                        </div>
                        <!-- /Pricing Card -->
                        <!-- Organize Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ _trans('product.Organize') }}</h5>
                            </div>
                            <div class="card-body">

                                <!-- Category -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1 d-flex justify-content-between align-items-center"
                                        for="category-org">
                                        <span>{{ _trans('portfolio.Category') }}</span>
                                    </label>
                                    <select id="category" name="category" class="select2 form-select"
                                        data-placeholder="Select Category">
                                        <option value="">
                                            {{ _trans('common.Select') . ' ' . _trans('portfolio.Category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="mb-3 col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="status-org">{{ _trans('common.Status') }}
                                    </label>
                                    <select id="status" name="status" class="select2 form-select"
                                        data-placeholder="Published">
                                        <option value="1" selected>{{ _trans('common.Published') }}</option>
                                        <option value="0">{{ _trans('common.Unpublished') }}</option>
                                    </select>
                                </div>
                                <!-- Tags -->
                                <div class="mb-3">
                                    <label for="ecommerce-product-tags"
                                        class="form-label mb-1">{{ _trans('product.Tags') }}</label>
                                    <input id="ecommerce-product-tags" class="form-control" name="ecommerce_product_tags"
                                        aria-label="Product Tags" />
                                </div>
                            </div>
                        </div>
                        <!-- /Organize Card -->

                        <!-- Terms & Polices -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ _trans('common.Terms & Polices') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div>
                                        <h6>{{ _trans('common.Shipping Policy') }}</h6>
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

                                            </div>
                                        </div>
                                        <span class="text-danger shippingPolicyError error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div>
                                        <h6>Disclaimer</h6>
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

                                            </div>
                                        </div>
                                        <span class="text-danger disclaimerError error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /Terms & Polices -->

                    </div>

                    <!-- /Second column -->
                </div>


                <div class="row justify-content-center">
                    <button type="submit" id="addProduct"
                        class="btn btn-primary col-4">{{ _trans('common.Submit') }}</button>
                </div>

            </form>
        </div>

    @endsection

    @push('scripts')
        <script src="{{ asset('assets/js/multiple-uploader.js') }}"></script>
        <script>
            $(document).ready(function() {

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


                $('#addMoreSpecifications').on('click', function() {
                    let s = $(
                        `<div class="row mb-3 parentSpecifications">
                        <div class="col-4" >
                            <label class="form-label" for= "Specifications">Title</label>
                            <input type = "text"class = "form-control parentSpecificationsTitle" id = "ecommerce-product-name" placeholder = "Product title" name="specifications[title][]" aria-label = "Specifications Title" />
                        </div>
                        <div class="col-8" >
                            <label class="form-label" for="ecommerce-product-name"> Details </label>
                            <div class="row">
                                <div class='col-11'>
                                    <input type="text" class="form-control parentSpecificationsDescription" id = "ecommerce-product-name" placeholder = "Product title" name="specifications[value][]" aria-label = "Specifications Details" />
                                </div>
                                <div class="col-1 text-danger deleteSpecifications" >
                                    <i class="ti ti-trash "></i>
                                </div>

                            </div>
                        </div>
                    </div>`
                    );

                    $('#specificationsContainer').append(s);

                });

                $(document).on('click', '.deleteSpecifications', function() {
                    $(this).closest('.parentSpecifications').remove();

                });


                $('#addProduct').click(function() {
                    event.preventDefault();
                    console.log($('.product_images'));
                    var frm = $('#product-add');
                    var formData = new FormData(frm[0]);
                    formData.append('meta_image', $('#meta_image').prop('files')[0] ?? '');
                    formData.append('description', $('#description').children().first().html());
                    formData.append('shipping_policy', $('#shipping_policy-description').children().first()
                        .html());
                    formData.append('return_policy', $('#return_policy-description').children().first().html());
                    formData.append('disclaimer', $('#disclaimer-description').children().first().html());

                    formData.append(`thumbnail`, $('#darkLogoInput').prop('files')[0] ?? '');

                    $('.error').empty();

                    $.ajax({
                        url: '{{ route('admin.product.store') }}',
                        type: 'POST',
                        data: formData,
                        contentType: 'multipart/form-data',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            toastr.success(response.message);
                            window.location.href = "{{ route('admin.product.index') }}";
                        },
                        error: function(error) {
                            if (error.status == 422) {
                                let response = error.responseJSON;
                                $('.titleError').text(response.errors?.title ? response.errors
                                    ?.title[0] : '');
                                $('.barcodeError').text(response.errors?.barcode ? response.errors
                                    ?.barcode[0] : '');
                                $('.descriptionError').text(response.errors?.description ? response
                                    .errors?.description[0] : '');
                                $('.unitPriceError').text(response.errors?.unit_price ? response
                                    .errors?.unit_price[0] : '');
                                $('.discountTypeError').text(response.errors?.discount_type ?
                                    response.errors?.discount_type[0] : '');
                                $('.discountValueError').text(response.errors?.discount_value ?
                                    response.errors?.discount_value[0] : '');
                                $('.shippingPolicyError').text(response.errors?.shipping_policy ?
                                    response.errors?.shipping_policy[0] : '');
                                $('.returnPolicyError').text(response.errors?.return_policy ?
                                    response.errors?.return_policy[0] : '');
                                $('.disclaimerError').text(response.errors?.disclaimer ? response
                                    .errors?.disclaimer[0] : '');
                                $('.metaTitleError').text(response.errors?.meta_title ? response
                                    .errors?.meta_title[0] : '');
                                $('.metaDescriptionError').text(response.errors?.meta_description ?
                                    response.errors?.meta_description[0] : '');
                                $('.metaImageError').text(response.errors?.meta_image ? response
                                    .errors?.meta_image[0] : '');
                                $('.thumbnailImageError').text(response.errors?.thumbnail ? response
                                    .errors
                                    ?.thumbnail[0] : '');

                                $.each($('.error'), function(index, value) {
                                    if (!$(value).is(':empty')) {
                                        $('html').animate({
                                            scrollTop: $(value).offset().top - 400
                                        }, 500);
                                        return false;
                                    }
                                });
                            } else {
                                toastr.error(error.responseJSON.message);
                                console.log(error);
                            }
                        }
                    });
                })


                let multipleUploader = new MultipleUploader('#multiple-uploader').init({
                    maxUpload: 20, // maximum number of uploaded images
                    maxSize: 2, // in size in mb
                    filesInpName: 'images', // input name sent to backend
                    formSelector: '#product-add', // form selector
                });


            });
        </script>
    @endpush

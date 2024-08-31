@extends('layouts.master')

@section('title', $title ??  _trans('product.Bulk') .' '._trans('product.Export'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('product.Bulk') .' '._trans('product.Export'), ['#' => _trans('product.Product').' '._trans('product.Management'), 'bulk-export' => _trans('product.Bulk') .' '._trans('product.Export')]) !!}

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="text-primary">{{_trans('product.Export your Product List')}}</h6>
                <form action="{{ route('bulkExport.export') }}" method="POST">
                    @csrf
                    <div class="row p-sm-3 p-0">
                        <!-- Status Dropdown -->
                        <div class="col-md-2 ecommerce-select2-dropdown">
                            <label for="isPublishedList"
                                   class="form-label mb-1 d-flex justify-content-between align-items-center">
                                <span>{{_trans('common.Select').' '._trans('common.Status')}}</span>
                            </label>
                            <select id="isPublishedList" name="isPublishedList" class="select2 form-select"
                                    data-placeholder="Select Status">
                                <option value="" selected disabled>{{_trans('common.Select').' '._trans('common.Status')}}</option>
                                    <option value="0">{{_trans('common.Unpublished')}}</option>
                                    <option value="1">{{_trans('common.Published')}}</option>
                            </select>
                        </div>
                        <!-- Category Dropdown -->
                        <div class="col-md-2 ecommerce-select2-dropdown">
                            <label for="categoryList"
                                   class="form-label mb-1 d-flex justify-content-between align-items-center">
                                <span>{{_trans('portfolio.Category')}}</span>
                            </label>
                            <select id="categoryList" name="categoryList" class="select2 form-select"
                                    data-placeholder="Select Category">
                                <option value="" selected
                                        disabled>{{_trans('common.Select') .''._trans('portfolio.Category')}}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Brand Dropdown -->
                        <div class="col-md-2 ecommerce-select2-dropdown">
                            <label for="brandList"
                                   class="form-label mb-1 d-flex justify-content-between align-items-center">
                                <span>{{_trans('Brand')}}</span>
                            </label>
                            <select id="brandList" name="brandList" class="select2 form-select"
                                    data-placeholder="Select Brand">
                                <option value="" selected
                                        disabled>{{_trans('common.Select').' '. _trans('product.Brands')}}</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(getUserId() == App\Models\Role::SUPER_ADMIN)
                            <!-- Select Type Dropdown -->
                            <div class="col-md-3 ecommerce-select2-dropdown">
                                <label for="typeSelect"
                                       class="form-label mb-1 d-flex justify-content-between align-items-center">
                                    <span>{{_trans('common.Select').' '._trans('common.Type')}}</span>
                                </label>
                                <select id="typeSelect" name="typeSelect" class="select2 form-select"
                                        data-placeholder="Select Type">
                                    <option value="" selected
                                            disabled>{{_trans('common.Select').' '._trans('common.Type')}}</option>
                                    <option value="manufacturer">{{_trans('product.Manufacturer')}}</option>
                                    <option value="designer">{{_trans('user.Designers')}}</option>
                                </select>
                            </div>

                            <!-- Manufacturer Dropdown -->
                            <div class="col-md-3 ecommerce-select2-dropdown" id="manufacturerDropdown"
                                 style="display:none;">
                                <label for="manufacturerList"
                                       class="form-label mb-1 d-flex justify-content-between align-items-center">
                                    <span>{{_trans('common.Select').' '. _trans('product.Manufacturer')}}</span>
                                </label>
                                <select id="manufacturerList" name="manufacturerList" class="select2 form-select"
                                        data-placeholder="Select Manufacturer">
                                    <option value="" selected
                                            disabled>{{_trans('common.Select').' '. _trans('product.Manufacturer')}}</option>
                                    @foreach ($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Designer Dropdown -->
                            <div class="col-md-3 ecommerce-select2-dropdown" id="designerDropdown"
                                 style="display:none;">
                                <label for="designerList"
                                       class="form-label mb-1 d-flex justify-content-between align-items-center">
                                    <span>{{_trans('common.Select').' '. _trans('user.Designers')}}</span>
                                </label>
                                <select id="designerList" name="designerList" class="select2 form-select"
                                        data-placeholder="Select Designer">
                                    <option value="" selected
                                            disabled>{{_trans('common.Select').' '. _trans('user.Designers')}}</option>
                                    @foreach ($designers as $designer)
                                        <option value="{{ $designer->id }}">{{ $designer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                    </div>
                    <button class="btn btn-primary mt-5" type="submit">{{_trans('common.Export')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            $('#typeSelect').change(function () {
                var selectedType = $(this).val();
                if (selectedType === 'manufacturer') {
                    $('#manufacturerDropdown').show();
                    $('#designerDropdown').hide();
                } else if (selectedType === 'designer') {
                    $('#manufacturerDropdown').hide();
                    $('#designerDropdown').show();
                } else {
                    $('#manufacturerDropdown').hide();
                    $('#designerDropdown').hide();
                }
            });
        });
    </script>
@endpush

@extends('layouts.master')

@section('title', $title ?? _trans('product.Brands'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb('Brand List',['#'=>_trans('product.Product').' '._trans('product.Management'),'brand'=>_trans('product.Brands') . _trans('order.List')]) !!}

        <div class="app-ecommerce-category">
            <!-- Category List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 " style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{_trans('common.Status')}} :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select') }} {{_trans('common.Status')}}</option>
                            <option value="1">{{_trans('common.Active') }}</option>
                            <option value="0">{{_trans('common.Deactive') }}</option>
                        </select>
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-check-input"></th>
                                <th>{{_trans('common.Name')}}</th>
                                <th>{{_trans('common.Image')}}</th>
                                <th>{{_trans('common.Description')}}</th>
                                <th>{{_trans('common.Status')}}</th>
                                <th>{{_trans('common.Info')}}</th>
                                <th>{{_trans('common.Action')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Offcanvas to add new customer -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEBrandList"
                aria-labelledby="offcanvasEcommerceListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">{{_trans('common.Add').' '._trans('product.Brands')}}</h5>
                    <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <!-- Offcanvas Body -->
                <div class="offcanvas-body border-top">
                    <form class="pt-0" id="addModal" method="POST">
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-category-title">{{_trans('common.Name')}}</label>
                            <input type="text" class="form-control" id="ecommerce-category-title"
                                placeholder="Enter brand name" name="name" aria-label="Brand Name" />
                            <span class="text-danger nameError error"></span>
                        </div>
                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label" for="brand-image">{{_trans('product.Brands').' '._trans('common.Image')}}</label>
                            <input class="form-control" type="file" name="image" id="brand-image" />
                            <span class="text-danger imageError error"></span>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">{{_trans('common.Description')}}</label>
                            <textarea name="description" class="form-control" id="brand-descripton" cols="30" rows="10"></textarea>
                            <span class="text-danger descriptionError error"></span>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('product.Select Brand status')}}</label>
                            <select id="brand-status" name="status" class="select2 form-select"
                                data-placeholder="Select category status">
                                <option value="1" selected>{{_trans('common.Active')}}</option>
                                <option value="0">{{_trans('common.Inactive')}}</option>
                            </select>
                            <span class="text-danger statusError error"></span>
                        </div>
                        <!-- Submit and reset -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{_trans('common.Add')}}</button>
                            <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">{{_trans('common.Add')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Offcanvas to edit category -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasBrandEditModal"
                aria-labelledby="offcanvasEcommerceCategoryListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">{{_trans('product.Edit Brand')}}</h5>
                    <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <!-- Offcanvas Body -->
                <div class="offcanvas-body border-top">
                    <form class="pt-0" id="updateCategoryModal" method="POST">
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="edit_name">{{_trans('common.Name')}}</label>
                            <input type="text" class="form-control" id="edit_name" placeholder="Enter brand name"
                                name="edit_name" aria-label="brand name" />
                            <input type="text" hidden value="" name="brand_id" id="brand_id">
                            <span class="text-danger editNameError error"></span>
                        </div>
                        <!-- Image -->
                        <div class="mb-3" id="currentImageSection">
                            <img src="" id="currentImage" alt="" width="60px" height="60px">
                        </div>
                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label" for="brand-image">{{_trans('product.Brands').' '._trans('common.Image')}}</label>
                            <input class="form-control" type="file" name="edit_image" id="edit_image" />
                            <span class="text-danger editImageError error"></span>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">{{_trans('common.Description')}}</label>
                            <textarea name="edit_description" placeholder="Brand description" class="form-control" id="edit_description"
                                cols="30" rows="10"></textarea>
                            <span class="text-danger editDescriptionError error"></span>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('product.Select Brand status')}}</label>
                            <select id="edit_status" name="edit_status" class="select2 form-select"
                                data-placeholder="Select category status">
                                <option value="1">{{_trans('common.Active') }}</option>
                                <option value="0">{{_trans('common.Deactive') }}</option>
                            </select>
                            <span class="text-danger editStatusError error"></span>
                        </div>
                        <!-- Submit and reset -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{_trans('common.Update')}}</button>
                            <button type="reset" class="btn bg-label-danger"
                                data-bs-dismiss="offcanvas">{{_trans('common.Discard')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{{ route('brand.index') }}',
                    data: function (d){
                        d.status = $('#status').val()
                    }
                },
                columns: [{
                        data: '',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function (data, type, row) {
                            if (data !== null) {
                                const truncated = data.length > 100 ? data.substr(0, 100) + '...' : data;
                                return '<div data-bs-toggle="tooltip" data-bs-placement="right" title="' + data + '" style="width: 220px; white-space: normal; word-wrap: break-word;">' +
                                    truncated + '</div>';
                            } else {
                                return '<div style="width: 220px; white-space: normal; word-wrap: break-word;">No description available</div>';
                            }
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'info',
                        name: 'info'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                    targets: 0,
                    className: "control",
                    responsivePriority: 1,
                    render: function() {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                    },
                }],
                order: [2, "desc"], //set any columns order asc/desc
                "fnDrawCallback": function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                },
                dom: '<"card-header d-flex flex-wrap pb-2"' +
                    "<f>" +
                    '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"lB>>' +
                    ">t" +
                    '<"row mx-2"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    ">",
                lengthMenu: [10, 20, 50, 70, 100], //for length of menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search Brand",
                },
                // Button for offcanvas
                buttons: [
                        @if(hasPermission('brand_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">{{_trans('common.Add') .' '._trans('product.Brands')}}</span>',
                        className: "add-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "offcanvas",
                            "data-bs-target": "#offcanvasEBrandList",
                        },

                    },
                    @endif
                ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });

            $('#addModal').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData();

                let name = $("input[name=name]").val();
                let description = $("#brand-descripton").val();
                let status = $("#brand-status option:selected").val();
                var image = $('#brand-image').prop('files')[0] ?? '';

                formData.append('name', name);
                formData.append('description', description);
                formData.append('status', status);
                formData.append('image', image);
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('brand.store') }}',
                    type: 'POST',
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status == 403) {
                            $('.nameError').text(response.errors?.name ? response.errors
                                ?.name[0] : '');
                            $('.imageError').text(response.errors?.image ? response.errors
                                ?.image[0] : '');
                            $('.descriptionError').text(response.errors?.description ? response
                                .errors
                                ?.description[0] :
                                '');
                            $('.statusError').text(response.errors?.status ? response.errors
                                ?.status[0] :
                                '');
                        } else if (response.status == 200) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);

                            $("input[name=name]").val('');
                            $("#brand-descripton").val('');
                            $('#brand-image').val('');
                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });


            $(document).on("click", ".brand_edit_button", function() {

                $id = $(this).attr("data-id");
                $('#edit_status').find('option:selected').attr("selected", false);
                $('#edit_status').trigger('change');
                $.ajax({
                    url: '/brand/' + $id,
                    type: 'GET',
                    success: function(response) {
                        $('#brand_id').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                        $('#edit_description').val(response.data.description);
                        $("#edit_status").find('option').removeAttr("selected");
                        $('#edit_status').trigger('change.select2');
                        $('#edit_status').find('option[value="' + response.data.active_status +
                            '"]').attr("selected", "selected");
                        $("#currentImage").attr("src", ``);

                        if (response.data.image != null) {
                            $("#currentImage").attr("src", `/storage/${response.data.image}`);
                        }

                        $('#edit_status').trigger('change');
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });


            $('#updateCategoryModal').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData();

                let brand_id = $('#brand_id').val();
                let name = $("input[name=edit_name]").val();
                let description = $("#edit_description").val();
                let status = $("#edit_status option:selected").val();
                var image = $('#edit_image').prop('files')[0] ?? '';

                formData.append('name', name);
                formData.append('description', description);
                formData.append('status', status);
                formData.append('image', image);
                formData.append('brand_id', brand_id);
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('brand.update') }}',
                    type: 'POST',
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status == 403) {
                            $('.editNameError').text(response.errors?.name ? response.errors
                                ?.name[0] : '');
                            $('.editImageError').text(response.errors?.image ? response.errors
                                ?.image[0] : '');
                            $('.editDescriptionError').text(response.errors?.description ?
                                response
                                .errors
                                ?.description[0] :
                                '');
                            $('.editStatusError').text(response.errors?.status ? response.errors
                                ?.status[0] :
                                '');
                        } else if (response.status == 200) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false)
                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });

            $(document).on("click", ".brand_delete_button", function() {

                let id = $(this).attr("data-id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {

                        $.ajax({
                            url: '{{ route('brand.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                brand_id: id,
                            },
                            success: function(response) {
                                table.ajax.reload(null, false)
                                Swal.fire({
                                    icon: response.icon,
                                    title: 'Deleted!',
                                    text: response.text,
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect waves-light'
                                    }
                                });
                            },
                            error: function(error) {
                                console.log(error.responseJSON.message);
                                // handle the error case
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush

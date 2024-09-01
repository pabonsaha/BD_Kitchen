@extends('admin.layouts.master')

@section('title', $title ?? _trans('portfolio.Category'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('portfolio.Category').' '. _trans('order.List'),['#'=>_trans('product.Product').' '._trans('product.Management'),'category'=> _trans('portfolio.Category').' '. _trans('order.List')]) !!}

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
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceCategoryList"
                aria-labelledby="offcanvasEcommerceCategoryListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">{{_trans('common.Add')}} {{_trans('portfolio.Category')}}</h5>
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
                                placeholder="Enter category name" name="name" aria-label="category title" />
                            <span class="text-danger nameError error"></span>
                        </div>

                        <!-- Category parent -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('common.Select')}} {{_trans('common.Parent')}} {{_trans('portfolio.Category')}}</label>
                            <select id="parenet_category_id" name="parenet_category_id" class="select2 form-select"
                                data-placeholder="Select category status">
                                <option value="0">{{_trans('common.Select')}} {{_trans('common.Parent')}} {{_trans('portfolio.Category')}}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                            </select>
                            <span class="text-danger errorParenet_category_id error"></span>
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label" for="category-image">{{_trans('portfolio.Category')}} {{_trans('common.Image')}}</label>
                            <input class="form-control" type="file" name="image" id="category-image" />
                            <span class="text-danger imageError error"></span>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">{{_trans('common.Description')}}</label>
                            <textarea name="description" class="form-control" id="category-descripton" cols="30" rows="10"></textarea>
                            <span class="text-danger descriptionError error"></span>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('common.Select')}} {{_trans('portfolio.Category')}} {{_trans('common.Status')}}</label>
                            <select id="category-status" name="status" class="select2 form-select"
                                data-placeholder="Select category status">
                                <option value="1" selected>{{_trans('common.Active')}}</option>
                                <option value="0">{{_trans('common.Deactive')}}</option>
                            </select>
                            <span class="text-danger statusError error"></span>
                        </div>
                        <!-- Submit and reset -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{_trans('common.Add')}}</button>
                            <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">{{_trans('common.Discard')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Offcanvas to edit category -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCategoryEditModal"
                aria-labelledby="offcanvasEcommerceCategoryListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">{{_trans('common.Edit')}} {{_trans('portfolio.Category')}}</h5>
                    <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <!-- Offcanvas Body -->
                <div class="offcanvas-body border-top">
                    <form class="pt-0" id="updateCategoryModal" method="POST">
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="edit_name">{{_trans('common.Name')}}</label>
                            <input type="text" class="form-control" id="edit_name" placeholder="Enter category name"
                                name="edit_name" aria-label="category title" />
                            <input type="text" hidden value="" name="category_id" id="category_id">
                            <span class="text-danger editNameError error"></span>
                        </div>

                        <!-- Category parent -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('common.Select')}} {{_trans('common.Parent')}} {{_trans('portfolio.Category')}}</label>
                            <select id="edit_parenet_category_id" name="edit_parenet_category_id"
                                class="select2 form-select" data-placeholder="Select category status">
                                <option value="0">{{_trans('common.Select')}} {{_trans('common.Parent')}} {{_trans('portfolio.Category')}}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                            </select>
                            <span class="text-danger ErrorParenet_category_id error"></span>
                        </div>
                        <!-- Image -->
                        <div class="mb-3" id="currentImageSection">
                            <img src="" id="currentImage" alt="" width="60px" height="60px">
                        </div>
                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label" for="category-image">{{_trans('portfolio.Category')}} {{_trans('common.Image')}}</label>
                            <input class="form-control" type="file" name="edit_image" id="edit_image" />
                            <span class="text-danger editImageError error"></span>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">{{_trans('common.Description')}}</label>
                            <textarea name="edit_description" class="form-control" id="edit_description" cols="30" rows="10"></textarea>
                            <span class="text-danger editDescriptionError error"></span>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('common.Select')}} {{_trans('portfolio.Category')}} {{_trans('portfolio.Status')}}</label>
                            <select id="edit_status" name="edit_status" class="select2 form-select"
                                data-placeholder="Select category status">
                                <option value="1">{{_trans('common.Active')}}</option>
                                <option value="0">{{_trans('common.Deacive')}}</option>
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
                    url  : '{{ route('admin.category.index') }}',
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
                        name: 'description'
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
                    searchPlaceholder: "Search Category",
                },
                // Button for offcanvas
                buttons: [
                    @if(hasPermission('category_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">{{_trans('common.Add')}} {{_trans('portfolio.Category')}}</span>',
                        className: "add-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "offcanvas",
                            "data-bs-target": "#offcanvasEcommerceCategoryList",
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
                let description = $("#category-descripton").val();
                let status = $("#category-status option:selected").val();
                let parenet_category_id = $("#parenet_category_id option:selected").val();
                var image = $('#category-image').prop('files')[0] ?? '';

                formData.append('name', name);
                formData.append('description', description);
                formData.append('status', status);
                formData.append('image', image);
                formData.append('parenet_category_id', parenet_category_id);
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('admin.category.store') }}',
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
                            $('.errorParenet_category_id').text(response.errors
                                ?.parenet_category_id ? response.errors
                                ?.parenet_category_id[0] : '');
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
                            table.ajax.reload(null, false)

                            $("input[name=name]").val('');
                            $("#category-descripton").val('');
                            $('#category-image').val('');

                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });


            $(document).on("click", ".category_edit_button", function() {
                $id = $(this).attr("data-id");
                $('#edit_parenet_category_id').find('option:selected').attr("selected", false);
                $('#edit_status').find('option:selected').attr("selected", false);
                $('#edit_parenet_category_id').trigger('change.select2');
                $('#edit_status').trigger('change.select2');
                $.ajax({
                    url: '/admin/category/' + $id,
                    type: 'GET',
                    success: function(response) {
                        $('#category_id').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                        $('#edit_description').val(response.data.description);
                        $('#edit_status').find('option[value="' + response.data.active_status +
                            '"]').attr("selected", "selected");
                        $('#edit_parenet_category_id').find('option[value="' + response.data
                            .parent_id +
                            '"]').attr("selected", "selected");

                        $("#currentImage").attr("src", ``);

                        if (response.data.image != null) {
                            $("#currentImage").attr("src", `/storage/${response.data.image}`);
                        }

                        $('#edit_status').trigger('change.select2');
                        $('#edit_parenet_category_id').trigger('change.select2');

                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });


            $('#updateCategoryModal').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData();

                let category_id = $('#category_id').val();
                let name = $("input[name=edit_name]").val();
                let description = $("#edit_description").val();
                let status = $("#edit_status option:selected").val();
                let parenet_category_id = $("#edit_parenet_category_id option:selected").val();
                var image = $('#edit_image').prop('files')[0] ?? '';

                formData.append('name', name);
                formData.append('description', description);
                formData.append('parenet_category_id', parenet_category_id);
                formData.append('status', status);
                formData.append('image', image);
                formData.append('category_id', category_id);
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('admin.category.update') }}',
                    type: 'POST',
                    contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status == 403) {
                            table.ajax.reload(null, false)
                            $('.editNameError').text(response.errors?.name ? response.errors
                                ?.name[0] : '');
                            $('.ErrorParenet_category_id').text(response.errors
                                ?.parenet_category_id ? response.errors
                                ?.parenet_category_id[0] : '');
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


            $(document).on("click", ".category_delete_button", function() {

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
                            url: '{{ route('admin.category.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                category_id: id,
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

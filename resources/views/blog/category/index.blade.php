@extends('layouts.master')

@section('title', $title ?? _trans('blog.Blog').' '._trans('portfolio.Category'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('blog.Blog').' '._trans('portfolio.Category'),['#'=>_trans('blog.Blog'),'category'=>_trans('portfolio.Category')]) !!}
        <div class="app-ecommerce-category">
            <!-- Blog Category List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 " style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{_trans('common.Status')}} :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '._trans('common.Status')}}</option>
                            <option value="1">{{_trans('common.Active')}}</option>
                            <option value="0">{{_trans('common.Deactive')}}</option>
                        </select>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="form-check-input"></th>
                            <th>{{_trans('common.Name')}}</th>
                            <th>{{_trans('common.Status')}}</th>
                            <th width="100px">{{_trans('common.Action
                            ')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Offcanvas to add new customer -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSectionCategoryList"
                 aria-labelledby="offcanvasEcommerceListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">{{_trans('common.Add').' '._trans('blog.Blog').' '._trans('portfolio.Category')}}</h5>
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
                                   placeholder="Enter Category Name" name="name" aria-label="Brand Name" />
                            <span class="text-danger nameError error"></span>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('common.Select').' '._trans('portfolio.Category').' '._trans('common.Status')}}</label>
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
                            <button type="reset" id="closeAddModal" class="btn bg-label-danger"
                                    data-bs-dismiss="offcanvas">{{_trans('common.Discard')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Offcanvas to edit category -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCategoryEditModal"
                 aria-labelledby="offcanvasEcommerceCategoryListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">{{_trans('common.Edit').' '._trans('blog.Blog').' '._trans('portfolio.Category')}}</h5>
                    <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                </div>
                <!-- Offcanvas Body -->
                <div class="offcanvas-body border-top">
                    <form class="pt-0" id="updateCategoryModal" method="POST">
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="edit_name">{{_trans('common.Name')}}</label>
                            <input type="text" class="form-control" id="edit_name"
                                   placeholder="Enter Blog Category Name" name="edit_name" aria-label="brand name" />
                            <input type="text" hidden value="" name="brand_id" id="special_sections_category_id">
                            <span class="text-danger editNameError error"></span>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('blog.Select brand status')}}</label>
                            <select id="edit_status" name="edit_status" class="select2 form-select"
                                    data-placeholder="Select category status">
                                <option value="1">{{_trans('common.Active')}}</option>
                                <option value="0">{{_trans('common.Inactive')}}</option>
                            </select>
                            <span class="text-danger editStatusError error"></span>
                        </div>
                        <!-- Submit and reset -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{_trans('common.Update')}}</button>
                            <button type="reset" id="closeUpdateModal" class="btn bg-label-danger"
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
                    url : '{{ route('blog.category.index') }}',
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
                        data: 'status',
                        name: 'status'
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
                    @if(hasPermission('blog_category_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Blog Category</span>',
                        className: "add-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "offcanvas",
                            "data-bs-target": "#offcanvasSectionCategoryList",
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
                let status = $("#brand-status option:selected").val();


                formData.append('name', name);
                formData.append('status', status);
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('blog.category.store') }}',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status === 403) {
                            $('.nameError').text(response.errors?.name ? response.errors
                                ?.name[0] : '');
                            $('.statusError').text(response.errors?.status ? response.errors
                                    ?.status[0] :
                                '');
                        } else if (response.status === 200) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $('#closeAddModal').click();
                            $("input[name=name]").val('');
                        }
                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });


            $(document).on("click", ".category_edit_button", function() {

                $id = $(this).attr("data-id");
                $('#edit_status').find('option:selected').attr("selected", false);
                $('#edit_status').trigger('change');
                $.ajax({
                    url: '/blog/category/' + $id,
                    type: 'GET',
                    success: function(response) {
                        $('#special_sections_category_id').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                        $("#edit_status").find('option').removeAttr("selected");
                        $('#edit_status').trigger('change.select2');
                        $('#edit_status').find('option[value="' + response.data.is_active +
                            '"]').attr("selected", "selected");

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

                let special_sections_category_id = $('#special_sections_category_id').val();
                let name = $("input[name=edit_name]").val();
                let status = $("#edit_status option:selected").val();


                formData.append('name', name);
                formData.append('status', status);
                formData.append('id', special_sections_category_id);
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('blog.category.update') }}',
                    type: 'POST',
                    // contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status === 403) {
                            $('.editNameError').text(response.errors?.name ? response.errors
                                ?.name[0] : '');
                            $('.editStatusError').text(response.errors?.status ? response.errors
                                    ?.status[0] :
                                '');
                        } else if (response.status === 200) {
                            toastr.success(response.message);
                            $('#closeUpdateModal').click();
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
                            url: '{{ route('blog.category.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
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

            $(document).on('change', '.changeStatus', function() {
                var checkbox = $(this);
                var isChecked = checkbox.prop('checked');
                var statusTextElem = checkbox.closest('.form-check').find('.statusText');
                var statusText = isChecked ? 'Active' : 'Inactive';
                var badgeClass = isChecked ? 'badge bg-label-success' : 'badge bg-label-danger';

                statusTextElem.removeClass().addClass(badgeClass).text(statusText);

                var formData = new FormData();
                formData.append('id', checkbox.data('id'));
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: '{{ route('blog.category.changeStatus') }}',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status === 200) {
                            toastr.success(response.message);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

        });
    </script>
@endpush

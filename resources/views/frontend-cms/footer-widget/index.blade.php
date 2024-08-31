@extends('layouts.master')

@section('title', $title ?? _trans('frontendCMS.Footer').' '._trans('frontendCMS.CMS'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('frontendCMS.Footer').' '._trans('frontendCMS.CMS'),['#'=>_trans('frontendCMS.Frontend').' '._trans('frontendCMS.CMS'),'widget'=>_trans('frontendCMS.Footer').' '._trans('frontendCMS.CMS')]) !!}
        <div class="app-ecommerce-category">
            <!-- Widget List Table -->
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
                            <th>{{_trans('common.Title')}}</th>
                            <th>{{_trans('common.Status')}}</th>
                            <th width="50px">{{_trans('common.Info')}}</th>
                            <th width="100px">{{_trans('common.Action')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Offcanvas to edit category -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCategoryEditModal"
                 aria-labelledby="offcanvasEcommerceCategoryListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">{{_trans('common.Edit').' '._trans('frontendCMS.Widget')}}</h5>
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
                                   placeholder="Enter Footer Widget Name" name="edit_name" aria-label="brand name" />
                            <input type="text" hidden value="" name="brand_id" id="special_sections_category_id">
                            <span class="text-danger editNameError error"></span>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">{{_trans('common.Select').' '._trans('common.Status')}}</label>
                            <select id="edit_status" name="edit_status" class="select2 form-select"
                                    data-placeholder="Select category status">
                                <option value="1">{{_trans('common.Active')}}</option>
                                <option value="0">{{_trans('common.Deactive')}}</option>
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
                    url : '{{ route('cms.footer-widget.index') }}',
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
                        data: 'title',
                        name: 'title'
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
                    '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"l>>' +
                    ">t" +
                    '<"row mx-2"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    ">",
                lengthMenu: [10, 20, 50, 70, 100], //for length of menu
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search Footer Widget",
                },
                // Button for offcanvas
                buttons: [ ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });

            $(document).on("click", ".category_edit_button", function() {

                $id = $(this).attr("data-id");
                $('#edit_status').find('option:selected').attr("selected", false);
                $('#edit_status').trigger('change');
                $.ajax({
                    url: '/cms/footer-widget/' + $id,
                    type: 'GET',
                    success: function(response) {
                        $('#special_sections_category_id').val(response.data.id);
                        $('#edit_name').val(response.data.title);
                        $("#edit_status").find('option').removeAttr("selected");
                        $('#edit_status').trigger('change.select2');
                        $('#edit_status').find('option[value="' + response.data.active_status +
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


                formData.append('title', name);
                formData.append('status', status);
                formData.append('id', special_sections_category_id);
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('cms.footer-widget.update') }}',
                    type: 'POST',
                    // contentType: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status === 403) {
                            $('.editNameError').text(response.errors?.title ? response.errors
                                ?.title[0] : '');
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

        });
    </script>
@endpush

@extends('layouts.master')

@section('title', $title ?? _trans('product.Attribute').' '. _trans('common.Value'))

@section('content')



    <div class="row">

        <div class="col-6">

            <h4 class="py-3 mb-2">{{ $attribute->name }} {{_trans('product.Attributes Value List')}}</h4>

            <div class="app-ecommerce-category">
                <!-- Category List Table -->
                <div class="card">
                    <div class="card-datatable table-responsive">
                        <table class="data-table table border-top">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th>{{_trans('common.Name')}}</th>
                                    <th>{{_trans('product.Additional Value')}}</th>
                                    <th width="100px">{{_trans('common.Action')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Offcanvas to edit category -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAttributeValueEditModal"
                    aria-labelledby="offcanvasEcommerceCategoryListLabel">
                    <!-- Offcanvas Header -->
                    <div class="offcanvas-header py-4">
                        <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">{{_trans('common.Edit').' '._trans('product.Attribute')}}</h5>
                        <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <!-- Offcanvas Body -->
                    <div class="offcanvas-body border-top">
                        <form class="pt-0" id="updateAttributeValueModal" method="POST">
                            <!-- Title -->
                            <div class="mb-3">
                                <div class="d-flex flex-row justify-content-between">
                                    <label class="form-label" for="edit_name">{{_trans('common.Name')}}</label>
                                    <div class="me-4 mb-1">
                                        <label class="switch-label">{{_trans('product.Is the value color?')}}</label>
                                        <label class="switch switch-success">
                                            <input type="checkbox" class="switch-input" name="check_color_edit" id="is_color_edit" />
                                            <span class="switch-toggle-slider is_color_edit">
                                                <span class="switch-on">
                                                    <i class="ti ti-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                    <i class="ti ti-x"></i>
                                                </span>
                                            </span>
                                        </label>

                                    </div>
                                </div>
                                <input type="text" class="form-control" id="edit_name" placeholder="Enter Attribute Name"
                                    name="edit_name" aria-label="attribute name" />
                                <input type="text" hidden value="" name="value_id" id="value_id">
                                <span class="text-danger editNameError error"></span>
                            </div>

                            <!-- Description -->
                            <div class="mb-3 d-none" id="color_edit_div">
                                <label class="form-label">{{_trans('product.Aditional Value')}}</label>
                                <input type="color" name="edit_aditional_value" placeholder="Aditional Value"
                                    class="form-control" id="edit_aditional_value" />
                                <span class="text-danger editAttributeValueError error"></span>
                            </div>
                            <!-- Status -->

                            <!-- Submit and reset -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{_trans('common.Update')}}</button>
                                <button type="reset" class="btn bg-label-danger"
                                    data-bs-dismiss="offcanvas">{{_trans('common.Update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-6">
            <h4 class="py-3 mb-2"> {{_trans('product.Add Value For').' '. $attribute->name .' '._trans('product.Attribute')}}</h4>
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" id="addModal">
                        <div class="mb-3">
                            <div class="d-flex flex-row justify-content-between">
                                <label class="form-label" for="basic-icon-default-fullname">{{_trans('common.Value').' '._trans('common.Name')}} </label>
                                <div class="me-4 mb-1">
                                    <label class="switch-label">{{_trans('product.Is the value color?')}}</label>
                                    <label class="switch switch-success">
                                        <input type="checkbox" class="switch-input" name="check_color" id="is_color" />
                                        <span class="switch-toggle-slider is_color">
                                            <span class="switch-on">
                                                <i class="ti ti-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        </span>
                                    </label>

                                </div>
                            </div>
                            <input type="text" class="form-control" name="attribute_id" id="attribute_id" hidden
                                value="{{ $attribute->id }}" />
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="example: Red, Cotton" aria-label="John Doe"
                                    aria-describedby="basic-icon-default-fullname2" />
                            </div>
                            <span class="text-danger nameError error"></span>
                        </div>
                        <div class="mb-3 d-none" id="aditional_value_div">
                            <label class="form-label" for="basic-icon-default-company">{{_trans('product.Aditional Value')}}</label>
                            <div class="input-group input-group-merge">

                                <input type="color" name="aditional_value" id="aditional_value"
                                    class="form-control form-control-color" placeholder="example: #004DH"
                                    aria-label="ACME Inc." value="#563d7c"
                                    aria-describedby="basic-icon-default-company2" />
                            </div>
                            <span class="text-danger aditional_valueError error"></span>
                        </div>

                        <button type="submit" class="btn btn-primary">{{_trans('common.Add')}}</button>
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
                ajax: '{{ route('attribute.value.index', request()->route()->parameters) }}',
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
                        data: 'value',
                        name: 'value'
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
                    searchPlaceholder: "Search value",
                },
                // Button for offcanvas
                buttons: [],
            });
            $('#addModal').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData();

                let name = $("input[name=name]").val();
                let aditional_value = $("#aditional_value").val();


                formData.append('name', name);
                formData.append('aditional_value', aditional_value);
                formData.append('check_color', $('#is_color').is(":checked"));
                formData.append('attribute_id', $("#attribute_id").val());
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('attribute.value.store') }}',
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
                            $('.aditional_valueError').text(response.errors?.description ?
                                response
                                .errors
                                ?.description[0] :
                                '');
                        } else if (response.status == 200) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false);
                            $("input[name=name]").val('');
                            $("#aditional_value").val('');
                        }
                    },
                    error: function(error) {
                        toastr.error(error.message);
                    }
                });
            });


            $(document).on("click", ".attribute_value_edit_button", function() {
                $id = $(this).attr("data-id");
                $.ajax({
                    url: '/attribute/value/' + $id,
                    type: 'GET',
                    success: function(response) {
                        $('#value_id').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                        if (response.data.value) {
                            if (!$('#is_color_edit').is(":checked")) {
                                $('.is_color_edit').click();
                            }
                            $('#color_edit_div').removeClass('d-none')
                            $('#edit_aditional_value').val(response.data.value);
                        } else {

                            if ($('#is_color_edit').is(":checked")) {
                                $('.is_color_edit').click();
                            }

                            $('#color_edit_div').addClass('d-none')
                            $('#edit_aditional_value').val(null);
                        }
                    },
                    error: function(error) {
                        toastr.error(error.message);
                    }
                });
            });


            $('#updateAttributeValueModal').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData();

                let value_id = $('#value_id').val();
                let name = $("input[name=edit_name]").val();
                let aditional_value = $("#edit_aditional_value").val();

                formData.append('name', name);
                formData.append('aditional_value', aditional_value);
                formData.append('check_color', $('#is_color_edit').is(":checked"));
                formData.append('value_id', value_id);
                formData.append('_token', "{{ csrf_token() }}");


                $('.error').text('');
                $.ajax({
                    url: '{{ route('attribute.value.update') }}',
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
                            $('.editAttributeValueError').text(response.errors
                                ?.aditional_value ?
                                response
                                .errors
                                ?.description[0] :
                                '');
                        } else if (response.status == 200) {
                            toastr.success(response.message);
                            table.ajax.reload(null, false)
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        toastr.error(error.responseJSON.message);
                    }
                });
            });

            $(document).on("click", ".attribute_value_delete_button", function() {

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
                            url: '{{ route('attribute.value.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                value_id: id,
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
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                                // handle the error case
                            }
                        });
                    }
                });
            });


            $('.is_color').on('click', function() {
                $('#aditional_value').val('');
                if ($('#is_color').is(":checked")) {

                    $('#aditional_value_div').addClass('d-none');
                } else {
                    $('#aditional_value_div').removeClass('d-none');
                }
            });

            $('.is_color_edit').on('click', function() {
                $('#edit_aditional_value').val('');
                if ($('#is_color_edit').is(":checked")) {

                    $('#color_edit_div').addClass('d-none');
                } else {
                    $('#color_edit_div').removeClass('d-none');
                }
            });


        });
    </script>
@endpush

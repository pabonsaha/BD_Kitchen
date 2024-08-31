@extends('layouts.master')

@section('title', $title ?? _trans('product.Manufacturer'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('product.Manufacturer') .' '. _trans('order.List'),['#'=>_trans('product.Product').' '._trans('product.Management'),'vendor'=>_trans('product.Manufacturer') .' '. _trans('order.List')]) !!}

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
                                <th>{{_trans('common.Address')}}</th>
                                <th>{{_trans('common.Mobile')}}</th>
                                <th>{{_trans('common.Status')}}</th>
                                <th>{{_trans('common.Action')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Offcanvas to add new customer -->
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">{{_trans('common.Add').' '. _trans('product.Manufacturer')}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="POST" id="addModalForm">
                            <div class="modal-body">
                                <div class="row mb-2">
                                    <div class="col mb-6">
                                        <label for="name" class="form-label">{{_trans('common.Name')}}</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="{{_trans('common.Enter').' '._trans('common.Name')}}" />
                                        <span class="text-danger nameError error"></span>
                                    </div>
                                    <div class="col mb-6">
                                        <label for="address" class="form-label">{{_trans('common.Address')}}</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            placeholder="{{_trans('common.Enter').' '._trans('common.Address')}}" />
                                        <span class="text-danger addressError error"></span>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col mb-4">
                                        <label for="city" class="form-label">{{_trans('common.City')}}</label>
                                        <input type="text" name="city" id="city" class="form-control"
                                            placeholder="{{_trans('product.Enter Name of City')}}" />
                                        <span class="text-danger cityError error"></span>
                                    </div>
                                    <div class="col mb-4">
                                        <label for="state" class="form-label">{{_trans('common.State')}}</label>
                                        <input type="text" name="state" id="state" class="form-control"
                                            placeholder="{{_trans('product.Enter Name of State')}}" />
                                        <span class="text-danger stateError error"></span>
                                    </div>
                                    <div class="col mb-4">
                                        <label for="postal_code" class="form-label">{{_trans('common.Postal Code')}}</label>
                                        <input type="text" name="postal_code" id="postal_code" class="form-control"
                                            placeholder="{{_trans('product.Enter Name of Postal Code')}}" />
                                        <span class="text-danger postal_codeError error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-4">
                                        <label for="mobile" class="form-label">{{_trans('common.Mobile')}}</label>
                                        <input type="text" name="mobile" id="mobile" class="form-control"
                                            placeholder="+89151421" />
                                        <span class="text-danger mobileError error"></span>
                                    </div>
                                    <div class="col mb-4">
                                        <label for="phone" class="form-label">{{_trans('common.Phone')}}</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            placeholder="25014" />
                                        <span class="text-danger phoneError error"></span>
                                    </div>
                                    <div class="col mb-4">
                                        <label for="status" class="form-label">{{_trans('common.Status')}}</label>
                                        <select id="status" name="status" class="select2 form-select"
                                            data-placeholder="{{_trans('common.Select') }} {{_trans('common.Status')}}">
                                            <option value="1" selected>{{_trans('common.Active') }}</option>
                                            <option value="0">{{_trans('common.Deactive') }}</option>
                                        </select>
                                        <span class="text-danger postal_codeError error"></span>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col mb-6">
                                        <label for="name" class="form-label">{{_trans('product.Manufacturer').' '. _trans('common.Website')}}</label>
                                        <input type="text" id="vendor_website" name="vendor_website"
                                            class="form-control" placeholder="{{_trans('product.Enter Website URL')}}" />
                                        <span class="text-danger vendor_websiteError error"></span>
                                    </div>
                                    <div class="col mb-6">
                                        <label for="address" class="form-label">{{_trans('common.Contact Name')}}</label>
                                        <input type="text" name="contact_name" id="contact_name" class="form-control"
                                            placeholder="{{_trans('common.Enter Contact Name')}}" />
                                        <span class="text-danger contact_nameError error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-12">
                                        <label for="description" class="form-label">{{_trans('common.Description')}}</label>

                                        <textarea type="text" name="description" id="description" class="form-control" placeholder="{{_trans('common.Enter Description')}}"
                                            cols="30" rows="5"></textarea>
                                        <span class="text-danger descriptionError error"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="closeAddModal" class="btn btn-label-secondary"
                                        data-bs-dismiss="modal">{{_trans('common.Close')}}</button>
                                    <button type="submit" class="btn btn-primary">{{_trans('common.Save')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalCenterEdit" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">{{_trans('common.Edit').' '. _trans('product.Manufacturer')}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="" method="POST" id="editModalForm">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-6">
                                        <input type="text" id="vendor_id" name="vendor_id" hidden>
                                        <label for="name" class="form-label">{{_trans('common.Name')}}</label>
                                        <input type="text" id="editName" name="editName" class="form-control"
                                            placeholder="Enter Name" />
                                        <span class="text-danger editNameError error"></span>
                                    </div>
                                    <div class="col mb-6">
                                        <label for="editAddress" class="form-label">{{_trans('common.Address')}}</label>
                                        <input type="text" name="editAddress" id="editAddress" class="form-control"
                                            placeholder="{{_trans('common.Enter').' '._trans('common.Address')}}" />
                                        <span class="text-danger editAddressError error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col mb-4">
                                        <label for="editCity" class="form-label">{{_trans('common.City')}}</label>
                                        <input type="text" name="editCity" id="editCity" class="form-control"
                                            placeholder="{{_trans('product.Enter Name of City')}}" />
                                        <span class="text-danger editCityError error"></span>
                                    </div>
                                    <div class="col mb-4">
                                        <label for="editState" class="form-label">{{_trans('common.State')}}</label>
                                        <input type="text" name="editState" id="editState" class="form-control"
                                            placeholder="{{_trans('product.Enter Name of State')}}" />
                                        <span class="text-danger editStateError error"></span>
                                    </div>
                                    <div class="col mb-4">
                                        <label for="editPostal_code" class="form-label">{{_trans('common.Postal Code')}}</label>
                                        <input type="text" name="editPostal_code" id="editPostal_code"
                                            class="form-control" placeholder="{{_trans('product.Enter Name of Postal Code')}}" />
                                        <span class="text-danger editPostal_codeError error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-4">
                                        <label for="editMobile" class="form-label">{{_trans('common.Mobile')}}</label>
                                        <input type="text" name="editMobile" id="editMobile" class="form-control"
                                            placeholder="+89151421" />
                                        <span class="text-danger editMobileError error"></span>
                                    </div>
                                    <div class="col mb-4">
                                        <label for="editPhone" class="form-label">{{_trans('common.Phone')}}</label>
                                        <input type="text" name="editPhone" id="editPhone" class="form-control"
                                            placeholder="25014" />
                                        <span class="text-danger editPhoneError error"></span>
                                    </div>
                                    <div class="col mb-4">
                                        <label for="edit_status" class="form-label">{{_trans('common.Status')}}</label>
                                        <select id="edit_status" name="edit_status" class="select2 form-select"
                                            data-placeholder="{{_trans('common.Select') }} {{_trans('common.Status')}}">
                                            <option value="1">{{_trans('common.Active') }}</option>
                                            <option value="0">{{_trans('common.Deactive') }}</option>
                                        </select>
                                        <span class="text-danger postal_codeError error"></span>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col mb-6">
                                        <label for="name" class="form-label">{{_trans('product.Manufacturer').' '. _trans('common.Website')}}</label>
                                        <input type="text" id="editvendor_website" name="editvendor_website"
                                            class="form-control" placeholder="{{_trans('product.Enter Website URL')}}" />
                                        <span class="text-danger editvendor_websiteError error"></span>
                                    </div>
                                    <div class="col mb-6">
                                        <label for="address" class="form-label">{{_trans('common.Contact Name')}}</label>
                                        <input type="text" name="editcontact_name" id="editcontact_name"
                                            class="form-control" placeholder="{{_trans('common.Enter Contact Name')}}" />
                                        <span class="text-danger editcontact_nameError error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-12">
                                        <label for="editDescription" class="form-label">{{_trans('common.Description')}}</label>

                                        <textarea type="text" name="editDescription" id="editDescription" class="form-control"
                                            placeholder="{{_trans('common.Enter Description')}}" cols="30" rows="5"></textarea>
                                        <span class="text-danger editDescriptionError error"></span>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" id="closeEditModal" class="btn btn-label-secondary"
                                        data-bs-dismiss="modal">{{_trans('common.Close')}}</button>
                                    <button type="submit" class="btn btn-primary">{{_trans('common.Save')}}</button>
                                </div>
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
                        url : '{{ route('vendor.index') }}',
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
                            data: 'address',
                            name: 'address'
                        },
                        {
                            data: 'mobile',
                            name: 'mobile'
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
                        searchPlaceholder: "Search Manufacturer",
                    },
                    // Button for offcanvas
                    buttons: [

                        @if(hasPermission('manufacturer_create'))
                        {
                            text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">{{_trans('common.Add').' '._trans('product.Manufacturer')}}</span>',
                            className: "add-new btn btn-primary ms-2 waves-effect waves-light",
                            attr: {
                                "data-bs-toggle": "modal",
                                "data-bs-target": "#modalCenter",
                            },
                        },
                        @endif
                    ],
                });

                $('.filter_dropdown').change(function () {
                    table.draw();
                });

                $('#addModalForm').on('submit', function(e) {
                    e.preventDefault();

                    $('.error').text('');
                    $.ajax({
                        url: '{{ route('vendor.store') }}',
                        type: 'POST',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            name: $("#name").val(),
                            address: $('#address').val(),
                            description: $("#description").val(),
                            city: $('#city').val(),
                            state: $('#state').val(),
                            postal_code: $('#postal_code').val(),
                            mobile: $('#mobile').val(),
                            phone: $('#phone').val(),
                            vendor_website: $("#vendor_website").val(),
                            contact_name: $("#contact_name").val(),
                            status: $("#status option:selected").val(),
                        },
                        success: function(response) {
                            if (response.status == 403) {
                                $('.nameError').text(response.errors?.name ? response.errors
                                    ?.name[0] : '');
                                $('.addressError').text(response.errors
                                    ?.address ? response.errors
                                    ?.address[0] : '');
                                $('.descriptionError').text(response.errors?.description ? response
                                    .errors
                                    ?.description[0] : '');
                                $('.cityError').text(response.errors?.cityError ? response
                                    .errors
                                    ?.cityError[0] :
                                    '');
                                $('.stateError').text(response.errors?.state ? response
                                    .errors
                                    ?.state[0] :
                                    '');
                                $('.vendor_websiteError').text(response.errors?.vendor_website ?
                                    response
                                    .errors
                                    ?.vendor_website[0] :
                                    '');
                                $('.contact_nameError').text(response.errors?.contact_name ?
                                    response
                                    .errors
                                    ?.contact_name[0] :
                                    '');
                                $('.postal_codeError').text(response.errors?.postal_code ? response
                                    .errors
                                    ?.postal_code[0] :
                                    '');
                                $('.mobileError').text(response.errors?.mobile ? response
                                    .errors
                                    ?.mobile[0] :
                                    '');
                                $('.phoneError').text(response.errors?.phone ? response
                                    .errors
                                    ?.phone[0] :
                                    '');
                                $('.statusError').text(response.errors?.status ? response.errors
                                    ?.status[0] :
                                    '');
                            } else if (response.status == 200) {
                                toastr.success(response.message);
                                table.ajax.reload(null, false)
                                $('#closeAddModal').click();
                                $("#name").val('');
                                $('#address').val('');
                                $("#description").val('');
                                $('#city').val('');
                                $('#state').val('');
                                $('#postal_code').val('');
                                $('#mobile').val('');
                                $('#vendor_website').val('');
                                $('#contact_name').val('');
                                $('#phone').val('');

                            }
                        },
                        error: function(error) {
                            toastr.error(error.responseJSON.message);
                        }
                    });
                });


                $(document).on("click", ".vendor_edit_button", function() {
                    $id = $(this).attr("data-id");
                    $('#edit_status').find('option:selected').attr("selected", false);
                    $('#edit_status').trigger('change.select2');
                    $.ajax({
                        url: '/manufacturers/' + $id,
                        type: 'GET',
                        success: function(response) {
                            $('#vendor_id').val(response.data.id);
                            $("#editName").val(response.data.name);
                            $('#editAddress').val(response.data.address);
                            $("#editDescription").val(response.data.description);
                            $('#editCity').val(response.data.city);
                            $('#editState').val(response.data.state);
                            $('#editPostal_code').val(response.data.postal_code);
                            $('#editMobile').val(response.data.mobile);
                            $('#editPhone').val(response.data.phone);
                            $('#editvendor_website').val(response.data.website);
                            $('#editcontact_name').val(response.data.contact_name);
                            $('#edit_status').find('option[value="' + response.data.is_active +
                                '"]').attr("selected", "selected");

                            $('#edit_status').trigger('change.select2');

                        },
                        error: function(error) {
                            toastr.error(error.responseJSON.message);
                        }
                    });
                });


                $('#editModalForm').on('submit', function(e) {
                    e.preventDefault();

                    $('.error').text('');
                    $.ajax({
                        url: '{{ route('vendor.update') }}',
                        type: 'POST',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            name: $("#editName").val(),
                            vendor_id: $("#vendor_id").val(),
                            address: $('#editAddress').val(),
                            description: $("#editAddress").val(),
                            city: $('#editCity').val(),
                            state: $('#editState').val(),
                            postal_code: $('#editPostal_code').val(),
                            mobile: $('#editPhone').val(),
                            phone: $('#editPhone').val(),
                            vendor_website: $('#editvendor_website').val(),
                            contact_name: $('#editcontact_name').val(),
                            status: $("#edit_status option:selected").val(),
                        },
                        success: function(response) {
                            if (response.status == 403) {
                                $('.editNameError').text(response.errors?.name ? response.errors
                                    ?.name[0] : '');
                                $('.editAddressError').text(response.errors
                                    ?.address ? response.errors
                                    ?.address[0] : '');
                                $('.editDescriptionError').text(response.errors?.description ?
                                    response
                                    .errors
                                    ?.description[0] : '');
                                $('.editCityError').text(response.errors?.cityError ? response
                                    .errors
                                    ?.cityError[0] :
                                    '');
                                $('.editStateError').text(response.errors?.state ? response
                                    .errors
                                    ?.state[0] :
                                    '');
                                $('.editPostal_codeError').text(response.errors?.postal_code ?
                                    response
                                    .errors
                                    ?.postal_code[0] :
                                    '');
                                $('.editMobileError').text(response.errors?.mobile ? response
                                    .errors
                                    ?.mobile[0] :
                                    '');
                                $('.editPhoneError').text(response.errors?.phone ? response
                                    .errors
                                    ?.phone[0] :
                                    '');
                                $('.editvendor_websiteError').text(response.errors?.vendor_website ?
                                    response
                                    .errors
                                    ?.vendor_website[0] :
                                    '');
                                $('.editcontact_nameError').text(response.errors?.contact_name ?
                                    response
                                    .errors
                                    ?.contact_name[0] :
                                    '');
                                $('.postal_codeError').text(response.errors?.status ? response
                                    .errors
                                    ?.status[0] :
                                    '');
                            } else if (response.status == 200) {
                                toastr.success(response.message);
                                table.ajax.reload(null, false)
                                $('#closeEditModal').click();
                                $("#editAddress").val('');
                                $('#editDescription').val('');
                                $("#editCity").val('');
                                $('#editState').val('');
                                $('#editPostal_code').val('');
                                $('#editMobile').val('');
                                $('#editPhone').val('');
                                $('#editName').val('');
                                $('#editvendor_website').val('');
                                $('#editcontact_name').val('');
                                $('#vendor_id').val('');
                            }
                        },
                        error: function(error) {
                            toastr.error(error.responseJSON.message);
                        }
                    });
                });


                $(document).on("click", ".vendor_delete_button", function() {

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
                                url: '{{ route('vendor.destroy') }}',
                                method: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    vendor_id: id,
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

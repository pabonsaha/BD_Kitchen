@extends('layouts.master')

@section('title', $title ?? _trans('faq.FAQs'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('faq.FAQs'), ['#'=> 'Frontend CMS', '/cms/faq' => _trans('faq.FAQs'), 'faq' =>_trans('faq.FAQs').' '._trans('order.List')]) !!}
        <div class="app-ecommerce-category">
            <!-- FAQ List Table -->
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
                            <th>{{_trans('common.Description')}}</th>
                            <th>{{_trans('common.Status')}}</th>
                            <th>{{_trans('common.User')}}</th>
                            <th width="100px">{{_trans('common.Action')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addFaqModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" id="closeUpdateModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{_trans('common.Add').' '._trans('common.New').' '._trans('faq.FAQs')}}</h3>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">{{_trans('common.Title')}}</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter title"
                               tabindex="-1" required/>
                        <span class="text-danger titleError error"></span>

                    </div>

                    <!--Faq Description -->
                    <div class="mt-3">
                        <label>{{_trans('common.Description')}}</label>
                        <div class="form-control p-0 pt-1">
                            <div class="commonEditor-toolbar border-0 border-bottom">
                                <div class="d-flex justify-content-start">
                                    <span class="ql-formats me-0">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>
                                        <button class="ql-link"></button>
                                    </span>
                                </div>
                            </div>
                            <div class="commonEditor border-0 pb-4" id="description">
                            </div>
                        </div>
                        <span class="text-danger shippingPolicyError error"></span>
                    </div>

                    <!-- Status -->
                    <div class="mt-3 col ecommerce-select2-dropdown">
                        <label class="form-label mb-1" for="status-org">{{_trans('common.Status')}}</label>
                        <select id="status" name="status" class="select2 form-select">
                            <option value="1" selected>{{_trans('common.Active')}}</option>
                            <option value="0">{{_trans('common.Deactive')}}</option>
                        </select>
                    </div>


                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1" id="addFaq">{{_trans('common.Submit')}}</button>
                        <button id="reset" type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{_trans('common.Cancel')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Modal -->


    <!-- Edit Modal -->
    <div class="modal fade" id="editFaqModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{_trans('common.Edit').' '._trans('faq.FAQs')}}</h3>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">{{_trans('common.Title')}}</label>
                        <input type="text" id="editTitle" name="editTitle" class="form-control"
                               placeholder="Enter title"
                               tabindex="-1" required/>
                        <span class="text-danger titleError error"></span>
                    </div>

                    <input type="text" id="faq_id" name="faq_id" hidden>


                    <!--Faq Description -->
                    <div class="mt-3">
                        <label>{{_trans('common.Description')}}</label>
                        <div class="form-control p-0 pt-1">
                            <div class="commonEditor1-toolbar border-0 border-bottom">
                                <div class="d-flex justify-content-start">
                                    <span class="ql-formats me-0">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>
                                        <button class="ql-link"></button>
                                    </span>
                                </div>
                            </div>
                            <div class="commonEditor1 border-0 pb-4" id="editDescription">
                            </div>
                        </div>
                        <span class="text-danger shippingPolicyError error"></span>
                    </div>

                    <!-- Status -->
                    <div class="mt-3 col ecommerce-select2-dropdown">
                        <label class="form-label mb-1" for="status-org">{{_trans('common.Status')}}</label>
                        <select id="editStatus" name="editStatus" class="select2 form-select">
                            <option value="1">{{_trans('common.Active')}}</option>
                            <option value="0">{{_trans('common.Deactive')}}</option>
                        </select>
                    </div>


                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1" id="updateFaq">{{_trans('common.Submit')}}</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                            {{_trans('common.Cancel')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit Modal -->

@endsection

@push('scripts')
    <script>
        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{{ route('cms.faq.index') }}',
                    data: function (d){
                        d.status = $('#status').val()
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function (data, type, row) {
                            const truncated = data.length > 100 ? data.substr(0, 100) + '...' :
                                data;
                            return '<div style="width: 200px; white-space: normal; word-wrap: break-word;">' +
                                truncated + '</div>';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'user',
                        name: 'user'
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
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                    },
                }],
                order: [0, "desc"], //set any columns order asc/desc
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
                    searchPlaceholder: "Search FAQ",
                },
                // Button for offcanvas
                buttons: [
                    @if(hasPermission('faqs_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add FAQ</span>',
                        className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#addFaqModal",
                        },
                    },
                    @endif
                ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });

            $(document).ready(function () {
                $('#addFaq').click(function (e) {
                    e.preventDefault();
                    $('.error').text('')

                    var formData = new FormData();

                    let title = $("input[name=title]").val();
                    let status = $("#status option:selected").val();
                    let description = $("#description").children().first().html();

                    formData.append('title', title);
                    formData.append('description', description);
                    formData.append('status', status);
                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        url: '{{ route('cms.faq.store') }}',
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            if (response.status === 403) {
                                $('.titleError').text(response.errors?.title ? response.errors
                                    .title[0] : '');
                                $('.descError').text(response.errors?.short_desc ? response
                                    .errors.short_desc[0] : '');
                            } else if (response.status === 200) {
                                // Clear form fields
                                $("input[name=title]").val('');
                                $("#status").val('1').trigger('change'); // Reset status to "Active"
                                $("#description").children().first().html('');

                                toastr.success(response.message);
                                $('#closeUpdateModal').click();
                                table.ajax.reload(null, false);
                            }
                        },
                        error: function (error) {
                            toastr.error(error.responseJSON.message);
                        }
                    });
                });
            });

            $(document).ready(function (){
                $('#reset').click(function(e) {
                    e.preventDefault();
                    $("input[name=title]").val('');
                    $("#status option:selected").prop('selected', false);
                    $("#description").children().first().html('');
                });
            })

            $(document).on("click", ".category_edit_button", function () {
                $('.error').text('')
                $id = $(this).attr("data-id");
                $('#editStatus').val(null).trigger('change');
                $.ajax({
                    url: '/cms/faq/edit/' + $id,
                    type: 'GET',
                    success: function (response) {
                        $('#faq_id').val(response.data.id);
                        $("#editTitle").val(response.data.title);
                        $("#editDescription").html(response.data.description);
                        $('#editStatus').val(response.data.active_status).trigger('change');

                        reInitQuillEditor();

                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });

            $(document).ready(function () {
                $('#updateFaq').click(function (e) {
                    e.preventDefault();

                    var formData = new FormData();

                    let faq_id = $("input[name=faq_id]").val();
                    let title = $("input[name=editTitle]").val();
                    let status = $("#editStatus option:selected").val();
                    let description = $("#editDescription").children().first().html();

                    formData.append('id', faq_id);
                    formData.append('title', title);
                    formData.append('description', description);
                    formData.append('status', status);
                    formData.append('_token', "{{ csrf_token() }}");

                    $('.error').text('')
                    $.ajax({
                        url: '{{ route('cms.faq.update') }}',
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            if (response.status === 403) {
                                $('.titleError').text(response.errors?.title ? response.errors
                                    .title[0] : '');
                                $('.descError').text(response.errors?.short_desc ? response
                                    .errors.short_desc[0] : '');
                            } else if (response.status === 200) {
                                toastr.success(response.message);
                                $('#closeModal').click();
                                table.ajax.reload(null, false);
                            }
                        },
                        error: function (error) {
                            toastr.error(error.responseJSON.message);
                        }
                    });
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
                            url: '{{ route('cms.faq.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                            },
                            success: function(response) {
                                console.log(response)
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

        function reInitQuillEditor() {

            const commonEditor1 = document.querySelector('.commonEditor1');
            if (commonEditor1) {
                new Quill(commonEditor1, {
                    modules: {
                        toolbar: '.commonEditor1-toolbar'
                    },
                    placeholder: 'Description',
                    theme: 'snow'
                });
            }
        }
    </script>
@endpush

@extends('layouts.master')

@section('title', $title ?? _trans('designer.Designer').' '._trans('designer.Contact'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('designer.Designer').' '._trans('designer.Contact'), [_trans('designer.Designer').' '._trans('designer.Contact') => _trans('designer.Designer').' '._trans('designer.Contact')]) !!}
        <div class="app-ecommerce-category">
            <!-- Designer Contact List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 " style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{_trans('order.Order').' '._trans('common.Status')}}:</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value=""> {{_trans('common.Select').' '._trans('common.Status')}}</option>
                            <option value="0">{{_trans('common.Pending')}}</option>
                            <option value="1">{{_trans('contact.Replied')}}</option>
                        </select>
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-check-input"></th>
                                <th>{{_trans('designer.Designer').' '._trans('common.Info')}}</th>
                                <th>{{_trans('contact.Name')}}</th>
                                <th>{{_trans('contact.Email')}}</th>
                                <th>{{_trans('common.Phone')}}</th>
                                <th>{{_trans('contact.Message')}}</th>
                                <th>{{_trans('contact.Status')}}</th>
                                <th width="100px">{{_trans('contact.Action')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--    Send Reply Modal--}}
    <div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" id="closeModal"
                        aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{_trans('contact.Send Reply')}}</h3>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">{{_trans('common.Subject')}}</label>
                        <input type="text" id="subject" name="subject" class="form-control"
                               placeholder="subject" tabindex="-1" required/>
                        <span class="text-danger subjectError error"></span>
                    </div>

                    <div class="col-12 mb-2">
                        <label class="form-label">{{_trans('contact.To Email')}}</label>
                        <input type="email" id="to_email" name="to_email" class="form-control"
                               tabindex="-1" required readonly/>
                    </div>

                    <!-- Message Body -->
                    <div class="row card-body">
                        <div>
                            <label class="form-label">{{_trans('common.Message')}}</label>
                            <div class="form-control p-0 pt-1">
                                <div class="commonEditor-toolbar border-0 border-bottom">
                                    <div class="d-flex justify-content-start">
                                            <span class="ql-formats">
                                                <select class="ql-font"></select>
                                                <select class="ql-size"></select>
                                            </span>
                                        <span class="ql-formats me-0">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>

                                                <button class="ql-strike"></button>
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                                <button class="ql-link"></button>
                                            </span>

                                        <span class="ql-formats">
                                                <button class="ql-header" value="1"></button>
                                                <button class="ql-header" value="2"></button>
                                                <button class="ql-blockquote"></button>
                                                <button class="ql-code-block"></button>
                                        </span>
                                    </div>
                                </div>
                                <div id="message" class="commonEditor border-0 pb-4">

                                </div>
                            </div>
                            <span class="text-danger descriptionError error"></span>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-2">
                        <button id="sendReply" type="submit" class="btn btn-primary me-sm-3 me-1">{{_trans('common.Send')}}</button>
                        <button id="reset" type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{_trans('common.Cancel')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Send Reply Modal-->


@endsection

@push('scripts')
    <script>
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{{ route('designer-contact.index') }}',
                    data: function (d){
                        d.status = $('#status').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable: false
                    },
                    {
                        data: 'designer_name',
                        name: 'designer_name'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'message',
                        name: 'message',
                        render: function(data, type, row) {
                            const truncated = data.length > 100 ? data.substr(0, 100) + '...' :
                                data;
                            return '<div data-bs-toggle="tooltip" data-bs-placement="right" title="' +
                                data +
                                '" style="width: 220px; white-space: normal; word-wrap: break-word;">' +
                                truncated + '</div>';
                        }
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
                order: [0, "desc"], //set any columns order asc/desc
                "fnDrawCallback": function() {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                },
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
                    searchPlaceholder: "Search Designer Contact",
                },
                buttons: [],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });

            $(document).on("click", ".delete_button", function() {
                const id = $(this).data('id');

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
                            url: '{{ route('designer-contact.delete') }}',
                            method: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                            },
                            success: function(response) {
                                table.ajax.reload(null, false)
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.text,
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect waves-light'
                                    }
                                });
                            },
                            error: function(error) {
                                console.log(error.responseJSON.message);
                            }
                        });
                    }
                });


            });


            $(document).on("click", ".reply_button", function () {
                $('.error').text('')
                const id = $(this).attr("data-id");
                $.ajax({
                    url: '/designer-contact/' + id,
                    type: 'GET',
                    success: function (response) {
                        $('#to_email').val(response.data.email);
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });


            $(document).ready(function () {
                $('#sendReply').click(function (e) {
                    e.preventDefault();

                    var formData = new FormData();

                    let subject = $("input[name=subject]").val();
                    let to_email = $("input[name=to_email]").val();
                    let message = $("#message").children().first().html();

                    formData.append('subject', subject);
                    formData.append('to_email', to_email);
                    formData.append('message', message);
                    formData.append('_token', "{{ csrf_token() }}");

                    $('.error').text('')
                    $.ajax({
                        url: '{{ route('designer-contact.sendReply') }}',
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            if (response.status === 403) {
                                $('.subjectError').text(response.errors?.subject ? response.errors
                                    .subject[0] : '');
                                $('.messageError').text(response.errors?.message ? response
                                    .errors.message[0] : '');
                            } else if (response.status === 200) {
                                toastr.success(response.message);
                                $('#closeModal').click();

                                $("input[name=subject]").val('');

                                $("#message").children().first().html('');
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
                    $("input[name=subject]").val('');
                    $("#message").children().first().html('');
                });
            })


        });
    </script>
@endpush

@extends('layouts.master')

@section('title', $title ?? _trans('notice.Notice Board'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('notice.Notice Board'), [
            '#' => _trans('notice.Notice Board'),
            'emailcampaign' => _trans('notice.Notice Board'),
        ]) !!}
        <div class="app-ecommerce-category">
            <!-- Email Notice List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 "
                    style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{ _trans('common.Status') }} :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{ _trans('common.Select') . ' ' . _trans('common.Status') }}</option>
                            <option value="1">{{ _trans('common.Published') }}</option>
                            <option value="0">{{ _trans('common.Unpublished') }}</option>
                        </select>
                    </div>

                </div>
                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-check-input"></th>
                                <th>{{ _trans('common.Title') }}</th>
                                <th>{{ _trans('common.Type') }}</th>
                                <th>{{ _trans('common.Description') }}</th>
                                <th>{{ _trans('marketing.Attachment') }}</th>
                                <th>{{ _trans('common.Publish Status') }}</th>
                                <th>{{ _trans('notice.Published time') }}</th>
                                <th width="50px">{{ _trans('common.Author') }}</th>
                                <th width="100px">{{ _trans('common.Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Notice Modal -->
    <div class="modal fade" id="createNoticeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" id="closeModal"
                    aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">
                            {{ _trans('common.Create') . ' ' . _trans('common.Notice') }}</h3>
                    </div>
                    <form id="createForm">
                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Title') }}</label>
                            <input type="text" id="title" name="title" class="form-control"
                                placeholder="Enter title" />
                            <span class="text-danger titleError error"></span>
                        </div>

                        <div class="mb-2 ecommerce-select2-dropdown">
                            <label class="form-label">{{ _trans('common.Select') . ' ' . _trans('common.Type') }} <span
                                    class="text-danger">*</span></label>
                            <select id="notice_type" name="notice_type" class="select2 form-select"
                                data-placeholder="Select type">
                                <option value="">{{ _trans('common.Select Type') }}</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger typeError error"></span>
                        </div>

                        <div>
                            <label for="formFileLg" class="form-label">{{ _trans('marketing.Attachment') }}</label>
                            <input class="form-control form-control mb-2" id="formFileLg" name="attachment" type="file">
                            <span class="text-danger attachmentError error"></span>
                        </div>

                        <div class="row card-body">
                            <div class="col-12 mb-2">
                                <label class="form-label">{{ _trans('common.Description') }}</label>
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
                                    <div class="commonEditor1 border-0 pb-4" id="createMessageEditor"></div>
                                </div>
                                <span class="text-danger messageError error"></span>
                            </div>

                        </div>
                        <div class="col-12 text-center mt-2">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">{{ _trans('common.Add') }}</button>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">{{ _trans('common.Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Create Notice Modal -->


    <!-- Edit Notice Modal -->
    <div class="modal fade" id="editNoticeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">
                            {{ _trans('common.Edit') . ' ' . _trans('notice.Notice') }}</h3>
                    </div>
                    <input type="hidden" id="editId" name="id">
                    <div class="col-12 mb-3">
                        <label class="form-label">{{ _trans('common.Title') }}</label>
                        <input type="text" id="editTitle" name="title" class="form-control"
                            placeholder="Enter title" />
                        <span class="text-danger editTitleError error"></span>
                    </div>

                    {{-- Expense Type --}}
                    <div class="mb-2 ecommerce-select2-dropdown">
                        <label class="form-label">{{ _trans('common.Select') . ' ' . _trans('common.Type') }} <span
                                class="text-danger">*</span></label>
                        <select id="editExpenseType" name="expense_type" class="select2 form-select"
                            data-placeholder="Select type" required>
                            <option value="">{{ _trans('common.Select Type') }}</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger editTypeError error"></span>
                    </div>
                    {{-- Expense Type --}}

                    <div class="row mb-2">
                        <div class="col-md-8">
                            <label for="editFormFileLg" class="form-label">{{ _trans('marketing.Attachment') }}</label>
                            <input class="form-control form-control mb-2" id="editFormFileLg" name="attachment"
                                type="file">
                            <span class="text-danger editAttachmentError error"></span>

                        </div>
                        <div class="col-md-4">
                            <div id="currentAttachmentSection"></div>
                        </div>
                    </div>


                    <div class="row card-body">
                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Description') }}</label>
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
                                <div class="commonEditor border-0 pb-4" id="editMessageEditor"></div>
                            </div>
                            <span class="text-danger messageError error"></span>
                        </div>

                    </div>


                    <div class="col-12 text-center mt-2">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1"
                            id="noticeUpdate">{{ _trans('common.Update') }}</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">{{ _trans('common.Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Notice Modal -->

@endsection

@push('scripts')
    <script>
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('notice-board.notice.index') }}',
                    data: function(d) {
                        d.status = $('#status').val()

                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'type',
                        name: 'type_id'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data, type, row) {
                            const tempElement = document.createElement('div');
                            tempElement.innerHTML = data;
                            const plainText = tempElement.textContent || tempElement.innerText ||
                                '';
                            const truncated = plainText.length > 100 ? plainText.substr(0, 100) +
                                '...' : plainText;
                            return '<div style="width: 200px; white-space: normal; word-wrap: break-word;">' +
                                truncated + '</div>';
                        }
                    },
                    {
                        data: 'attachment',
                        name: 'attachment',

                    },

                    {
                        data: 'status',
                        name: 'active_status'
                    },
                    {
                        data: 'published_at',
                        name: 'published_at'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
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
                }, ],

                order: [
                    [0, 'desc']
                ],
                dom: '<"card-header d-flex flex-wrap pb-2"' +
                    "<f>" +
                    '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"lB>>' +
                    ">t" +
                    '<"row mx-2"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    ">",
                lengthMenu: [10, 20, 50, 70, 100],
                language: {
                    sLengthMenu: "_MENU_",
                    search: "",
                    searchPlaceholder: "Search Notice",
                },
                buttons: [{
                    text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Notice</span>',
                    className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                    action: function() {
                        $('#createNoticeModal').modal('show');
                    }
                }],
            });

            $('.filter_dropdown').change(function() {
                table.draw();
            });

            function resetCreateModal() {
                $('#createForm').trigger('reset');
                $('.titleError').text('');
                $('.messageError').text('');
                $("#createMessageEditor").children().first().html('');
                $('#formFileLg').val('');
                $('.error').text('');
                $('#notice_type').val(null).trigger('change');
            }

            // Open Create notice modal
            $('.create-new').click(function() {
                resetCreateModal();
                $('#createNoticeModal').modal('show');
            });

            // Submit form to create new notice
            $('#createForm').submit(function(event) {
                event.preventDefault();

                $('.error').text('');
                let description = $("#createMessageEditor").children().first().html();

                var formData = new FormData();
                formData.append('title', $('#title').val());
                formData.append('description', description);
                formData.append('notice_type', $('#notice_type').val());
                formData.append('_token', "{{ csrf_token() }}");

                if ($('#formFileLg')[0].files.length > 0) {
                    formData.append('attachment', $('#formFileLg')[0].files[0]);
                }



                $.ajax({
                    url: '{{ route('notice-board.notice.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 403) {
                            $('.titleError').text(response.errors?.title ? response.errors
                                .title[0] : '');

                            $('.attachmentError').text(response.errors?.attachment ? response
                                .errors
                                .attachment[0] : '');

                            $('.messageError').text(response.errors?.description ? response
                                .errors
                                .description[0] : '');
                            $('.typeError').text(response.errors?.notice_type ? response
                                .errors
                                .notice_type[0] : '');

                        } else if (response.status === 200) {
                            $('#createNoticeModal').modal('hide');
                            table.ajax.reload(null, false);
                            toastr.success(response.message);
                        }
                    },
                });
            });

            // Edit campaign modal handler
            $(document).on('click', '.edit-notice', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '/notice-board/notice/' + id + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editId').val(response.id);
                        $('#editTitle').val(response.title);
                        $('#editMessageEditor').html(response.description);
                        $('#editExpenseType').val(response.notice_type).trigger('change');

                        if (response.attachment) {
                            $('#currentAttachmentSection').html(
                                `<label class="form-label">Current Attachment</label>
                            <div class="mb-2">
                                ${response.attachment}
                            </div>`
                            );
                        } else {
                            $('#currentAttachmentSection').html('');
                        }
                        reInitQuillEditor();
                        $('#editNoticeModal').modal('show');

                    },
                    error: function(error) {
                        console.error('Error fetching campaign data:', error);
                        toastr.error('Failed to fetch campaign data.');
                    }
                });
            });


            $(document).ready(function() {
                // Submit form to edit notice
                $('#noticeUpdate').click(function(e) {
                    e.preventDefault();

                    var formData = new FormData();

                    let notice_id = $('#editId').val();

                    let title = $('#editTitle').val();
                    let description = $('#editMessageEditor').children().first().html();
                    let notice_type = $('#editExpenseType').val();
                    let attachment = $('#editFormFileLg')[0].files[0];

                    formData.append('id', notice_id);
                    formData.append('title', title);
                    formData.append('description', description);
                    formData.append('notice_type', notice_type);

                    if (attachment) {
                        formData.append('attachment', attachment);
                    }
                    formData.append('_token', "{{ csrf_token() }}");


                    $.ajax({
                        url: '/notice-board/notice/update',
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status === 403) {
                                $('.editTitleError').text(response.errors?.title ?
                                    response.errors
                                    .title[0] : '');
                                $('.editAttachmentError').text(response.errors
                                    ?.attachment ? response.errors
                                    .attachment[0] : '');
                            } else if (response.status === 200) {
                                $('#editNoticeModal').modal('hide');
                                table.ajax.reload(null, false);
                                toastr.success(response.message);
                            }
                        },
                        error: function(error) {
                            console.error('Error updating notice:', error);
                            toastr.error(
                                'Failed to update notice. Please try again later.'
                            );
                        }
                    });
                });
            });

            // delete Notice
            $(document).on("click", ".delete-notice", function() {
                let id = $(this).data("id");
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
                            url: '{{ route('notice-board.notice.destroy') }}',
                            method: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                            },
                            success: function(response) {
                                table.ajax.reload(null, false);
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
                                toastr.error(error.responseJSON.message);
                            }
                        });
                    }
                });
            });


            $(document).on('change', '.changeStatus', function() {
                var checkbox = $(this);
                var isChecked = checkbox.prop('checked');
                var noticeId = checkbox.data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: isChecked ? "Do you want to publish the notice?" :
                        "Do you want to unpublish the notice?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: isChecked ? 'Yes, publish it!' : 'Yes, unpublish it!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('id', noticeId);
                        formData.append('_token', "{{ csrf_token() }}");

                        $.ajax({
                            url: '{{ route('notice-board.notice.changeStatus') }}',
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                    var statusTextElem = checkbox.closest('.form-check')
                                        .find('.statusText');
                                    var statusText = isChecked ? 'Active' : 'Inactive';
                                    var badgeClass = isChecked ?
                                        'badge bg-label-success' :
                                        'badge bg-label-danger';

                                    statusTextElem.removeClass().addClass(badgeClass)
                                        .text(statusText);
                                } else if (response.status === 400) {
                                    toastr.error(response.message);
                                    checkbox.prop('checked', !
                                        isChecked);
                                }
                            },
                            error: function(error) {
                                console.error(error);
                                toastr.error('Failed to update status.');
                            }
                        });
                    } else {
                        checkbox.prop('checked', !isChecked);
                    }
                });
            });


        });

        function reInitQuillEditor() {

            const commonEditor = document.querySelector('.commonEditor');
            if (commonEditor) {
                new Quill(commonEditor, {
                    modules: {
                        toolbar: '.commonEditor-toolbar'
                    },
                    placeholder: 'Description',
                    theme: 'snow'
                });
            }
        }
    </script>
@endpush

@extends('layouts.master')

@section('title', $title ?? _trans('expense.Expenses'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('expense.Expenses'), [
            '#' => _trans('expense.Expense') . ' ' . _trans('expense.Management'),
            'emailcampaign' => _trans('expense.Expenses'),
        ]) !!}
        <div class="app-ecommerce-category">
            <!-- Email Campaign List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 "
                    style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>{{ _trans('common.Status') }} :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{ _trans('common.Select') . ' ' . _trans('common.Status') }}</option>
                            <option value="1">{{ _trans('common.Active') }}</option>
                            <option value="0">{{ _trans('common.Deactive') }}</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-3 position-absolute ps-4 p-2 "
                    style="z-index: 100; margin-top: 10px; margin-left: 450px">
                    <div class="form-group">
                        <label><strong>{{ _trans('common.Type') }} :</strong></label>
                        <select id='type' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{ _trans('common.Select') . ' ' . _trans('common.Type') }}</option>
                            @foreach ($expenseTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
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
                                <th>{{ _trans('marketing.Expense Date') }}</th>
                                <th>{{ _trans('common.Amount') }}</th>
                                <th>{{ _trans('expense.Voucher') }}</th>
                                <th>{{ _trans('common.Details') }}</th>
                                <th>{{ _trans('common.Status') }}</th>
                                <th width="50px">{{ _trans('common.Author') }}</th>
                                <th width="100px">{{ _trans('common.Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Expense Modal -->
    <div class="modal fade" id="createExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" id="closeModal"
                    aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{ _trans('common.Create') . ' ' . _trans('expense.Expense') }}</h3>
                    </div>
                    <form id="createForm">

                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Title') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control"
                                placeholder="Enter title" required />
                            <span class="text-danger titleError error"></span>
                        </div>

                        {{-- Expense Type --}}
                        <div class="mb-2 ecommerce-select2-dropdown">
                            <label class="form-label">{{ _trans('common.Select') . ' ' . _trans('common.Type') }} <span
                                    class="text-danger">*</span></label>
                            <select id="expense_type" name="expense_type" class="select2 form-select"
                                data-placeholder="Select type" required>
                                <option value="">{{ _trans('common.Select Type') }}</option>
                                @foreach ($expenseTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger typeError error"></span>
                        </div>
                        {{-- Expense Type --}}


                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Amount') }} <span
                                    class="text-danger">*</span></label>
                            <input type="number" id="amount" name="amount" class="form-control"
                                placeholder="Enter amount" step="0.01" min="0" required />
                            <span class="text-danger amountError error"></span>
                        </div>

                        <div>
                            <label for="formFileLg" class="form-label">{{ _trans('common.Voucher') }}</label>
                            <input class="form-control form-control mb-2" id="formFileLg" name="voucher" type="file">
                            <span class="text-danger attachmentError error"></span>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Expense Date') }} <span
                                    class="text-danger">*</span></label>
                            <input type="date" id="expense_date" name="expense_date" class="form-control"
                                placeholder="Select expense date" required />
                            <span class="text-danger expenseDateError error"></span>
                        </div>




                        <div class="row card-body">
                            <div class="col-12 mb-2">
                                <label class="form-label">{{ _trans('common.Details') }}</label>
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

                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label
                                class="form-label">{{ _trans('common.Select') . ' ' . _trans('common.Status') }}</label>
                            <select id="active_status" name="active_status" class="select2 form-select"
                                data-placeholder="Select status">
                                <option value="1">{{ _trans('common.Active') }}</option>
                                <option value="0">{{ _trans('common.Deactive') }}</option>
                            </select>
                            <span class="text-danger statusError error"></span>
                        </div>



                        <div class="col-12 text-center mt-2">
                            <button type="submit"
                                class="btn btn-primary me-sm-3 me-1">{{ _trans('common.Save') }}</button>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">{{ _trans('common.Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Create Expense Modal -->



    <!-- Edit Expense Modal -->
    <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{ _trans('common.Edit') . ' ' . _trans('expense.Expense') }}</h3>
                    </div>
                    <form id="editForm">
                        <input type="hidden" id="editId" name="id">

                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Title') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="editTitle" name="title" class="form-control"
                                placeholder="Enter title" required />
                            <span class="text-danger editTitleError error"></span>
                        </div>

                        {{-- Expense Type --}}
                        <div class="mb-2 ecommerce-select2-dropdown">
                            <label class="form-label">{{ _trans('common.Select') . ' ' . _trans('common.Type') }} <span
                                    class="text-danger">*</span></label>
                            <select id="editExpenseType" name="expense_type" class="select2 form-select"
                                data-placeholder="Select type" required>
                                <option value="">{{ _trans('common.Select Type') }}</option>
                                @foreach ($expenseTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger editTypeError error"></span>
                        </div>
                        {{-- Expense Type --}}

                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Amount') }} <span
                                    class="text-danger">*</span></label>
                            <input type="number" id="editAmount" name="amount" class="form-control"
                                placeholder="Enter amount" step="0.01" min="0" required />
                            <span class="text-danger editAmountError error"></span>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-8">
                                <label for="editFormFileLg" class="form-label">{{ _trans('expense.Voucher') }}</label>
                                <input class="form-control form-control mb-2" id="editFormFileLg" name="voucher"
                                    type="file">
                                <span class="text-danger editAttachmentError error"></span>

                            </div>
                            <div class="col-md-4">
                                <div id="currentAttachmentSection"></div>
                            </div>
                        </div>

                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Expense Date') }} <span
                                    class="text-danger">*</span></label>
                            <input type="date" id="editExpenseDate" name="expense_date" class="form-control"
                                placeholder="Select expense date" required />
                            <span class="text-danger editExpenseDateError error"></span>
                        </div>

                        <div class="row card-body">
                            <div class="col-12 mb-2">
                                <label class="form-label">{{ _trans('common.Details') }}</label>
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
                                <span class="text-danger editMessageError error"></span>
                            </div>
                        </div>

                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label
                                class="form-label">{{ _trans('common.Select') . ' ' . _trans('common.Status') }}</label>
                            <select id="editActiveStatus" name="active_status" class="select2 form-select"
                                data-placeholder="Select status">
                                <option value="1">{{ _trans('common.Active') }}</option>
                                <option value="0">{{ _trans('common.Deactive') }}</option>
                            </select>
                            <span class="text-danger editStatusError error"></span>
                        </div>

                        <div class="col-12 text-center mt-2">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1"
                                id="expenseUpdate">{{ _trans('common.Update') }}</button>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">{{ _trans('common.Cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Expense Modal -->


@endsection

@push('scripts')
    <script>
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('expense-management.expenses.index') }}',
                    data: function(d) {
                        d.status = $('#status').val();
                        d.type = $('#type').val();
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
                        name: 'type'
                    },
                    {
                        data: 'expense_date',
                        name: 'expense_date'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'voucher',
                        name: 'voucher'
                    },
                    {
                        data: 'details',
                        name: 'details',
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
                        data: 'status',
                        name: 'active_status'
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
                    searchPlaceholder: "Search Expenses",
                },
                buttons: [{
                    text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Expense</span>',
                    className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                    action: function() {
                        $('#createExpenseModal').modal('show');
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
                $('.attachmentError').text('');
                $('#formFileLg').val('');

            }

            // Open Create Expense modal
            $('.create-new').click(function() {
                resetCreateModal();
                $('#createExpenseModal').modal('show');
            });

            // Submit form to create new campaign
            $('#createForm').submit(function(event) {
                event.preventDefault();
                $('.error').text('');
                let details = $("#createMessageEditor").children().first().html();
                var formData = new FormData();

                formData.append('title', $('#title').val());
                formData.append('expense_type', $('#expense_type').val());
                formData.append('active_status', $('#active_status').val());
                formData.append('amount', $('#amount').val());
                if ($('#formFileLg')[0].files.length > 0) {
                    formData.append('voucher', $('#formFileLg')[0].files[0]);
                }
                formData.append('expense_date', $('#expense_date').val());
                formData.append('details', details);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('expense-management.expenses.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 403) {
                            $('.titleError').text(response.errors?.title ? response.errors
                                .title[0] : '');
                            $('.messageError').text(response.errors?.message ? response.errors
                                .message[0] : '');
                            $('.attachmentError').text(response.errors?.voucher ? response
                                .errors
                                .voucher[0] : '');

                        } else if (response.status === 200) {
                            $('#createExpenseModal').modal('hide');
                            table.ajax.reload(null, false);
                            toastr.success(response.message);
                        }
                    },
                });
            });

            // Edit expense modal handler
            $(document).on('click', '.edit-expense', function() {
                var id = $(this).data('id');
                $('#editFormFileLg').val('');

                $('#currentAttachmentSection').html('');

                $.ajax({
                    url: '/expense-management/expenses/' + id + '/edit',
                    type: 'GET',
                    success: function(response) {

                        $('#editId').val(response.id);
                        $('#editTitle').val(response.title);
                        $('#editAmount').val(response.amount);
                        if (response.voucher) {
                            $('#currentAttachmentSection').html(
                                `<label class="form-label">Current Voucher</label>
                            <div class="mb-2">
                                ${response.voucher}
                            </div>`
                            );
                        } else {
                            $('#currentAttachmentSection').html('');
                        }
                        $('#editExpenseDate').val(response.expense_date);
                        $('#editMessageEditor').html(response
                            .details);
                        $('#editExpenseType').val(response.expense_type).trigger(
                            'change');
                        $('#editActiveStatus').val(response.active_status).trigger('change');
                        reInitQuillEditor();
                        $('#editExpenseModal').modal('show');

                    },
                    error: function(error) {
                        console.error('Error fetching expense data:', error);
                        toastr.error('Failed to fetch expense data.');
                    }
                });
            });


            $(document).ready(function() {
                // Submit form to edit expense
                $('#expenseUpdate').click(function(e) {
                    e.preventDefault();

                    var formData = new FormData();

                    let expense_id = $('#editId').val();
                    let title = $('#editTitle').val();
                    let voucher = $('#editFormFileLg')[0].files[0];
                    let expense_type = $('#editExpenseType').val();
                    let amount = $('#editAmount').val();
                    let expense_date = $('#editExpenseDate').val();
                    let details = $('#editMessageEditor').children().first().html();
                    let active_status = $('#editActiveStatus').val();


                    formData.append('id', expense_id);
                    formData.append('title', title);
                    formData.append('expense_type', expense_type);
                    formData.append('amount', amount);
                    if (voucher) {
                        formData.append('voucher', voucher);
                    }
                    formData.append('expense_date', expense_date);
                    formData.append('details', details);
                    formData.append('active_status', active_status);

                    formData.append('_token', "{{ csrf_token() }}");


                    $.ajax({
                        url: '/expense-management/expenses',
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
                                    ?.voucher ? response.errors
                                    .voucher[0] : '');
                            } else if (response.status === 200) {
                                $('#editExpenseModal').modal('hide');
                                table.ajax.reload(null, false);
                                toastr.success(response.message);
                            }
                        },
                        error: function(error) {
                            console.error('Error updating Expense', error);
                            toastr.error(
                                'Failed to update Expense. Please try again later.'
                            );
                        }
                    });
                });
            });

            // delete expenses
            $(document).on("click", ".delete-expense", function() {
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
                            url: '{{ route('expense-management.expenses.destroy') }}',
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
                var statusTextElem = checkbox.closest('.form-check').find('.statusText');
                var statusText = isChecked ? 'Active' : 'Inactive';
                var badgeClass = isChecked ? 'badge bg-label-success' : 'badge bg-label-danger';

                statusTextElem.removeClass().addClass(badgeClass).text(statusText);

                var formData = new FormData();
                formData.append('id', checkbox.data('id'));
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: '{{ route('expense-management.expenses.changeStatus') }}',
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

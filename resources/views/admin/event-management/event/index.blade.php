@extends('layouts.master')

@section('title', $title ?? _trans('common.Event').' '._trans('expense.Management'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('common.Events') ,['#'=>_trans('common.Event').' '._trans('expense.Management'),'category'=>_trans('common.Events')]) !!}
        <div class="app-ecommerce-category">
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

                    <div class="form-group">
                        <label><strong>{{_trans('common.Event Type')}} :</strong></label>
                        <select id='type' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '._trans('common.Type')}}</option>
                            @foreach($eventTypes as $type)
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
                            <th>{{_trans('common.Title')}}</th>
                            <th>{{_trans('common.Event'). ' '. _trans('common.Type')}}</th>
                            <th>{{_trans('common.Start Date')}}</th>
                            <th>{{_trans('common.End Date')}}</th>
                            <th>{{_trans('event.Event Url')}}</th>
                            <th>{{_trans('event.Location')}}</th>
                            <th>{{_trans('common.File')}}</th>
                            <th>{{_trans('common.Description')}}</th>
                            @if(hasPermission('event_change_status'))
                            <th>{{_trans('common.Status')}}</th>
                            @endif
                            <th width="100px">{{_trans('common.Action')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" id="closeUpdateModal" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{ _trans('common.Add') . ' ' . _trans('common.New') . ' ' . _trans('common.Event') }}</h3>
                    </div>

                    <!-- Start Form -->
                    <form action="{{ route('event-management.event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Title') }}*</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter title" required />
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Event Type -->
                        <div class="col ecommerce-select2-dropdown mb-3">
                            <label class="form-label mb-1">{{ _trans('common.Event') . ' ' . _trans('common.Type') }}*</label>
                            <select id="event_type" name="event_type" class="select2 form-select" required>
                                <option value="" selected disabled>Select Type</option>
                                @foreach($eventTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('event_type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Start Date') }}*</label>
                            <input type="datetime-local" name="start_date" class="form-control" placeholder="Select Start Date" required />
                            @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.End Date') }}*</label>
                            <input type="datetime-local" name="end_date" class="form-control" placeholder="Select End Date" required />
                            @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Event URL -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Event Url') }}</label>
                            <input type="text" name="event_url" class="form-control" placeholder="Event Url" />
                            @error('event_url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Location') }}</label>
                            <input type="text" name="location" class="form-control" placeholder="Event location"/>
                            @error('location')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Upload File')}}</label>
                            <input type="file" name="file" class="form-control">
                            @error('file')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Description') }}</label>
                            <textarea name="description" class="form-control" cols="20" rows="3" placeholder="Description"></textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3 col ecommerce-select2-dropdown">
                            <label class="form-label mb-1">{{ _trans('common.Status') }}*</label>
                            <select name="active_status" class="select2 form-select" required>
                                <option value="1" selected>{{ _trans('common.Active') }}</option>
                                <option value="0">{{ _trans('common.Deactive') }}</option>
                            </select>
                            @error('active_status')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1" id="addFaq">{{ _trans('common.Submit') }}</button>
                            <button id="reset" type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{ _trans('common.Cancel') }}
                            </button>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Modal -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" id="closeUpdateModal" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{ _trans('common.Edit') . ' ' . _trans('common.Event') }}</h3>
                    </div>

                    <!-- Start Form -->
                    <form action="{{ route('event-management.event.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" id="event_id" name="event_id" value="">
                        <!-- Name -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Title') }}*</label>
                            <input type="text" id="edit_name" name="name" class="form-control" placeholder="Enter title" required />
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Event Type -->
                        <div class="col ecommerce-select2-dropdown mb-3">
                            <label class="form-label mb-1">{{ _trans('common.Event') . ' ' . _trans('common.Type') }}*</label>
                            <select id="edit_event_type" name="event_type" class="select2 form-select" required>
                                <option value="" selected disabled>Select Type</option>
                                @foreach($eventTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('event_type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Start Date') }}*</label>
                            <input type="datetime-local" id="edit_start_date" name="start_date" class="form-control" placeholder="Select Start Date" required />
                            @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.End Date') }}*</label>
                            <input type="datetime-local" id="edit_end_date" name="end_date" class="form-control" placeholder="Select End Date" required />
                            @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Event URL -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Event Url') }}</label>
                            <input type="text" id="edit_event_url" name="event_url" class="form-control" placeholder="Event Url" />
                            @error('event_url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Location') }}</label>
                            <input type="text" id="edit_location" name="location" class="form-control" placeholder="Event location" />
                            @error('location')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 mb-3" id="fileArea" style="display: none;">
                            <label class="form-label">{{ _trans('common.Current File')}}</label>
                            <div id="currentImageContainer" class="col-12 mb-3">
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Upload File')}}</label>
                            <input type="file" name="file" class="form-control">
                            @error('file')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ _trans('common.Description') }}</label>
                            <textarea id="edit_description" name="description" class="form-control" cols="20" rows="3" placeholder="Description"></textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3 col ecommerce-select2-dropdown">
                            <label class="form-label mb-1">{{ _trans('common.Status') }}*</label>
                            <select id="edit_active_status" name="active_status" class="select2 form-select" required>
                                <option value="1" selected>{{ _trans('common.Active') }}</option>
                                <option value="0">{{ _trans('common.Deactive') }}</option>
                            </select>
                            @error('active_status')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1" id="addFaq">{{ _trans('common.Submit') }}</button>
                            <button id="reset" type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{ _trans('common.Cancel') }}
                            </button>
                        </div>
                    </form>
                    <!-- End Form -->
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
                    url : '{{ route('event-management.event.index') }}',
                    data: function (d){
                        d.status = $('#status').val()
                        d.type = $('#type').val()
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'event_type',
                        name: 'event_type'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'event_url',
                        name: 'event_url'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'file',
                        name: 'file',
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data, type, row) {
                            if (!data) return '';
                            const truncated = data.length  > 100 ? data.substr(0, 100) + '...' :
                                data;
                            return '<div data-bs-toggle="tooltip" data-bs-placement="right" title="' +
                                data +
                                '" style="width: 220px; white-space: normal; word-wrap: break-word;">' +
                                truncated + '</div>';
                        }
                    },
                    @if(hasPermission('event_change_status'))
                    {
                        data: 'status',
                        name: 'status'
                    },
                    @endif
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
                    searchPlaceholder: "Search Event",
                },
                // Button for offcanvas
                buttons: [
                        @if(hasPermission('event_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">{{_trans('common.Add').' '._trans('common.Event')}}</span>',
                        className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#addEventModal",
                        },
                    },
                    @endif
                ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });


            $(document).ready(function (){
                $('#reset').click(function(e) {
                    e.preventDefault();
                    $("input[name=title]").val('');
                    $("#status option:selected").prop('selected', false);
                    $("#description").children().first().html('');
                });
            })

            $(document).on("click", ".type_edit_button", function () {
                $('.error').text('')
                $id = $(this).attr("data-id");
                $('#edit_active_status').val(null).trigger('change');
                $('#edit_event_type').val(null).trigger('change');
                $.ajax({
                    url: '/event-management/event/edit/' + $id,
                    type: 'GET',
                    success: function (response) {
                        $('#event_id').val(response.data.id);
                        $("#edit_name").val(response.data.name);
                        $("#edit_event_type").val(response.data.event_type_id).trigger('change');
                        $("#edit_start_date").val(response.data.start_date);
                        $("#edit_end_date").val(response.data.end_date);
                        $("#edit_event_url").val(response.data.event_url);
                        $("#edit_location").val(response.data.location);
                        $("#edit_description").val(response.data.description);
                        $('#edit_active_status').val(response.data.active_status).trigger('change');

                        // $('#currentFile').parent().empty()
                        if (response.data.file != null) {
                            $('#fileArea').show();
                            $('#currentImageContainer').html(response.data.file);
                        } else {
                            // Hide the file area div if no file is present
                            $('#fileArea').hide();
                        }


                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });

            $(document).on("click", ".type_delete_button", function() {

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
                            url: '{{ route('event-management.event.delete') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id,
                            },
                            success: function(response) {
                                console.log(response)
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
                                // handle the error case
                            }
                        });
                    }
                });
            });

            $(document).on('change', '.changeStatus', function () {
                const id = $(this).data('id');
                const formData = new FormData();
                formData.append('id', id);
                formData.append('_token', "{{ csrf_token() }}");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "To change the status of this Event.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Change it',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('event-management.event.change-status') }}',
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                }
                            },
                            error: function (error) {
                                console.error(error);
                            }
                        });
                    } else {
                        table.ajax.reload(null, false);
                    }

                })
            })
        })

    </script>
@endpush


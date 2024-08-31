@extends('layouts.master')

@section('title', $title ?? _trans('setting.Background').' '._trans('setting.Settings'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('setting.Background').' '._trans('setting.Settings'),['#'=>_trans('setting.System').' '._trans('setting.Settings'),'/setting/background-settings'=>_trans('setting.Background').' '._trans('setting.Settings')]) !!}
        <div class="app-ecommerce-category">
            <!-- Background Settings List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 " style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>Status :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '._trans('common.Status')}}</option>
                            <option value="1">{{_trans('common.Active')}}</option>
                            <option value="0">{{_trans('common.Deactive')}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Type :</strong></label>
                        <select id='type' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '._trans('common.Type')}}</option>
                            <option value="image">{{_trans('common.Image')}}</option>
                            <option value="color">{{_trans('common.Color')}}</option>
                        </select>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="form-check-input"></th>
                            <th>{{_trans('common.Title')}}</th>
                            <th>{{_trans('common.Short Desc')}}</th>
                            <th>{{_trans('common.Purpose')}}</th>
                            <th>{{_trans('common.Type')}}</th>
                            <th>{{_trans('common.Image')}}</th>
                            <th>{{_trans('common.Color')}}</th>
                            @if(hasPermission('background_settings_status_change'))
                                <th>{{_trans('common.Status')}}</th>
                            @endif
                            <th width="50px">{{_trans('common.Info')}}</th>
                            <th width="100px">{{_trans('common.Action')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Setting Modal -->
    <div id="addSettingModal" class="modal fade" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{_trans('common.Add').' '._trans('setting.Background').' '._trans('setting.Setting')}}</h3>
                    </div>
                    <form class="row g-3" action="{{route('setting.background-settings.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 mb-2">
                            <label class="form-label">{{_trans('common.Title')}}</label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="Title" tabindex="-1" required/>
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Short Description -->
                        <div>
                            <label class="form-label">{{_trans('common.Short Description')}}</label>
                            <textarea name="description" class="form-control" cols="20" rows="3" placeholder="Short Description"></textarea>
                        </div>

                        <div>
                            <label for="status" class="form-label">{{_trans('common.Purpose')}}</label>
                            <select id="purpose" name="purpose" class="select2 form-select"
                                    data-placeholder="Select Purpose" required>
                                <option value="">{{_trans('common.Select').' '._trans('common.Purpose')}}</option>
                                <option value="0">{{_trans('common.Login').' '._trans('common.Page')}}</option>
                                <option value="1">{{_trans('pages.Signup Page')}}</option>
                                <option value="2">{{_trans('common.Admin').' '._trans('pages.Login Page')}}</option>
                                <option value="3">{{_trans('common.Forget').' '._trans('common.Password') }}</option>
                                <option value="4">{{_trans('common.Reset').' '._trans('common.Password') }}</option>
                            </select>
                            @error('purpose')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label">{{_trans('common.Type')}}</label>
                            <select id="section_type" name="type" class="select2 form-select"
                                    data-placeholder="Select Type" required>
                                <option value="">{{_trans('common.Select').' '._trans('common.Type') }}</option>
                                <option value="image">{{_trans('common.Image')}}</option>
                                <option value="color">{{_trans('common.Color')}}</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="dynamic-field" class="col-12 mb-2"></div>

                        <div class="col-12 text-center mt-2">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">{{_trans('common.Submit')}}</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{_trans('common.Cancel')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Setting Modal -->

    <!-- Edit Setting Modal -->
    <div id="editSettingModal" class="modal fade" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{_trans('common.Edit').' '._trans('system.Background').' '._trans('setting.Setting')}}</h3>
                    </div>
                    <form class="row g-3" action="{{route('setting.background-settings.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 mb-2">
                            <label class="form-label">{{_trans('common.Title')}}</label>
                            <input id="editTitle" type="text" name="title" class="form-control"
                                   placeholder="Title" tabindex="-1" required/>
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <input type="text" name="id" id="id" hidden>
                        </div>

                        <!-- Short Description -->
                        <div>
                            <label class="form-label">{{_trans('common.Short Description')}}</label>
                            <textarea id="editDescription" name="description" class="form-control" cols="20" rows="3" placeholder="Short Description"></textarea>
                        </div>

                        <div>
                            <label for="status" class="form-label">{{_trans('common.Purpose')}}</label>
                            <select id="editPurpose" name="purpose" class="select2 form-select"
                                    data-placeholder="Select Purpose" required>
                                <option value="">{{_trans('common.Select').' '._trans('common.Purpose')}}</option>
                                <option value="0">{{_trans('pages.Login Page')}}</option>
                                <option value="1">{{_trans('pages.Signup Page')}}</option>
                                <option value="2">{{_trans('common.Admin').' '._trans('pages.Login Page')}}</option>
                                <option value="3">{{_trans('common.Forget').' '._trans('common.Password')}}</option>
                                <option value="4">{{_trans('common.Reset').' '._trans('common.Password')}}</option>
                            </select>
                            @error('purpose')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="form-label">{{_trans('common.Type')}}</label>
                            <select id="editType" name="type" class="select2 form-select"
                                    data-placeholder="Select Type" required>
                                <option value="">{{_trans('common.Select').' '._trans('common.Type')}}</option>
                                <option value="image">{{_trans('common.Image')}}</option>
                                <option value="color">{{_trans('common.Color')}}</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="edit_dynamic-field"></div>

                        <div class="col-12 text-center mt-2">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">{{_trans('common.Submit')}}</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{_trans('common.Cancel')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Setting Modal -->


@endsection

@push('scripts')
    <script>
        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{{ route('setting.background-settings.index') }}',
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
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'short_desc',
                        name: 'short_desc'
                    },
                    {
                        data: 'purpose',
                        name: 'purpose'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'color',
                        name: 'color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },
                    @if(hasPermission('background_settings_status_change'))
                    {
                        data: 'status',
                        name: 'status'
                    },
                    @endif

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
                    searchPlaceholder: "Search Settings",
                },
                buttons: [
                    @if(hasPermission('background_settings_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Setting</span>',
                        className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#addSettingModal",
                        },
                    },
                    @endif
                ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });


            $(document).on('change', '.changeStatus', function (){
                const id = $(this).data('id');
                const formData = new FormData();
                formData.append('id', id);
                formData.append('_token', "{{ csrf_token() }}");
                console.log(id);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "To change the status of this setting.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Change it',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            url: '{{ route('setting.background-settings.changeStatus') }}',
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                    table.ajax.reload(null, false);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function (error) {
                                console.error(error);
                            }
                        });
                    }else{
                        table.ajax.reload(null, false);
                    }

                });
            })

            $(document).on("click", ".setting_delete_button", function() {

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
                            url: '{{ route('setting.background-settings.delete') }}',
                            method: 'DELETE',
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
                            }
                        });
                    }
                });
            });


            $('#section_type').on('change', function() {
                let selectedType = $(this).val();
                let inputFieldHtml = '';

                if (selectedType === 'image') {
                    inputFieldHtml = `
                <label class="form-label">Upload Image</label>
                <input type="file" name="image" class="form-control" required/>
                `;
                } else if (selectedType === 'color') {
                    inputFieldHtml = `
                <label class="form-label">Select Color</label>
                <input type="color" name="color" class="form-control" required/>
                `;
                }

                $('#dynamic-field').html(inputFieldHtml);
            });

            $(document).on("click", ".edit_button", function() {
                let id = $(this).attr("data-id");
                console.log(id)
                $('.error').text('')
                id = $(this).attr("data-id");
                $.ajax({
                    url: '/setting/background-settings/edit/' + id,
                    type: 'GET',
                    success: function (response) {
                        $('#id').val(id);
                        $("#editTitle").val(response.data.title);
                        $("#editDescription").val(response.data.short_desc);
                        $('#editPurpose').find('option[value="' + response.data.purpose +
                            '"]').attr("selected", "selected");
                        $('#editType').find('option[value="' + response.data.type +
                            '"]').attr("selected", "selected");

                        $('#editPurpose').trigger('change.select2');
                        $('#editType').trigger('change.select2');

                        let selectedType = response.data.type;
                        let inputFieldHtml = '';

                        if (selectedType === 'image') {
                            inputFieldHtml = `
                            <div class="row">
                                <div class="col-8">
                                    <label class="form-label">Upload Image</label>
                                    <input type="file" name="image" class="form-control"/>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Current Image</label>
                                    <div class="col-4">
                                            <img style="height: 50px; width: 50px" src="/storage/${response.data.image}" alt=""/>
                                    </div>
                                </div>
                            </div>

                            `;
                        } else if (selectedType === 'color') {
                            inputFieldHtml = `
                            <div class="col-12">
                                <label class="form-label">Select Color</label>
                                <input type="color" name="color" class="form-control" value="${response.data.color}" required/>
                            </div>
                            `;
                        }

                        $('#edit_dynamic-field').html(inputFieldHtml);

                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });

            $('#editType').on('change', function() {
                let selectedType = $(this).val();
                let inputFieldHtml = '';

                if (selectedType === 'image') {
                    inputFieldHtml = `
                <label class="form-label">Upload Image</label>
                <input type="file" name="image" class="form-control" required/>
                `;
                } else if (selectedType === 'color') {
                    inputFieldHtml = `
                <label class="form-label">Select Color</label>
                <input type="color" name="color" class="form-control" required/>
                `;
                }

                $('#edit_dynamic-field').html(inputFieldHtml);
            });


        });
    </script>
@endpush

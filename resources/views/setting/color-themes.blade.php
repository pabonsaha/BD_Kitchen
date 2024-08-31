@extends('layouts.master')

@section('title', $title ?? _trans('setting.Color').' '. _trans('setting.Themes'))

@section('content')



    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('setting.Color').' '. _trans('setting.Themes'),['#'=>_trans('setting.System').' '. _trans('setting.Settings'),'/setting/color-themes'=>_trans('setting.Color').' '. _trans('setting.Themes')]) !!}
        <div class="app-ecommerce-category">
            <!-- Color Themes List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2 " style="z-index: 100; margin-top: 10px; margin-left: 240px">
                    <div class="form-group">
                        <label><strong>Status :</strong></label>
                        <select id='status' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '._trans('common.Status')}}</option>
                            <option value="1">{{_trans('common.Enable')}}</option>
                            <option value="0">{{_trans('common.Disable')}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Type :</strong></label>
                        <select id='type' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '._trans('common.Type')}}</option>
                            <option value="image">{{_trans('system.Frontend')}}</option>
                            <option value="color">{{_trans('system.Admin Panel')}}</option>
                        </select>
                    </div>
                </div>

                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="form-check-input"></th>
                            <th>{{_trans('common.Name')}}</th>
                            <th>{{_trans('common.Type')}}</th>
                            <th>{{_trans('system.Primary')}}</th>
                            <th>{{_trans('system.Secondary')}}</th>
                            <th>{{_trans('system.BG Color')}}</th>
                            <th>{{_trans('system.Button Bg')}}</th>
                            <th>{{_trans('system.Button Text')}}</th>
                            <th>{{_trans('system.Hover')}}</th>
                            <th>{{_trans('system.Border')}}</th>
                            <th>{{_trans('system.Text')}}</th>
                            <th>{{_trans('system.Secondary Text')}}</th>
                            <th>{{_trans('system.Shadow')}}</th>
                            <th>{{_trans('system.Sidebar BG')}}</th>
                            <th>{{_trans('system.Sidebar Hover')}}</th>
                            <th>{{_trans('common.Status')}}</th>
                            <th width="50px">{{_trans('common.Info')}}</th>
                            <th width="100px">{{_trans('common.Action')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Color Theme Modal -->
    <div id="addColorThemeModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h3 class="role-title mb-3">{{_trans('common.Add').' '._trans('setting.Color').' '._trans('setting.Theme')}}</h3>
                    </div>
                    <form action="{{route('setting.color-themes.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="mb-3">
                                    <label for="theme_name" class="form-label">{{_trans('setting.Theme').' '._trans('common.Name')}}</label>
                                    <input type="text" class="form-control" id="theme_name" name="theme_name" placeholder="Theme name" required>
                                    @error('theme_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="status-org">{{_trans('common.Type')}}</label>
                                    <select id="type" name="type" class="select2 form-select">
                                        <option value="0" selected>{{_trans('system.Frontend')}}</option>
                                        <option value="1">{{_trans('system.Admin Panel')}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="primary_color" class="form-label">{{_trans('system.Primary Color')}}</label>
                                    <input type="color" class="form-control" id="primary_color" name="primary_color">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="secondary_color" class="form-label">{{_trans('system.Secondary Color')}}</label>
                                    <input type="color" class="form-control" id="secondary_color" name="secondary_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="btn_background_color" class="form-label">{{_trans('system.Background Color')}}</label>
                                    <input type="color" class="form-control" id="background_color" name="background_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="btn_background_color" class="form-label">{{_trans('system.Button Background')}}</label>
                                    <input type="color" class="form-control" id="btn_background_color" name="btn_background_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="btn_text_color" class="form-label">{{_trans('system.Button Text')}}</label>
                                    <input type="color" class="form-control" id="btn_text_color" name="btn_text_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="hover_color" class="form-label">{{_trans('system.Hover')}}</label>
                                    <input type="color" class="form-control" id="hover_color" name="hover_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="border_color" class="form-label">{{_trans('system.Border')}}</label>
                                    <input type="color" class="form-control" id="border_color" name="border_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="text_color" class="form-label">{{_trans('system.Text')}}</label>
                                    <input type="color" class="form-control" id="text_color" name="text_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="secondary_text_color" class="form-label">{{_trans('system.Secondary Text')}}</label>
                                    <input type="color" class="form-control" id="secondary_text_color" name="secondary_text_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="shadow" class="form-label">{{_trans('system.Shadow')}}</label>
                                    <input type="color" class="form-control" id="shadow_color" name="shadow_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="side_background" class="form-label">{{_trans('system.Sidebar Background')}}</label>
                                    <input type="color" class="form-control" id="side_background" name="sidebar_background">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="sidebar_hover" class="form-label">{{_trans('system.Sidebar Hover')}}</label>
                                    <input type="color" class="form-control" id="sidebar_hover" name="sidebar_hover">
                                </div>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">{{_trans('common.Save')}}</button>
                                <button id="reset" type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    {{_trans('common.Cancel')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Color Theme Modal -->

    {{--    Edit Color Theme Modal--}}
    <div id="editColorThemeModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h3 class="role-title mb-3">{{_trans('common.Edit').' '._trans('setting.Color').' '._trans('setting.Theme')}}</h3>
                    </div>
                    <form action="{{route('setting.color-themes.update')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="mb-3">
                                    <label for="editThemeName" class="form-label">{{_trans('system.Theme name')}}</label>
                                    <input type="text" class="form-control" id="editThemeName" name="theme_name" placeholder="theme name" required>
                                    @error('theme_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="col ecommerce-select2-dropdown">
                                    <label class="form-label mb-1" for="status-org">{{_trans('common.Type')}}</label>
                                    <select id="editType" name="type" class="select2 form-select">
                                        <option value="0" selected>{{_trans('system.Frontend')}}</option>
                                        <option value="1">{{_trans('system.Admin Panel')}}</option>
                                    </select>
                                </div>
                            </div>

                            <input name="themeId" type="text" id="themeId" hidden>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="primary_color" class="form-label">{{_trans('system.Primary Color')}}</label>
                                    <input type="color" class="form-control" id="edit_primary_color" name="primary_color">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="secondary_color" class="form-label">{{_trans('system.Secondary Color')}}</label>
                                    <input type="color" class="form-control" id="edit_secondary_color" name="secondary_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="btn_background_color" class="form-label">{{_trans('system.Background Color')}}</label>
                                    <input type="color" class="form-control" id="edit_background_color" name="background_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="btn_background_color" class="form-label">{{_trans('system.Button Background')}}</label>
                                    <input type="color" class="form-control" id="edit_btn_background_color" name="btn_background_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="btn_text_color" class="form-label">{{_trans('system.Button Text')}}</label>
                                    <input type="color" class="form-control" id="edit_btn_text_color" name="btn_text_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="hover_color" class="form-label">{{_trans('system.Hover')}}</label>
                                    <input type="color" class="form-control" id="edit_hover_color" name="hover_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="border_color" class="form-label">{{_trans('system.Border')}}</label>
                                    <input type="color" class="form-control" id="edit_border_color" name="border_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="text_color" class="form-label">{{_trans('system.Text')}}</label>
                                    <input type="color" class="form-control" id="edit_text_color" name="text_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="secondary_text_color" class="form-label">{{_trans('system.Secondary Text')}}</label>
                                    <input type="color" class="form-control" id="edit_secondary_text_color" name="secondary_text_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="shadow" class="form-label">{{_trans('system.Shadow')}}</label>
                                    <input type="color" class="form-control" id="edit_shadow_color" name="shadow_color">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="side_background" class="form-label">{{_trans('system.Sidebar Background')}}</label>
                                    <input type="color" class="form-control" id="edit_side_background" name="sidebar_background">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="sidebar_hover" class="form-label">{{_trans('system.Sidebar Hover')}}</label>
                                    <input type="color" class="form-control" id="edit_sidebar_hover" name="sidebar_hover">
                                </div>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">{{_trans('common.Update')}}</button>
                                <button id="reset" type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    {{_trans('common.Cancel')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--    Edit Color Theme Modal--}}


@endsection

@push('scripts')
    <script>
        $(function() {


            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{{ route('setting.color-themes.index') }}',
                    data: function (d){
                        d.status = $('#status').val()
                        d.type = $('#type').val()
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
                        data:'type',
                        name:'type'
                    },
                    {
                        data: 'primary_color',
                        name:'primary_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'secondary_color',
                        name:'secondary_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'background_color',
                        name:'background_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'button_bg_color',
                        name:'button_bg_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'button_text_color',
                        name:'button_text_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'hover_color',
                        name:'hover_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'border_color',
                        name:'border_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'text_color',
                        name:'text_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'secondary_text_color',
                        name:'secondary_text_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'shadow_color',
                        name:'shadow_color',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'sidebar_bg',
                        name: 'sidebar_bg',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'sidebar_hover',
                        name: 'sidebar_hover',
                        render: function(data, type, full, meta) {
                            return '<div style="background-color:' + data + '; width: 20px; height: 20px; display: inline-block; margin-right: 5px;"></div>' + data;
                        }
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'info',
                        name: 'info',
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
                    searchPlaceholder: "Search Color Theme",
                },
                // Button for offcanvas
                buttons: [
                    @if(hasPermission('color_themes_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Color</span>',
                        className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#addColorThemeModal",
                        },
                    },
                    @endif

                ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });


            $(document).on("click", ".theme_edit_button", function () {
                $('.error').text('')
                $id = $(this).attr("data-id");
                $.ajax({
                    url: '/setting/color-themes/edit/' + $id,
                    type: 'GET',
                    success: function (response) {
                        $('#themeId').val($id);

                        $("#editThemeName").val(response.data.name);

                        $("#edit_primary_color").val(response.data.primary_color);
                        $("#edit_secondary_color").val(response.data.secondary_color);
                        $("#edit_background_color").val(response.data.background_color);
                        $("#edit_btn_background_color").val(response.data.button_bg_color);
                        $("#edit_btn_text_color").val(response.data.button_text_color);
                        $("#edit_hover_color").val(response.data.hover_color);
                        $("#edit_border_color").val(response.data.border_color);
                        $("#edit_text_color").val(response.data.text_color);
                        $("#edit_secondary_text_color").val(response.data.secondary_text_color);

                        $("#edit_shadow_color").val(response.data.shadow_color);
                        $("#edit_side_background").val(response.data.sidebar_bg);
                        $("#edit_sidebar_hover").val(response.data.sidebar_hover);

                        $('#edit_active_status').val(response.data.active_status).trigger('change');
                        $('#editType').val(response.data.type).trigger('change');


                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });

            $(document).on("click", ".theme_delete_button", function() {

                let color_theme_id = $(this).attr("data-id");
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
                            url: '{{ route('setting.color-themes.delete') }}',
                            method: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: color_theme_id,
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

            $(document).on("click", ".theme_apply_button", function () {
                let color_theme_id = $(this).attr("data-id");

                Swal.fire({
                    title: 'Are you sure?',
                    // text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Make it Default',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {

                        $.ajax({
                            url: '{{ route('setting.color-themes.apply') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: color_theme_id,
                            },
                            success: function (response) {
                                if (response.status === 200) {
                                    toastr.success(response.message);
                                    window.location.reload();
                                }
                            },
                            error: function (error) {
                                toastr.error(error.responseJSON.message);
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush

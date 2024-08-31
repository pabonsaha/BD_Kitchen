@extends('layouts.master')

@section('title', $title ?? _trans('frontendCMS.Slider'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb(_trans('frontendCMS.Slider'), ['#'=> 'Frontend CMS', '/cms/slider' => _trans('frontendCMS.Slider')]) !!}
        <div class="app-ecommerce-category">
            <!-- Slider List Table -->
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
                        <label><strong>{{_trans('common.Type')}} :</strong></label>
                        <select id='type' class="form-control filter_dropdown" style="width: 200px">
                            <option value="">{{_trans('common.Select').' '._trans('common.Type')}}</option>
                            <option value="0">{{_trans('common.Home Page')}}</option>
                            <option value="1">{{_trans('common.About Us')}}</option>
                        </select>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="data-table table border-top">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="form-check-input"></th>
                            <th>{{_trans('common.Title')}}</th>
                            <th>{{_trans('common.Image')}}</th>
                            <th>{{_trans('common.Type')}}</th>
                            @if(hasPermission('slider_status_change'))
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
    <div class="modal fade" id="addSliderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" id="closeUpdateModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{ _trans('common.Add').' '._trans('common.New').' '._trans('frontendCMS.Slider') }}</h3>
                    </div>
                    <!-- Form Start -->
                    <form id="addSliderForm" action="{{ route('cms.slider.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Title') }}*</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Enter title" required/>
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-3 col ecommerce-select2-dropdown">
                            <label class="form-label mb-1" for="status-org">{{ _trans('common.Type') }}*</label>
                            <select name="slider_type" class="select2 form-select">
                                <option disabled selected>{{ _trans('common.Select Type') }}</option>
                                <option value="0">{{ _trans('common.Home Page') }}</option>
                                <option value="1">{{ _trans('common.About Us') }}</option>
                            </select>
                            @error('slider_type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mt-3 col ecommerce-select2-dropdown">
                            <label class="form-label mb-1" for="status-org">{{ _trans('common.Status') }}*</label>
                            <select name="active_status" class="select2 form-select">
                                <option value="1" selected>{{ _trans('common.Active') }}</option>
                                <option value="0">{{ _trans('common.Deactive') }}</option>
                            </select>
                            @error('active_status')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-12 mt-3">
                            <label class="form-label">{{ _trans('common.Image') }}*</label>
                            <input type="file" id="image" name="image" class="form-control" required/>
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1" id="addFaq">{{ _trans('common.Submit') }}</button>
                            <button id="reset" type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{ _trans('common.Cancel') }}
                            </button>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Modal -->


    <!-- Edit Modal -->
    <div class="modal fade" id="editSliderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" id="closeModal" aria-label="Close"></button>
                <form id="editSliderForm" action="{{route('cms.slider.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="text-center mb-2">
                            <h3 class="role-title mb-2">{{ _trans('common.Edit') . ' ' . _trans('frontendCMS.Slider') }}</h3>
                        </div>
                        <div class="col-12 mb-2">
                            <label class="form-label">{{ _trans('common.Title') }}</label>
                            <input type="text" id="editTitle" name="editTitle" class="form-control" placeholder="Enter title" required />
                            <span class="text-danger titleError error"></span>
                        </div>

                        <input type="hidden" id="slider_id" name="slider_id">

                        <!-- Status -->
                        <div class="mt-3 col ecommerce-select2-dropdown">
                            <label class="form-label mb-1" for="status-org">{{ _trans('common.Status') }}</label>
                            <select id="editStatus" name="editStatus" class="select2 form-select" required>
                                <option value="1">{{ _trans('common.Active') }}</option>
                                <option value="0">{{ _trans('common.Deactive') }}</option>
                            </select>
                        </div>

                        <div class="mt-3 col ecommerce-select2-dropdown">
                            <label class="form-label mb-1" for="status-org">{{ _trans('common.Type') }}</label>
                            <select id="edit_slider_type" name="edit_slider_type" class="select2 form-select" required>
                                <option value="0">{{ _trans('common.Home Page') }}</option>
                                <option value="1">{{ _trans('common.About Us') }}</option>
                            </select>
                        </div>

                        <!-- Current Image Preview -->
                        <div class="col-12 mt-3">
                            <label class="form-label">{{ _trans('common.Current Image') }}</label>
                            <div class="mb-2">
                                <img id="currentImage" src="#" alt="Current Image" class="img-fluid rounded" style="max-width: 200px;" />
                            </div>
                        </div>

                        <!-- New Image Upload -->
                        <div class="col-12 mt-3">
                            <label class="form-label">{{ _trans('common.Image') }}</label>
                            <input type="file" id="image" name="image" class="form-control" />
                            <span class="text-danger imageError error"></span>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1" id="updateFaq">{{ _trans('common.Submit') }}</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">{{ _trans('common.Cancel') }}</button>
                        </div>
                    </div>
                </form>
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
                    url : '{{ route('cms.slider.index') }}',
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
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },

                    @if(hasPermission('slider_status_change'))

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
                    searchPlaceholder: "Search Slider",
                },
                // Button for offcanvas
                buttons: [
                    @if(hasPermission('slider_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Slider</span>',
                        className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#addSliderModal",
                        },
                    },
                    @endif
                ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });

            $(document).on('change', '.changeStatus', function() {
                const id = $(this).data('id');
                const formData = new FormData();
                formData.append('id', id);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: '{{ route('cms.slider.changeStatus') }}',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.status === 200) {
                            toastr.success(response.message);
                        }else{
                            toastr.error(response.message)
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            $(document).on("click", ".slider_edit_button", function () {
                $('.error').text('')
                $id = $(this).attr("data-id");
                $('#editStatus').val(null).trigger('change');
                $('#edit_slider_type').val(null).trigger('change');

                $.ajax({
                    url: '/cms/slider/edit/' + $id,
                    type: 'GET',
                    success: function (response) {
                        console.log(response)
                        $('#slider_id').val(response.data.id);
                        $("#editTitle").val(response.data.title);
                        $('#editStatus').val(response.data.active_status).trigger('change');
                        $('#edit_slider_type').val(response.data.type).trigger('change');
                        $('#currentImage').attr('src', response.data.image);
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message);
                    }
                });
            });

            $(document).on("click", ".slider_delete_button", function() {

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
                            url: '{{ route('cms.slider.destroy') }}',
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

        });

    </script>
@endpush

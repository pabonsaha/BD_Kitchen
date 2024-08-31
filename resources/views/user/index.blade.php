@php use App\Models\Role; @endphp
@extends('layouts.master')

@section('title', $title ?? _trans('role.Role'))

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {!! breadcrumb( $roleName .' '._trans('common.List'),['#'=>_trans('common.User').' '._trans('product.Management'),'user'=> $roleName .' '._trans('common.List')]) !!}

        <div class="app-ecommerce-category">
            <!-- Category List Table -->
            <div class="card">
                <div class="d-flex gap-3 position-absolute ps-4 p-2" style="z-index: 100; margin-top: 10px; margin-left: 240px">
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
                            <th>{{_trans('common.Name')}}</th>
                            <th>{{_trans('common.Image')}}</th>
                            <th>{{_trans('role.Role')}}</th>
                            <th>{{_trans('common.Status')}}</th>
                            <th width="100px">{{_trans('common.Action')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('user.index',$roleId) }}',
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
                        data: 'avatar',
                        name: 'avatar'
                    },
                    {
                        data: 'role_id',
                        name: 'role_id'
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
                    render: function () {
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
                    searchPlaceholder: "Search User",
                },

                buttons: [

                ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });


            $(document).on("click", ".user_delete_button", function () {

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
                }).then(function (result) {
                    if (result.value) {

                        $.ajax({
                            url: '{{ route('user.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                brand_id: id,
                            },
                            success: function (response) {
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
                            error: function (error) {
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

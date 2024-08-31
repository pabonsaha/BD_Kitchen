@extends('layouts.master')

@section('title', $title ?? __($roleName))

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

    <!-- Add Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" id="closeUpdateModal" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <h3 class="role-title mb-2">{{_trans('common.Add').' '._trans('common.New').' '._trans('common.Employee')}}</h3>
                    </div>
                    <form class="row g-3" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 mb-2">
                            <label class="form-label">{{_trans('common.Name')}}</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" required/>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">{{_trans('common.Select').' '._trans('role.Role')}}</label>
                            <select id="role" name="role" class="select2 form-select" data-placeholder="Select Role" required>
                                <option value="">{{_trans('common.Select').' '._trans('common.User').' '._trans('role.Role')}}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">{{_trans('common.Email')}}</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required/>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">{{_trans('common.Phone')}}</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone"/>
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">{{_trans('common.Password')}}</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required/>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">{{_trans('common.Confirm').' '._trans('common.Password')}}</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" required/>
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">{{_trans('common.Image')}}</label>
                            <input type="file" id="avatar" name="avatar" class="form-control" placeholder="Employee Profile"/>
                            @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label mb-1" for="status-org">{{_trans('common.Status')}}</label>
                            <select id="status" name="status" class="select2 form-select" required>
                                <option value="1" selected>{{_trans('common.Active')}}</option>
                                <option value="0">{{_trans('common.Deactive')}}</option>
                            </select>
                            @error('status')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col mb-2">
                            <label class="form-label">{{_trans('common.Address')}}</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Employee Address"></textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1" id="addFaq">{{_trans('common.Submit')}}</button>
                            <button id="reset" type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">{{_trans('common.Cancel')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Modal -->


@endsection

@push('scripts')
    <script>
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{{ route('user.employeeList') }}',
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
                    searchPlaceholder: "Search User",
                },
                // Button for offcanvas
                buttons: [
                    @if(hasPermission('employees_create'))
                    {
                        text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Employee</span>',
                        className: "create-new btn btn-primary ms-2 waves-effect waves-light",
                        attr: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#addEmployeeModal",
                        },
                    },
                    @endif
                ],
            });

            $('.filter_dropdown').change(function () {
                table.draw();
            });

            $(document).on("click", ".user_delete_button", function() {

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
                            url: '{{ route('user.destroy') }}',
                            method: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                user_id: id,
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

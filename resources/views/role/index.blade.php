@extends('layouts.master')

@section('title', $title ?? _trans('role.Role'))

@section('content')
    {!! breadcrumb(_trans('role.Role') . ' ' . _trans('order.List'), [
        'role/index' => 'Role',
        'role' => _trans('role.Role') . ' ' . _trans('order.List'),
    ]) !!}

    <p class="mb-1">

    </p>
    <div class="alert d-flex align-items-center bg-label-warning mb-0" role="alert">
        <span class="alert-icon text-warning me-2 bg-label-light px-2 pb-2 rounded-2">
            <i class="ti ti-bell ti-xs mt-1"></i>
        </span>
        {{ _trans('role.A role provided access to predefined menus and features so that depending on assigned role an administrator can have access to what user needs') }}

    </div>

    @if (hasPermission('role_create'))
        <div class="row g-4 justify-content-end align-items-end mt-0">
            <div class="col-2">
                <div class="row justify-content-end align-items-end">
                    <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                        class="btn btn-primary mb-2 text-nowrap add-new-role">
                        <i
                            class="ti ti-plus me-0 me-sm-1 ti-xs"></i>{{ _trans('common.Add') . ' ' . _trans('common.New') . ' ' . _trans('role.Role') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
    <!-- Role cards -->
    <div class="row g-2">
        @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span class="badge bg-label-primary">{{ _trans('common.Total') . ' ' . _trans('common.User') }}:
                                <span class="badge badge-center bg-primary bg-glow">{{ $role->users_count }}</span>
                            </span>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @foreach ($role->users->take(8) as $user)
                                    <!-- Display only the first 8 users -->
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="{{ $user->name }}" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/5.png') }}"
                                             alt="{{ $user->name }}"/>
                                    </li>
                                @endforeach

                                @if($role->users_count > 8)
                                    <li class="avatar avatar-sm">
                            <span class="rounded-circle avatar-initial bg-primary text-white">
                                +{{ $role->users_count - 8 }}
                            </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1">
                            <div class="role-heading">

                                <h4 class="mb-1">{{ $role->name }}
                                    @if ($role->type == 0)
                                        <span class="font-size-12 text-warning">(System Defined)</span>
                                </h4>
                            @else
                                <span class="font-size-12 text-primary">(User Defined)</span> </h4>
        @endif

        <div class="d-flex gap-2">
            @if (hasPermission('role_update'))
                <a style="margin-right: 10px" href="javascript:;" data-bs-toggle="modal" data-bs-target="#updateRoleModal"
                    class="role-edit-modal"><span
                        onclick="updateRole({{ $role->id }},'{{ $role->name }}')">{{ _trans('common.Edit') }}</span></a>
            @endif

            @if (hasPermission('role_delete'))
                @if ($role->type != 0 && $role->id != 1)
                    <a href="javascript:;" class="text-danger"><span
                            onclick="deleteRole({{ $role->id }})">{{ _trans('common.Delete') }}</span></a>
                @endif
            @endif

        </div>

    </div>

    @if (hasPermission('give_permission'))
        @if ($role->id != 1)
            <a href="{{ route('role.assignPermission', $role->id) }}" class="text-success" title="Assign Permission"><i
                    class="ti ti-pencil ti-sm"></i>
            </a>
        @endif
    @endif
    </div>
    </div>
    </div>
    </div>
    @endforeach
    </div>
    <!--/ Role cards -->


    <!-- Add Role Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">
                            {{ _trans('common.Add') . ' ' . _trans('common.New') . ' ' . _trans('role.Role') }} </h3>
                        <p class="text-muted">
                            {{ _trans('role.Here you can add new role and after add new role you can give specific permission to specific role') }}.
                        </p>
                    </div>
                    <!-- Add role form -->
                    <form id="addRoleForm" class="row g-3" action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <div class="col-12 mb-4">
                            <label class="form-label"
                                for="modalRoleName">{{ _trans('role.Role') . ' ' . _trans('common.Name') }}</label>
                            <input type="text" id="modalRoleName" required name="name" class="form-control"
                                placeholder="Enter a role name" tabindex="-1" />
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit"
                                class="btn btn-primary me-sm-3 me-1">{{ _trans('common.Submit') }}</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                {{ _trans('common.Cancel') }}
                            </button>
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Role Modal -->

    <!--/ Update Role Modal -->
    <div class="modal fade" id="updateRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content p-3 p-md-5">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="role-title mb-2">{{ _trans('common.Edit') . ' ' . _trans('role.Role') }}</h3>
                        <p class="text-muted">{{ _trans('role.Here you can update role') }}.</p>
                    </div>
                    <!-- Add role form -->
                    <form id="addRoleForm" action="{{ route('role.update') }}" class="row g-3" method="POST">
                        @csrf
                        <input type="text" id="role_id" name="role_id" hidden>
                        <div class="col-12 mb-4">
                            <label class="form-label"
                                for="modalRoleName">{{ _trans('role.Role') . ' ' . _trans('common.Name') }}</label>
                            <input type="text" id="modalRoleNameUpdate" name="name" required class="form-control"
                                placeholder="Enter a role name" tabindex="-1" />
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit"
                                class="btn btn-primary me-sm-3 me-1">{{ _trans('common.Submit') }}</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                {{ _trans('common.Cancel') }}
                            </button>
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
            </div>
        </div>
    </div>
    <!--/ Update Role Modal -->


@endsection

@push('scripts')
    <script>
        function updateRole(id, name) {
            $('#role_id').val(id);
            $('#modalRoleNameUpdate').val(name);
        }


        function deleteRole(id) {
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
                        url: '{{ route('role.destroy') }}',
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            role_id: id,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.icon,
                                title: 'Deleted!',
                                text: response.text,
                                customClass: {
                                    confirmButton: 'btn btn-success waves-effect waves-light'
                                }
                            }).then(function(final) {
                                window.location.reload();
                            });
                        },
                        error: function(error) {
                            console.log(error.responseJSON.message);
                            // handle the error case
                        }
                    });
                }
            });
        }
    </script>
@endpush

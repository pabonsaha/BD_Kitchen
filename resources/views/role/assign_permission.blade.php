@extends('layouts.master')
@section('title', $title ?? __('Permission'))
@section('content')
    <div class="row">
        {!! breadcrumb('Permission', ['role/index' => 'Role', '#' => 'Permission', 'role' => 'Permissions']) !!}

        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 col-md-6 text-mute pl-0">{{_trans('role.Assign Permission to')}} <strong>{{ $role->name }}</strong></h5>
                </div>
                <div class="card-body">

                    @if (@$role->id == 1)
                        <div class="alert alert-danger">
                            <strong>{{_trans('role.Warning')}}!</strong> {{_trans("role.You can't change permission of this role")}}.
                        </div>
                    @endif
                    <form action="{{ route('role.permissionUpdate') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="role_id" value="{{ @$role->id }}">
                        <div class="table-responsive">
                            <table class="table test">
                                <thead>
                                    <th>{{ __('module_name') }}</th>
                                    <th>{{ __('Permissions') }}</th>
                                </thead>
                                <tbody>

                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td class="text-nowrap fw-medium">{{ $permission->attribute }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @foreach ($permission->keywords as $key => $keyword)
                                                        <div class="form-check me-3 me-lg-5">
                                                            <input class="common-key form-check-input" type="checkbox"
                                                                name="permissions[]" value="{{ $keyword }}"
                                                                id="{{ $keyword }}"
                                                                {{ $role->permissions && in_array($keyword, @$role->permissions) ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="userManagementRead">
                                                                {{ __($key) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (@$role->id != 1)
                                <div class="modal-footer">
                                    <button class="btn btn-primary mt-3" type="submit">{{_trans('common.Update')}}</button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.common-key', function() {
            var value = $(this).val();
            var value = value.split("_");
            if (value[1] == 'read') {
                if (!$(this).is(':checked')) {
                    $(this).closest('tr').find('.common-key').prop('checked', false);
                }
            } else {
                if ($(this).is(':checked')) {
                    $(this).closest('tr').find('.common-key').first().prop('checked', true);
                }
            }
        });
    </script>
@endpush

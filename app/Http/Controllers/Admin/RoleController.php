<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdValidationRequest;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Exception;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    //

    public function index()
    {
        $roles = Role::with('users')->withCount('users')->get();
        return view('role.index', compact('roles'));
    }

    public function store(RoleStoreRequest $request)
    {
        try {

            $role = new Role();
            $role->name = $request->name;
            $role->type = 1;
            $role->active_status = 1;
            $role->created_by = Auth::user()->id;
            $role->updated_by = Auth::user()->id;
            $role->save();

            Toastr::success('Role Created Successfully');
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('danger', 'Somthing went wrong');
        }
    }

    public function update(RoleUpdateRequest $request)
    {
        try {
            $role = Role::find($request->role_id);
            $role->name = $request->name;
            $role->updated_by = Auth::user()->id;
            $role->save();

            Toastr::success('Role Updated Successfully');
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('danger', 'Somthing went wrong');
        }
    }


    public function destroy(IdValidationRequest $request)
    {;

        try {
            $role = Role::withCount('users')->find($request->role_id);

            if ($role->users_count == 0) {
                $role->delete();
                return response()->json(['text'=>'Role has been deleted.','icon'=>'success']);
            } else {
                return response()->json(['text'=>"Role can't be deleted. Because role has users",'icon'=>'error']);
            }
        } catch (Exception $e) {
            return response()->json(['text'=>"Something went wrong"]);
        }
    }

    public function assignPermission($id)
    {
        try {
            $role = Role::find($id);
            if ($role->id == 1) {
                Toastr::warning('You can not modify permission to this role');
                return redirect()->route('role.index');
            }
            $permissions = Permission::all();
            return view('role.assign_permission', compact('role', 'permissions'));
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong!'), 'Error', ['timeOut' => 2000]);
            return redirect()->back();
        }
    }


    public function permissionUpdate(Request $request)
    {

        try {
            $permissionUpdate = Role::findOrFail($request->role_id);
            $permissionUpdate->permissions = $request->permissions;
            $permissionUpdate->save();

            Toastr::success(__('Permission Update Successfully'), 'Success', ['timeOut' => 2000]);
            return redirect()->route('role.index');
        } catch (\Throwable $th) {
            Toastr::error(__('Something went wrong!'), 'Error', ['timeOut' => 2000]);
            return redirect()->back();
        }
    }
}

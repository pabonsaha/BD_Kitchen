<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventTypeStoreRequest;
use App\Models\EventType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventTypeController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = EventType::where('user_id', getUserId());
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if (hasPermission('event_type_change_status')){
                    $isActive = $row->active_status == 1 ? 'checked' : '';

                    return '<label class="switch switch-success">
                                <input type="checkbox" class="switch-input changeStatus" data-id="' . $row->id . '" ' . $isActive . ' />
                                <span class="switch-toggle-slider">
                                    <span class="switch-on">
                                        <i class="ti ti-check"></i>
                                    </span>
                                    <span class="switch-off">
                                        <i class="ti ti-x"></i>
                                    </span>
                                </span>
                            </label>';
                    }
                    return '';
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }
                }, true)

                ->addColumn('action', function ($row) {

                    $btn = '';
                    if (hasPermission('event_type_create') || hasPermission('event_type_update')) {
                        $btn .= '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('event_type_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item type_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCategoryEditModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Edit</a>';
                    }

                    if (hasPermission('event_type_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item type_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';

                    }

                    return $btn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }

        return view("event-management.type.index");

    }

    public function store(EventTypeStoreRequest $request){
        try {
            $type = new EventType();
            $type->name = $request->name;
            $type->active_status = $request->active_status;
            $type->user_id = getUserId();
            $type->save();
            Toastr::success('Event Type Created Successfully', 'Success');
        }catch (\Exception $e){
            Toastr::error('Something Went Wrong!', 'Error');
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        try {
            $data = EventType::where('id', $id)->where('user_id', getUserId())->first();
            return response()->json($data);
        }catch (\Exception $e){
            return response()->json('Something Went Wrong!', 'Error');
        }
    }

    public function update(EventTypeStoreRequest $request)
    {
        try {
            $data = EventType::where('id', $request->event_type_id)->where('user_id', getUserId())->first();
            $data->name = $request->name;
            $data->active_status = $request->active_status;
            $data->save();
            Toastr::success('Event Type Updated Successfully', 'Success');
        }catch (\Exception $e){
            Toastr::error('Something Went Wrong!', 'Error');
        }
        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
        try {
            $data = EventType::where('id', $request->id)->where('user_id', getUserId())->first();
            $data->active_status = !$data->active_status;
            $data->save();
            return response()->json(['message' => 'Status Updated Successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message'=> 'Something Went Wrong!', 'status' => 500]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = EventType::where('id', $request->id)->where('user_id', getUserId())->first();
            $data->delete();
            return response()->json(['message' => 'Event Type Deleted Successfully', 'status' => 200], 200);
        }catch (\Exception $e){
            return response()->json(['message'=> 'Something Went Wrong!', 'status' => 500]);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\NoticeType;
use Illuminate\Http\Request;
use App\Http\Requests\IdValidationRequest;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class NoticeTypeController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = NoticeType::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $isActive = $row->is_active == 1 ? 'checked' : '';

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
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('is_active', $request->get('status'));
                    }
                }, true)
                ->addColumn('action', function ($row) {

                    $btn = '<div class="d-inline-block text-nowrap">' .
                        '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                        '<div class="dropdown-menu dropdown-menu-end m-0">';

                            $btn.='<a href="javascript:0;" class="dropdown-item type_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCategoryEditModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Edit</a>' ;

                            $btn .= '<a href="javascript:0;" class="dropdown-item type_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                                '</div>' .
                                '</div>';

                    return $btn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('notice-board.type.index');
    }

    public function store(Request $request){

        try {
            $noticeType = new NoticeType();
            $noticeType->name = $request->name;
            $noticeType->user_id = getUserId();
            $noticeType->is_active  = $request->status;

            $noticeType->save();
            return response()->json(['message' => 'Notice Type Created', 'status' => 200], 200);

        }catch (Exception $e){
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }



    public function changeStatus(Request $request)
    {
        $data = NoticeType::find($request->id);
        if ($data) {
            if ($data->is_active == 1) {
                $data->is_active = 0;
            } else {
                $data->is_active = 1;
            }
            $data->save();
            return response()->json(['message' => 'Status Updated Successfully', 'status' => 200], 200);
        } else {
            return response()->json(['message' => "Data Not Found!"], 404);
        }
    }



    public function edit($id){
        $noticeType = NoticeType::find($id);
        return response()->json(['data' => $noticeType, 'status' => 200], 200);
    }

    public function update(Request $request){
        try {
            $noticeType = NoticeType::find($request->id);
            $noticeType->name = $request->name;
            $noticeType->is_active  = $request->status;
            $noticeType->update();
            return response()->json(['message' => 'Notice Type Updated', 'status' => 200], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }


    public function destroy(IdValidationRequest $request){

        try {
            $noticeType = NoticeType::find($request->id);
            $noticeType->delete();
            return response()->json(['message' => 'Notice Type Deleted', 'status' => 200], 200);

        }catch (Exception $e){
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }


}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderStoreRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\Slider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{

    use FileUploadTrait;
    public function index(Request $request){

        if ($request->ajax()) {
            $data = Slider::where('user_id', Auth::user()->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    if ($row->image) {
                        return "<img src='" . getFilePath($row->image) . "' alt='' width='50px' height='50px' />";
                    }
                    return '';
                })
                ->addColumn('status', function ($row) {
                    if (hasPermission('slider_status_change')) {
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
                ->editColumn('type', function ($row) {
                    return $row->type == 0 ? '<span class="badge bg-label-info">Home Page</span>' : '<span class="badge bg-label-info">About Us</span>';
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }
                    if ($request->get('type') == '0' || $request->get('type') == '1') {
                        $instance->where('type', $request->get('type'));
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '';
                    if (hasPermission('slider_update') || hasPermission('slider_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('slider_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item slider_edit_button" data-bs-toggle="modal" data-bs-target="#editSliderModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Edit</a>';
                    }
                    if (hasPermission('slider_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item slider_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'description', 'status', 'image', 'type'])
                ->make(true);
        }
        return view('frontend-cms.slider.index');
    }

    public function store(SliderStoreRequest $request){
        try {
            $data = new Slider();
            $data->title = $request->title;
            $data->user_id = getUserId();
            $data->type = $request->slider_type;
            $data->active_status = $request->active_status;
            if ($request->hasFile('image')) {
                $data->image = $this->uploadFile($request->file('image'), 'slider');
            }
            $data->save();
            Toastr::success('success', 'Slider Created Successfully');

        }catch (\Exception $e){
            Toastr::error('error', 'Something Went Wrong!');
        }
        return redirect()->back();
    }

    public function edit($id){
        try {
            $data = Slider::find($id);
            if ($data){
                $data->image = getFilePath($data->image);
                return response()->json(['data' => $data, 'status' => 200], 200);
            }
        }catch (\Exception $exception){
            return response()->json(['message' => "Something went wrong"], 500);
        }
    }

    public function update(Request $request){
        try {
            $data = Slider::find($request->slider_id);
            if ($data) {
                if ($request->hasFile('image')) {
                    $this->deleteFile($data->image);
                    $data->image = $this->uploadFile($request->file('image'), 'slider');
                }
                $data->title = $request->editTitle;
                $data->active_status = $request->editStatus;
                $data->type = $request->edit_slider_type;
                $data->save();
                Toastr::success('success', 'Slider Updated Successfully');
            }
        }catch (\Exception $e){
            Toastr::error('error', 'Something Went Wrong!');
        }
        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
        try {
            $data = Slider::find($request->id);
            if ($data){
                $data->active_status = !$data->active_status;
                $data->save();
                return response()->json(['message' => 'Status Updated Successfully', 'status' => 200], 200);
            }
        }catch (\Exception $e){
            return response()->json(['message' => "Something went wrong"], 500);
        }
    }

    public function delete(Request $request){
        try {
            $data = Slider::find($request->id);
            if ($data){
                if ($data->image){
                    $this->deleteFile($data->image);
                }
                $data->delete();
                Toastr::success(['success', 'Slider Deleted Successfully', 'status' => 200]);
            }
        }catch (\Exception $e){
            return response()->json(['message' => "Something went wrong", 'status' => 200], 500);
        }
    }
}

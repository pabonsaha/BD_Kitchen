<?php

namespace App\Http\Controllers;

use App\Http\Requests\FooterWidgetUpdateRequest;
use App\Models\FooterWidget;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FooterWidgetController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = FooterWidget::select('*')->with('createdBy', 'updatedBy');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->active_status == 1) {
                        return '<span class="badge bg-label-success">Active</span>';
                    } else {
                        return '<span class="badge bg-label-danger">Deactive</span>';
                    }
                })
                ->addColumn('info', function ($row){
                    return dataInfo($row);
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }
                }, true)
                ->addColumn('action', function ($row) {

                    $btn = '';
                    if (hasPermission('footer_widget_update')){
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">'.
                        '<a href="javascript:0;" class="dropdown-item category_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCategoryEditModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Edit</a>' .
                        '</div>' .
                        '</div>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'image', 'status', 'info'])
                ->make(true);
        }
        return view('frontend-cms.footer-widget.index');
    }

    public function edit($id){
        $data = FooterWidget::find($id);
        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function update(FooterWidgetUpdateRequest $request){

        try {
            $footerWidget = FooterWidget::find($request->id);
            $footerWidget->title = $request->title;
            $footerWidget->active_status  = $request->status;
            $footerWidget->updated_by = auth()->id();
            $footerWidget->update();
            return response()->json(['message' => 'Footer Widget Updated', 'status' => 200], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

//    public function destroy(Request $request){
//        $validator = $request->validate([
//            'id' => 'required|integer',
//        ]);
//
//        try {
//            $footerWidget = FooterWidget::find($request->id);
//            $footerWidget->delete();
//            return response()->json(['message' => 'Widget Deleted', 'status' => 200], 200);
//        }catch (Exception $e){
//            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
//        }
//    }
}

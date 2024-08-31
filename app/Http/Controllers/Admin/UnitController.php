<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdValidationRequest;
use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Unit::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->is_active == 1) {
                        return '<span class="badge bg-label-success">Active</span>';
                    } else {
                        return '<span class="badge bg-label-danger">Deactive</span>';
                    }
                })
                ->addColumn('info', function ($row) {
                    return dataInfo($row);
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('is_active', $request->get('status'));
                    }
                }, true)
                ->addColumn('action', function ($row) {

                    $btn = '';

                    if (hasPermission('unit_update') || hasPermission('unit_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('unit_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item unit_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasUnitEditModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Edit</a>' .
                            '<div class="dropdown-divider"></div>';
                    }

                    if (hasPermission('unit_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item unit_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'status', 'info'])
                ->make(true);
        }

        return view('unit.index');
    }

    public function store(UnitStoreRequest $request)
    {
        try {

            $attribute = new Unit();
            $attribute->name = $request->name;
            $attribute->is_active = $request->status == '1' ? 1 : 0;
            $attribute->created_by  = Auth::user()->id;
            $attribute->save();

            return response()->json(['message' => 'Unit Created', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function edit($id)
    {
        $unit = Unit::find($id);

        return response()->json(['data' => $unit, 'status' => 200], 200);
    }


    public function update(UnitUpdateRequest $request)
    {
        try {

            $Attribute = Unit::find($request->unit_id);

            $Attribute->name = $request->name;
            $Attribute->is_active = $request->status == '1' ? 1 : 0;
            $Attribute->updated_by = Auth::user()->id;
            $Attribute->save();

            return response()->json(['message' => 'Unit Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function destroy(IdValidationRequest $request)
    {
        try {
            $unit = Unit::find($request->unit_id);

            $unit->delete();
            return response()->json(['text' => 'Unit has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }
}

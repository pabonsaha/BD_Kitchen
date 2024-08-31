<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeStoreRequest;
use App\Http\Requests\AttributeUpdateRequest;
use App\Http\Requests\IdValidationRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class AttributeController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Attribute::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
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
                        $instance->where('status', $request->get('status'));
                    }
                }, true)

                ->addColumn('action', function ($row) {

                    $btn = '';
                    if (hasPermission('attribute_value_create') || hasPermission('attribute_update') || hasPermission('attribute_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('attribute_value_create')) {
                        $btn .= '<a href="' . route('attribute.value.index', $row->id) . '" class="dropdown-item text-primary" data-bs-toggle="tooltip" title="Add attribute value"><i class="ti ti-plus"></i>' . _trans('common.Add') .' '._trans('common.Value') .'</a>';
                    }
                    if (hasPermission('attribute_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item attribute_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBrandEditModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> ' . _trans('common.Edit') . '</a>';
                    }
                    if (hasPermission('attribute_delete')) {
                        $btn .= '<div class="dropdown-divider"></div>' .
                            '<a href="javascript:0;" class="dropdown-item attribute_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> ' . _trans('common.Delete') . '</a>' .
                            '</div>' .
                            '</div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'status', 'info'])
                ->make(true);
        }

        return view('attribute.index');
    }

    public function store(AttributeStoreRequest $request)
    {
        try {

            $attribute = new Attribute();

            $attribute->name = $request->name;
            $attribute->description = $request->description;
            $attribute->status = $request->status == '1' ? 1 : 0;
            $attribute->slug = \Str::slug($request->name);
            $attribute->created_by  = Auth::user()->id;
            $attribute->save();

            return response()->json(['message' => 'Attribute Created', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function edit($id)
    {
        $attribute = Attribute::find($id);

        return response()->json(['data' => $attribute, 'status' => 200], 200);
    }


    public function update(AttributeUpdateRequest $request)
    {
        try {

            $Attribute = Attribute::find($request->attribute_id);

            $Attribute->name = $request->name;
            $Attribute->description = $request->description;
            $Attribute->status = $request->status == '1' ? 1 : 0;
            $Attribute->slug = \Str::slug($request->name);
            $Attribute->updated_by = Auth::user()->id;
            $Attribute->save();

            return response()->json(['message' => 'Attribute Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function destroy(IdValidationRequest $request)
    {
        try {
            $attribute = Attribute::find($request->attribute_id);

            if ($attribute->image != null && $attribute->image) {
                $this->deleteFile($attribute->image);
            }

            $attribute->delete();
            return response()->json(['text' => 'Attribute has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }
}

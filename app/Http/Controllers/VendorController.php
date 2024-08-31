<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdValidationRequest;
use App\Http\Requests\VendorStoreRequest;
use App\Http\Requests\VendorUpdateRequest;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Vendor::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->is_active == 1) {
                        return '<span class="badge bg-label-success">Active</span>';
                    } else {
                        return '<span class="badge bg-label-danger">Deactive</span>';
                    }
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('is_active', $request->get('status'));
                    }
                }, true)
                ->addColumn('action', function ($row) {

                    $btn = '';

                    if (hasPermission('manufacturer_update') || hasPermission('manufacturer_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('manufacturer_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item vendor_edit_button" data-bs-toggle="modal" data-bs-target="#modalCenterEdit" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> ' . _trans('common.Edit') . '</a>';
                    }
                    if (hasPermission('manufacturer_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item vendor_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> ' . _trans('common.Delete') . '</a>' .
                            '</div>' .
                            '</div>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('vendor.index');
    }


    public function store(VendorStoreRequest $request)
    {
        try {

            $vendor = new Vendor();

            $vendor->name = $request->name;
            $vendor->description = $request->description;
            $vendor->address = $request->address;
            $vendor->city = $request->city;
            $vendor->state = $request->state;
            $vendor->postal_code = $request->postal_code;
            $vendor->website = $request->vendor_website;
            $vendor->contact_name = $request->contact_name;
            $vendor->mobile = $request->mobile;
            $vendor->phone = $request->phone;
            $vendor->is_active = $request->status == '1' ? 1 : 0;

            $vendor->save();

            return response()->json(['message' => 'Manufacturer Created', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function edit($id)
    {
        $vendor = Vendor::find($id);

        return response()->json(['data' => $vendor, 'status' => 200], 200);
    }


    public function update(VendorUpdateRequest $request)
    {

        try {

            $vendor = Vendor::find($request->vendor_id);

            $vendor->name = $request->name;
            $vendor->description = $request->description;
            $vendor->address = $request->address;
            $vendor->city = $request->city;
            $vendor->state = $request->state;
            $vendor->postal_code = $request->postal_code;
            $vendor->website = $request->vendor_website;
            $vendor->contact_name = $request->contact_name;
            $vendor->mobile = $request->mobile;
            $vendor->phone = $request->phone;
            $vendor->is_active = $request->status == '1' ? 1 : 0;

            $vendor->save();

            return response()->json(['message' => 'Manufacturer Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function destroy(IdValidationRequest $request)
    {
        try {
            $vendor = Vendor::find($request->vendor_id);

            $vendor->delete();

            return response()->json(['text' => 'Manufacturer has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }
}

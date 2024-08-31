<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Requests\IdValidationRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Brand::select('*')->with('createdBy', 'updatedBy');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return "<img src='" . getFilePath($row->image) . "' alt='' width='50px' height='50px' />";
                })
                ->addColumn('status', function ($row) {
                    if ($row->active_status == 1) {
                        return '<span class="badge bg-label-success">Active</span>';
                    } else {
                        return '<span class="badge bg-label-danger">Deactive</span>';
                    }
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }
                }, true)
                ->addColumn('info', function ($row) {
                    return dataInfo($row);
                })
                ->addColumn('action', function ($row) {

                    $btn = '';

                    if (hasPermission('brand_update') || hasPermission('brand_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('brand_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item brand_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBrandEditModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> ' . _trans('common.Edit') . '</a>';
                    }
                    if (hasPermission('brand_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item brand_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> ' . _trans('common.Delete') . '</a>' .
                            '</div>' .
                            '</div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'image', 'status', 'info'])
                ->make(true);
        }

        return view('brand.index');
    }


    public function store(BrandStoreRequest $request)
    {

        try {

            $brand = new Brand();

            $brand->name = $request->name;
            $brand->description = $request->description;
            $brand->active_status = $request->status == '1' ? 1 : 0;
            $brand->slug = \Str::slug($request->name);
            $brand->created_by  = Auth::user()->id;

            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'brand');
                $brand->image = $path;
            }

            $brand->save();

            return response()->json(['message' => 'Brand Created', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);

        return response()->json(['data' => $brand, 'status' => 200], 200);
    }


    public function update(BrandUpdateRequest $request)
    {
        try {

            $brand = Brand::find($request->brand_id);

            $brand->name = $request->name;
            $brand->description = $request->description;
            $brand->active_status = $request->status == '1' ? 1 : 0;
            $brand->slug = \Str::slug($request->name);
            $brand->updated_by = Auth::user()->id;

            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'brand');

                if ($brand->image) {
                    $this->deleteFile($brand->image);
                }
                $brand->image = $path;
            }

            $brand->save();

            return response()->json(['message' => 'Brand Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function destroy(IdValidationRequest $request)
    {
        try {
            $brand = Brand::find($request->brand_id);

            if ($brand->image != null && $brand->image) {
                $this->deleteFile($brand->image);
            }

            $brand->delete();
            return response()->json(['text' => 'Brand has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }
}

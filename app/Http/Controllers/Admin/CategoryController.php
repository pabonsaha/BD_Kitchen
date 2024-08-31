<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\IdValidationRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Category::select('*')->with('createdBy', 'updatedBy');
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
                    if (hasPermission('category_update') || hasPermission('category_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }


                    // Check if the user has the permission to update the category
                    if (hasPermission('category_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item category_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCategoryEditModal" data-id="' . $row->id . '"><i class="ti ti-edit"></i> ' . _trans('common.Edit') . '</a>';
                    }

                    if (hasPermission('category_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item category_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> ' . _trans('common.Delete') . '</a>' .
                            '</div>' .
                            '</div>';
                    }

                    return $btn;
                })

                ->rawColumns(['action', 'image', 'status', 'info'])
                ->make(true);
        }

        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    public function store(CategoryStoreRequest $request)
    {
        try {

            $category = new Category();

            $category->name = $request->name;
            $category->parent_id = $request->parenet_category_id;
            $category->description = $request->description;
            $category->active_status = $request->status == '1' ? 1 : 0;
            $category->slug = Str::slug($request->name);
            $category->created_by  = Auth::user()->id;

            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'category');
                $category->image = $path;
            }

            $category->save();

            return response()->json(['message' => 'Category Created', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return response()->json(['data' => $category, 'status' => 200], 200);
    }


    public function update(CategoryUpdateRequest $request)
    {

        try {

            $category = Category::find($request->category_id);

            $category->name = $request->name;
            $category->parent_id = $request->parenet_category_id;
            $category->description = $request->description;
            $category->active_status = $request->status == '1' ? 1 : 0;
            $category->slug = \Str::slug($request->name);
            $category->updated_by = Auth::user()->id;

            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'category');

                if ($category->image) {
                    $this->deleteFile($category->image);
                }
                $category->image = $path;
            }

            $category->save();

            return response()->json(['message' => 'Category Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function destroy(IdValidationRequest $request)
    {
        try {
            $category = Category::find($request->category_id);

            if ($category->image) {
                $this->deleteFile($category->image);
            }

            $category->delete();
            return response()->json(['text' => 'Category has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }
}

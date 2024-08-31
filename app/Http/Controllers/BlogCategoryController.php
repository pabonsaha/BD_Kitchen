<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\IdValidationRequest;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogCategory::select('*');
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

                    if (hasPermission('blog_category_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item category_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCategoryEditModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Edit</a>';
                    }
                    if (hasPermission('blog_category_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item category_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'image', 'status'])
                ->make(true);
        }
        return view('blog.category.index');
    }

    public function store(BlogCategoryCreateRequest $request)
    {
        try {
            $blogCategory = new BlogCategory();
            $blogCategory->name = $request->name;
            $blogCategory->slug = Str::slug($request->name);
            $blogCategory->user_id = getUserId();
            $blogCategory->is_active  = $request->status;

            $blogCategory->save();
            return response()->json(['message' => 'Blog Category Created Successfully', 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }

    public function edit($id)
    {
        $blogCategory = BlogCategory::find($id);
        return response()->json(['data' => $blogCategory, 'status' => 200]);
    }

    public function update(BlogCategoryCreateRequest $request)
    {
        try {
            $blogCategory = BlogCategory::find($request->id);
            $blogCategory->name = $request->name;
            $blogCategory->slug = Str::slug($request->name);
            $blogCategory->is_active  = $request->status;
            $blogCategory->update();
            return response()->json(['message' => 'Blog Category Updated Successfully', 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }


    public function destroy(IdValidationRequest $request)
    {

        try {
            $blogCategory = BlogCategory::find($request->id);
            $blogCategory->delete();
            return response()->json(['message' => 'Blog Category Deleted Successfully', 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }

    public function changeStatus(Request $request)
    {
        $data = BlogCategory::find($request->id);
        if ($data) {
            if ($data->is_active == 1) {
                $data->is_active = 0;
            } else {
                $data->is_active = 1;
            }
            $data->save();
            return response()->json(['message' => 'Status Updated Successfully', 'status' => 200]);
        } else {
            return response()->json(['message' => 'Data Not Found!', 'status' => 200]);
        }
    }
}

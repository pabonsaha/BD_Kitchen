<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdValidationRequest;
use App\Http\Requests\SectionStoreRequest;
use App\Http\Requests\SectionUpdateRequest;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploadTrait;
use App\Models\SpecialSection;
use App\Models\SpecialSectionCategory;
use Illuminate\Support\Str;



class SpecialSectionController extends Controller
{
    use FileUploadTrait;
    public function index($section_type, Request $request)
    {
        if ($request->ajax()) {
            $data = SpecialSection::select('*')->where('type', $section_type)->isClient();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return "<img src='" . getFilePath($row->image) . "' alt='' width='50px' height='50px' />";
                })
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
                ->addColumn('info', function ($row){
                    return dataInfo($row);
                })
                ->addColumn('action', function ($row) use ($section_type) {
                    $btn = '<div class="d-inline-block text-nowrap">' .
                        '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                        '<div class="dropdown-menu dropdown-menu-end m-0">';

                    if ($section_type == 1 && hasPermission('read_portfolio_description')) {
                        $btn.='<a href="' . route('section.portfolioAndInspiration.details.create', $row->id) . '" class="dropdown-item btn btn-primary" ><i class="ti ti-file"></i> Description</a>';
                    } elseif ($section_type == 2 && hasPermission('read_inspiration_description')) {
                        $btn.='<a href="' . route('section.portfolioAndInspiration.details.create', $row->id) . '" class="dropdown-item btn btn-primary" ><i class="ti ti-file"></i> Description</a>';
                    }

                    if ($section_type == 1 && hasPermission('portfolio_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item brand_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBrandEditModal" data-id="' . $row->id . '"><i class="ti ti-edit"></i> Edit</a>';
                    } elseif ($section_type == 2 && hasPermission('inspiration_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item brand_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBrandEditModal" data-id="' . $row->id . '"><i class="ti ti-edit"></i> Edit</a>';
                    }

                    if ($section_type == 1 && hasPermission('portfolio_delete')){
                        $btn .= '<a href="javascript:0;" class="dropdown-item brand_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    }else if ($section_type == 2 && hasPermission('inspiration_delete')){
                        $btn .= '<a href="javascript:0;" class="dropdown-item brand_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'image', 'status', 'info'])
                ->make(true);
        }

        $special_categories = SpecialSectionCategory::where('is_active', 1)->get();

        $view = 'section.portfolio.index';
        if ($section_type == 2) {
            $view = 'section.inspiration.index';
        }

        return view($view, compact('special_categories'));
    }

    public function store(SectionStoreRequest $request, $section_type)
    {
        try {

            $spectialSection = new SpecialSection();

            $spectialSection->title = $request->name;
            $spectialSection->is_active = $request->status == '1' ? 1 : 0;
            $spectialSection->slug = Str::slug($request->name);
            $spectialSection->special_section_category_id = $request->category_id;
            $spectialSection->type = $section_type;
            $spectialSection->user_id  = getUserId();
            $spectialSection->created_by  = Auth::user()->id;

            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'portfolioAndInspiration');
                $spectialSection->image = $path;
            }

            $spectialSection->save();

            return response()->json(['message' => 'Section Created', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function edit($section_type, $id)
    {
        $brand = SpecialSection::find($id);

        return response()->json(['data' => $brand, 'status' => 200], 200);
    }


    public function update(SectionUpdateRequest $request, $section_type)
    {

        try {

            $spectialSection = SpecialSection::find($request->section_id);

            $spectialSection->title = $request->name;
            $spectialSection->is_active = $request->status == '1' ? 1 : 0;
            $spectialSection->slug = Str::slug($request->name);
            $spectialSection->special_section_category_id = $request->category_id;

            $spectialSection->updated_by = Auth::user()->id;

            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'portfolioAndInspiration');

                if ($spectialSection->image) {
                    $this->deleteFile($spectialSection->image);
                }
                $spectialSection->image = $path;
            }

            $spectialSection->save();

            return response()->json(['message' => 'Section Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function destroy(IdValidationRequest $request, $section_type)
    {
        try {
            $spectialSection = SpecialSection::find($request->section_id);

            if ($spectialSection->image != null && $spectialSection->image) {
                $this->deleteFile($spectialSection->image);
            }

            $spectialSection->delete();
            return response()->json(['text' => 'Section has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }
}

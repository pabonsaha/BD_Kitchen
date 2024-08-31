<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryStoreRequest;
use App\Http\Requests\GalleryUpdateRequest;
use App\Http\Requests\IdValidationRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\Gallery;
use App\Models\GalleryDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class GalleryController extends Controller
{
    //
    use FileUploadTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Gallery::select('*')->where('user_id', getUserId());
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
                ->addColumn('info', function ($row){
                    return dataInfo($row);
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('is_active', $request->get('status'));
                    }
                }, true)

                ->addColumn('action', function ($row) {

                    $btn = '';

                    if (hasPermission('read_images') || hasPermission('gallery_update') || hasPermission('gallery_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('read_images')) {
                        $btn .= '<a href="' . route('gallery.details.index', $row->id) . '" class="dropdown-item"><i class="ti ti-photo-plus" ></i> Images</a>';
                    }
                    if (hasPermission('gallery_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item brand_edit_button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBrandEditModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Edit</a>';
                    }
                    if (hasPermission('gallery_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item brand_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'image', 'status', 'info'])
                ->make(true);
        }
        return view('gallery.index');
    }

    public function store(GalleryStoreRequest $request)
    {

        try {

            $gallery = new Gallery();

            $gallery->name = $request->name;
            $gallery->is_active = $request->status == '1' ? 1 : 0;
            $gallery->slug = Str::slug($request->name);
            $gallery->user_id = getUserId();
            $gallery->created_by  = Auth::user()->id;

            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'gallery');
                $gallery->image = $path;
            }

            $gallery->save();

            return response()->json(['message' => 'Gallery Created', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function edit($id)
    {
        $gallery = Gallery::find($id);

        return response()->json(['data' => $gallery, 'status' => 200], 200);
    }

    public function update(GalleryUpdateRequest $request)
    {
        try {

            $gallery = Gallery::find($request->gallery_id);

            $gallery->name = $request->name;
            $gallery->is_active = $request->status == '1' ? 1 : 0;
            $gallery->slug = Str::slug($request->name);
            $gallery->updated_by = Auth::user()->id;

            if ($request->hasFile('image')) {
                $path = $this->uploadFile($request->file('image'), 'gallery');

                if ($gallery->image) {
                    $this->deleteFile($gallery->image);
                }
                $gallery->image = $path;
            }

            $gallery->save();

            return response()->json(['message' => 'Gallery Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function destroy(IdValidationRequest $request)
    {
        try {
            $gallery = Gallery::find($request->gallery_id);

            if ($gallery->image != null && $gallery->image) {
                $this->deleteFile($gallery->image);
            }

            $galleryDetails = GalleryDetails::where('gallery_id', $gallery->id)->get();

            foreach ($galleryDetails as $details) {
                if ($details->image != null && $details->image) {
                    $this->deleteFile($gallery->image);
                }

                $details->delete();
            }

            $gallery->delete();
            return response()->json(['text' => 'Gallery has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['text' => "Something went wrong"]);
        }
    }
}

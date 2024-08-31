<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploadTrait;
use App\Models\Gallery;
use App\Models\GalleryDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;


class GalleryDetailsController extends Controller
{
    use FileUploadTrait;

    public function index($gallery_id)
    {
        $gallery = Gallery::with('details')->find($gallery_id);
        return view('gallery.details', compact('gallery'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $existing_ids = [];
            if (isset($request->data)) {

                foreach ($request->data as $key => $gallery) {
                    if (isset($gallery['id']) && $gallery['id'] != null) {
                        $existing_ids[] = $gallery['id'];
                    }
                }

                $details_ids = GalleryDetails::where('gallery_id', $request->gallery_id)->pluck('id')->toArray();

                $result = array_diff($details_ids, $existing_ids);

                $itemsToDelete = GalleryDetails::findMany($result);

                foreach ($itemsToDelete as $item) {
                    if ($item->image) {
                        $this->deleteFile($item->image);
                    }
                    $item->delete();
                }

                foreach ($request->data as $key => $gallery) {
                    $details = new GalleryDetails();
                    if (isset($gallery['id']) && $gallery['id'] != null) {
                        $details = GalleryDetails::find($gallery['id']);
                        $existing_ids[] = $gallery['id'];
                    }
                    $details->title   = $gallery['title'];
                    $details->details  = $gallery['description'];
                    $details->gallery_id  = $request->gallery_id;
                    if (isset($request['data'][$key]['image']) && $request['data'][$key]['image'] != null && $request['data'][$key]['image']) {
                        $path = $this->uploadFile($request['data'][$key]['image'], 'gallery');
                        if ($details->image) {
                            $this->deleteFile($details->image);
                        }
                        $details->image = $path;
                    }
                    $details->save();
                }
            }else
            {
                Toastr::warning('Gallery must have to have one image');
                return redirect()->route('gallery.index');
            }
            DB::commit();

            Toastr::success('Image Of Gallery Successfully');

            return redirect()->route('gallery.index');
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('Something went wrong');
            return redirect()->route('gallery.index');
        }
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery = Gallery::with('details')->where('user_id',getDesignerID())->get();

        return sendResponse('Gallery List.', GalleryResource::collection($gallery));
    }
}

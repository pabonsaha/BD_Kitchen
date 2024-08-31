<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCategoryResource;
use App\Http\Resources\BlogPostDetailsResource;
use App\Http\Resources\BlogPostResource;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BlogPostController extends Controller
{

    public function index()
    {
        try {
            $data = BlogPost::with(["createdBy", "category"])->where('active_status', 1)->where('publish_status', 1)->latest()->paginate(perPage());
            return sendResponse("Blog Post.", BlogPostResource::collection($data)->resource);
        }catch (\Exception){
            return sendError("Something went wrong.");
        }
    }

    public function details($slug){
        try {
            $data = BlogPost::with(["createdBy", "contentDetails.items"])->where('slug', $slug)->first();
            if (!$data){
                return sendError("Blog Post Not Found");
            }
            return sendResponse("Blog Post Details.", new BlogPostDetailsResource($data));
        }catch (\Exception $e){
            return sendError("Something went wrong");
        }
    }

    public function categories(){
        try {
            $categories = BlogCategory::where('is_active', 1)->get();
            return sendResponse("Blog Categories.", BlogCategoryResource::collection($categories));
        }catch (\Exception $e){
            return sendError("Something went wrong");
        }
    }
}

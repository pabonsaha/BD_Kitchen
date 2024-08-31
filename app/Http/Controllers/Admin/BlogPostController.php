<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostCreateRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogPostContentDetail;
use App\Models\BlogPostContentDetailItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use FileUploadTrait;
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = BlogPost::with('createdBy', 'updatedBy')->orderBy('id', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('thumbnail', function ($row) {
                    return "<img src='" . getFilePath($row->thumbnail) . "' alt='' width='50px' height='50px' />";
                })
                //
                ->editColumn('tags', function ($data) {
                    $tags = json_decode($data->tags, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($tags)) {
                        return collect($tags)->map(function ($tag) {
                            return '<span class="badge bg-label-dark me-2">' . htmlspecialchars($tag['value']) . '</span>';
                        })->implode('');
                    } else {
                        return '<span class="badge bg-label-danger">No tags available</span>';
                    }
                })
                //
                ->addColumn('status', function ($row) {
                    $isActive = $row->active_status == 1 ? 'checked' : '';

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
                ->addColumn('publish_status', function ($row) {
                    $ispublished = $row->publish_status == 1 ? 'checked' : '';

                    return '<label class="switch switch-success">
                                <input type="checkbox" class="switch-input changePublishStatus" data-id="' . $row->id . '" ' . $ispublished . ' />
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
                        $instance->where('active_status', $request->get('status'));
                    }
                }, true)
                ->addColumn('author', function ($row) {
                    return dataInfo($row);
                })
                ->addColumn('action', function ($row) {

                    $btn = '';
                    if (hasPermission('blog_post_details') || hasPermission('blog_post_update') || hasPermission('blog_post_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('blog_post_details')) {
                        $btn .= ' <a href="javascript:void(0);" class="dropdown-item details-button" data-id="' . $row->id . '"><i class="ti ti-eye"></i> View</a>';
                    }
                    if (hasPermission('blog_post_update')) {
                        $btn .= '<a href="' . route('blog.post.edit', $row->id) . '" class="dropdown-item assign-user-email-campaign text-primary"><i class="ti ti-settings"></i>Edit</a>';
                    }
                    if (hasPermission('blog_post_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item delete-post text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .

                            '</div>' .
                            '</div>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'thumbnail', 'status','publish_status', 'author', 'tags'])
                ->make(true);
        }
        return view('blog.post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogCategory = BlogCategory::where('is_active', 1)->get();
        return view('blog.post.create', compact('blogCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(BlogPostCreateRequest $request)
    {

        try {

            $nextSerialNum = BlogPost::max('serial_no') + 1;
            $blogPost = new BlogPost();

            $blogPost->title = $request->title;
            $blogPost->serial_no = $nextSerialNum;
            $blogPost->slug = Str::slug($request->title);
            $blogPost->category_id = $request->category_id;
            $blogPost->video_url = $request->video_url;
            $blogPost->tags = $request->tags;
            $blogPost->desc = $request->desc;
            $blogPost->active_status = $request->active_status;
            $blogPost->created_by = Auth::id();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $this->uploadFile($request->file('thumbnail'), 'blog/thumbnails');
                $blogPost->thumbnail = $thumbnailPath;
            }

            if ($request->hasFile('banner')) {
                $bannerPath = $this->uploadFile($request->file('banner'), 'blog/banners');
                $blogPost->banner = $bannerPath;
            }


            $blogPost->save();
            $sectionSerialNum = 1;
            if ($request->has('sections')) {
                foreach ($request->sections as $section) {
                    $contentDetail = new BlogPostContentDetail();
                    $contentDetail->blog_post_id = $blogPost->id;
                    $contentDetail->section_type = $section['type'];
                    $contentDetail->is_active = 1;
                    $contentDetail->serial = $sectionSerialNum;
                    $contentDetail->save();
                    $sectionSerialNum++;

                    $contentDetailItem = new BlogPostContentDetailItem();
                    $contentDetailItem->blog_detail_id = $contentDetail->id;
                    $contentDetailItem->is_active = 1;
                    // $contentDetailItem->serial = $sectionSerialNum;

                    if ($section['type'] == 'description') {
                        $contentDetailItem->description = $section['description'];
                    } elseif ($section['type'] == 'banner_image' && isset($section['image'])) {
                        $contentDetailItem->image = $this->uploadFile($section['image'], 'blog/content_images');
                    }

                    $contentDetailItem->save();
                    // $sectionSerialNum++;
                }
            }

            Toastr::success('Blog Created Successfully');
            return response()->json(['message' => 'Blog Post Created Successfully', 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blogPost = BlogPost::with('contentDetails.items', 'createdBy')->findOrFail($id);
        $blogPost = [
            'id' => $blogPost->id,
            'title' => $blogPost->title,
            'category_id' => $blogPost->category_id,
            'video_url' => getEmbedUrl($blogPost->video_url),
            'tags' => $blogPost->tags,
            'desc' => $blogPost->desc,
            'thumbnail' => getFilePath($blogPost->thumbnail) ? getFilePath($blogPost->thumbnail) : null,
            'banner' => getFilePath($blogPost->banner) ? getFilePath($blogPost->banner) : null,
            'content_details' => $blogPost->contentDetails->map(function ($contentDetail) {
                return [
                    'id' => $contentDetail->id,
                    'section_type' => $contentDetail->section_type,
                    'serial' => $contentDetail->serial,
                    'items' => $contentDetail->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'description' => $item->description,
                            'image' => $item->image ? getFilePath($item->image) : null,
                        ];
                    }),
                ];
            }),
            'active_status' => $blogPost->active_status,
            'created_by' => $blogPost->createdBy->name,
            'created_at' => dateFormatwithTime($blogPost->created_at),
        ];



        return response()->json($blogPost);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $blogPost = BlogPost::with('contentDetails.items')->findOrFail($id);
            $blogCategory = BlogCategory::where('is_active', 1)->get();
            $tempBanner = getFilePath($blogPost->banner);
            $blogPost->thumbnail = getFileElement(getFilePath($blogPost->thumbnail));
            $blogPost->banner = getFileElement(getFilePath($blogPost->banner));
            $tempVariable = (substr($tempBanner, -strlen('img/placeholder/placeholder.png')) === 'img/placeholder/placeholder.png') ? 1 : 0;
            return view('blog.post.edit', compact('blogPost', 'blogCategory', 'tempVariable'));
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostCreateRequest $request, $id)
    {
        try {
            $blogPost = BlogPost::findOrFail($id);

            $blogPost->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'category_id' => $request->category_id,
                'video_url' => $request->video_url,
                'tags' => $request->tags,
                'desc' => $request->desc,
                'active_status' => 1,
                'updated_by' => Auth::id(),
            ]);

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $this->uploadFile($request->file('thumbnail'), 'blog/thumbnails');
                if ($blogPost->thumbnail) {
                    $this->deleteFile($blogPost->thumbnail);
                }
                $blogPost->thumbnail = $thumbnailPath;
            }


            if ($request->isClicked == '1') {
                if ($blogPost->banner) {
                    $this->deleteFile($blogPost->banner);
                    $blogPost->banner = null;
                }
            }

            if ($request->hasFile('banner')) {

                $bannerPath = $this->uploadFile($request->file('banner'), 'blog/banners');
                if ($blogPost->banner) {
                    $this->deleteFile($blogPost->banner);
                }

                $blogPost->banner = $bannerPath;
            }

            $blogPost->save();

            if ($request->has('sections')) {

                $existingContentDetails = BlogPostContentDetail::where('blog_post_id', $blogPost->id)->get()->keyBy('id');
                $existingContentDetailItems = BlogPostContentDetailItem::whereIn('blog_detail_id', $existingContentDetails->keys())->get()->keyBy('id');

                $newContentDetailIds = [];
                // $maxSerial = $existingContentDetailItems->max('serial') ?? 0;
                $maxSerial = $existingContentDetails->max('serial') ?? 0;

                foreach ($request->sections as $section) {
                    $contentDetailId = $section['id'] ?? null;

                    $contentDetail = $contentDetailId && $existingContentDetails->has($contentDetailId)
                        ? $existingContentDetails->get($contentDetailId)
                        : new BlogPostContentDetail(['blog_post_id' => $blogPost->id]);

                    $contentDetail->section_type = $section['type'];
                    $contentDetail->is_active = 1;
                    if (!$contentDetail->exists) {
                        $maxSerial++;
                        $contentDetail->serial = $maxSerial;
                    } else {
                        $contentDetail->serial = $section['serial'] ?? $contentDetail->serial;
                    }
                    $contentDetail->save();

                    $newContentDetailIds[] = $contentDetail->id;

                    $contentDetailItem = $existingContentDetailItems->where('blog_detail_id', $contentDetail->id)->first()
                        ?? new BlogPostContentDetailItem(['blog_detail_id' => $contentDetail->id]);

                    $contentDetailItem->is_active = 1;

                    if ($contentDetail->section_type == 'description') {
                        $contentDetailItem->description = $section['description'] ?? $contentDetailItem->description;
                    } elseif ($contentDetail->section_type == 'banner_image') {
                        if (isset($section['image']) && array_key_exists('image', $section)) {
                            $contentDetailItem->image = $this->uploadFile($section['image'], 'blog/content_images');
                        } else {
                            if ($contentDetailItem->exists) {
                                $contentDetailItem->image = $existingContentDetailItems[$contentDetailItem->id]->image ?? $contentDetailItem->image;
                            }
                        }
                    }

                    $contentDetailItem->save();
                }

                BlogPostContentDetail::where('blog_post_id', $blogPost->id)
                    ->whereNotIn('id', $newContentDetailIds)
                    ->delete();
            }

            Toastr::success('Blog Updated Successfully');
            return response()->json(['message' => 'Blog Post Updated Successfully', 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $data = BlogPost::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['message' => 'Blog post Deleted Successfully', 'status' => 200]);
            } else {
                return response()->json(['message' => 'Data not found!', 'status' => 404]);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }

    public function changeStatus(Request $request)
    {
        $data = BlogPost::find($request->id);
        if ($data) {
            if ($data->active_status == 1) {
                $data->active_status = 0;
            } else {
                $data->active_status = 1;
            }
            $data->save();
            return response()->json(['message' => 'Status Updated Successfully', 'status' => 200]);
        } else {
            return response()->json(['message' => 'Something went wrong!', 'status' => 404]);
        }
    }

    public function changePublishStatus(Request $request)
    {
        $data = BlogPost::find($request->id);
        if ($data) {
            if ($data->publish_status == 1) {
                $data->publish_status = 0;
            } else {
                $data->publish_status = 1;
                $data->publish_at = now();
            }
            $data->save();
            return response()->json(['message' => 'Post Published Successfully', 'status' => 200], 200);
        } else {
            return response()->json(['message' => "Data Not Found!"], 404);
        }
    }
}

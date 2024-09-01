<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Brand;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ShopSetting;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Traits\FileUploadTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\IdValidationRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    use FileUploadTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('category', 'user.role')->isKitchen();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('thumbnail_img', function ($row) {
                    return '<img src="' . getFilePath($row->thumbnail_img) . '" width="50px" height="50px"/>';
                })
                ->addColumn('added_by', function ($row) {
                    return optional($row->user)->name;
                })
                ->addColumn('status', function ($row) {
                    if (hasPermission('product_status_change')) {
                        $isChecked = $row->is_published == 1 ? 'checked' : '';
                        $statusLabel = $row->is_published == 1 ? 'Published' : 'Unpublished';
                        $statusBadgeClass = $row->is_published == 1 ? 'custom-bg-success' : 'custom-bg-danger';

                        return '<div class="custom-status-container">
                    <label class="switch switch-success" style="margin-right: 10px;">
                        <input type="checkbox" class="switch-input changeStatus" data-id="' . $row->id . '" ' . $isChecked . ' />
                        <span class="switch-toggle-slider">
                            <span class="switch-on">
                                <i class="ti ti-check"></i>
                            </span>
                            <span class="switch-off">
                                <i class="ti ti-x"></i>
                            </span>
                        </span>
                    </label>
                    <span class="badge ' . $statusBadgeClass . '">' . $statusLabel . '</span>
                    </div>';
                    }
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('is_published', $request->get('status'));
                    }

                    if ($request->get('category') != '') {
                        $instance->where('category_id', $request->get('category'));
                    }

                    if ($request->get('role') != '') {
                        $instance->whereHas('user.role', function ($query) use ($request) {
                            $query->where('role_id', $request->get('role'));
                        });
                    }

                    if ($request->get('user') != '') {
                        $instance->where('user_id', $request->get('user'));
                    }
                }, true)

                ->editColumn('unit_price', function ($row) {
                    return getPriceFormat($row->unit_price);
                })
                ->addColumn('action', function ($row) {
                    $btn = '';

                    $btn = '<div class="d-inline-block text-nowrap">' .
                        '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                        '<div class="dropdown-menu dropdown-menu-end m-0">';



                    $btn .= '<a href="' . route('admin.product.edit', $row->id) . '" class="dropdown-item product_edit_button"><i class="ti ti-edit"></i> ' . _trans('common.Edit') . '</a>';



                    $btn .= '<a href="javascript:void(0);" class="dropdown-item product_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> ' . _trans('common.Delete') . '</a>' .
                        '</div>' .
                        '</div>';


                    return $btn;
                })

                ->rawColumns(['action', 'thumbnail_img', 'status'])
                ->make(true);
        }

        $categories = Category::all();
        $sellers = User::where('role_id', Role::KITCHEN)->get();

        return view('admin.product.index', compact('categories', 'sellers'));
    }

    public function create()
    {
        $setting = shopSetting();
        $categories = Category::where('active_status', 1)->get();
        return view('admin.product.create', compact('categories', 'setting'));
    }


    public function store(StoreProductRequest $request)
    {

        try {
            DB::beginTransaction();
            $tags = [];
            if ($request->ecommerce_product_tags) {
                $array = json_decode($request->ecommerce_product_tags, true);
                $tags = array_column($array, 'value');
            }



            $specifications = [];

            if ($request['specifications']['title']) {
                foreach ($request['specifications']['title'] as $key => $value) {
                    $arr = [
                        'title' => $value,
                        'details' => $request['specifications']['value'][$key],
                    ];
                    array_push($specifications, $arr);
                }
            }


            $productID = Product::insertGetId([
                'name' => $request->title,
                'slug' => createSlug($request->title),
                'kitchen_id' => getUserId(),
                'category_id' => $request->category,
                'video_link' => $request->video_link,
                'tags' => json_encode($tags),
                'num_of_sale' => 0,
                'description' => $request->description,
                'unit_price' => $request->unit_price,
                'specifications' => json_encode($specifications),
                'shipping_policy' => $request->shipping_policy,
                'disclaimer' => $request->disclaimer,
                'discount_type' => $request->discount_type,
                'discount' => $request->discount_value,
                'meta_title' => $request->mata_title,
                'meta_description' => $request->meta_description,
                'is_published' => $request->status,
            ]);

            $product = Product::find($productID);
            if ($request->hasFile('meta_image')) {
                $path = $this->uploadFile($request->file('meta_image'), 'products/' . $product->id);
                $product->meta_img = $path;
            }
            if ($request->hasFile('thumbnail')) {
                $path = $this->uploadFile($request->file('thumbnail'), 'products/' . $product->id);
                $product->thumbnail_img = $path;
            }

            $product->save();


            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $this->uploadFile($image, 'products/' . $product->id);
                    $productImage = new ProductImage();
                    $productImage->path = $path;
                    $productImage->product_id = $product->id;
                    $productImage->save();
                }
            }



            DB::commit();

            Toastr::success('Product Created Successfully');

            return response()->json(['message' => 'Product Created', 'status' => 200], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function edit($id)
    {

        $product = Product::with('images')->find($id);
        hasPermissionForOperation($product);
        $categories = Category::where('active_status', 1)->get();
        return view('admin.product.edit', compact('categories','product'));
    }

    public function update(UpdateProductRequest $request)
    {
        try {

            $product = Product::find($request->product_id);
            hasPermissionForOperation($product);
            $tags = [];
            if ($request->ecommerce_product_tags) {
                $array = json_decode($request->ecommerce_product_tags, true);
                $tags = array_column($array, 'value');
            }

            $attributes = [];
            if ($request['attributes']) {
                foreach ($request['attributes'] as $attribute) {
                    array_push($attributes, $attribute);
                }
            }

            $variants = [];
            if ($request['attribute_values']) {
                foreach ($request['attribute_values'] as $variant) {
                    $arr = [
                        'attribute_id' => $variant['attribute_id'],
                        'value' => $variant['value'],
                    ];

                    array_push($variants, $arr);
                }
            }

            $weightAndDiamensions = [];
            if ($request->has('weightAndDiamensions')) {
                if ($request['weightAndDiamensions']['title']) {
                    foreach ($request['weightAndDiamensions']['title'] as $key => $value) {
                        $arr = [
                            'title' => $value,
                            'details' => $request['weightAndDiamensions']['details'][$key],
                        ];
                        array_push($weightAndDiamensions, $arr);
                    }
                }
            }

            $specifications = [];
            if ($request->has('specifications')) {
                if ($request['specifications']['title']) {
                    foreach ($request['specifications']['title'] as $key => $value) {
                        $arr = [
                            'title' => $value,
                            'details' => $request['specifications']['value'][$key],
                        ];
                        array_push($specifications, $arr);
                    }
                }
            }

            DB::beginTransaction();
            $product = Product::where('id', $request->product_id)->update([
                'name' => $request->title,
                'slug' => createSlug($request->title),
                'kitchen_id' => getUserId(),
                'category_id' => $request->category,
                'video_link' => $request->video_link,
                'tags' => json_encode($tags),
                'num_of_sale' => 0,
                'description' => $request->description,
                'unit_price' => $request->unit_price,
                'specifications' => json_encode($specifications),
                'shipping_policy' => $request->shipping_policy,
                'disclaimer' => $request->disclaimer,
                'discount_type' => $request->discount_type,
                'discount' => $request->discount_value,
                'meta_title' => $request->mata_title,
                'meta_description' => $request->meta_description,
                'is_published' => $request->status,
            ]);

            $product = Product::find($request->product_id);
            if ($request->hasFile('meta_image')) {
                $path = $this->uploadFile($request->file('meta_image'), 'products/' . $product->id);
                $this->deleteFile($product->meta_img);
                $product->meta_img = $path;
            }
            if ($request->hasFile('thumbnail')) {
                $path = $this->uploadFile($request->file('thumbnail'), 'products/' . $product->id);
                $this->deleteFile($product->thumbnail_img);
                $product->thumbnail_img = $path;
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $this->uploadFile($image, 'products/' . $product->id);
                    $productImage = new ProductImage();
                    $productImage->path = $path;
                    $productImage->product_id = $product->id;
                    $productImage->save();
                }
            }
            $product->save();


            DB::commit();

            Toastr::success('Product Updated');

            return response()->json(['message' => 'Product Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => "Something went wrong"], 500);
        }
    }

    public function destroy(IdValidationRequest $request)
    {
        try {
            $product = Product::find($request->product_id);

            hasPermissionForOperation($product);

            if ($product->thumbnail_img != null && $product->thumbnail_img) {
                $this->deleteFile($product->thumbnail_img);
            }
            if ($product->meta_image != null && $product->meta_image) {
                $this->deleteFile($product->meta_image);
            }

            $product->delete();
            return response()->json(['text' => 'Product has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['message' => "Something went wrong"]);
        }
    }

    public function imageDestroy(IdValidationRequest $request)
    {
        try {
            $productImage = ProductImage::find($request->product_image_id);

            if ($productImage->path != null && $productImage->path) {
                $this->deleteFile($productImage->path);
            }

            $productImage->delete();
            return response()->json(['text' => 'Product Image has been deleted.', 'icon' => 'success']);
        } catch (Exception $e) {
            return response()->json(['message' => "Something went wrong"]);
        }
    }

    public function attributeValueList(Request $request)
    {
        $validated = $request->validate([
            'attibute_ids' => 'array',
            'attibute_ids.*' => 'exists:attributes,id',
        ]);

        $attributes = Attribute::where('status', 1)
            ->with('values')
            ->findMany($request->attibute_ids);

        return response()->json(['message' => 'Attribute List With Value', 'data' => $attributes, 'status' => 200], 200);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);

        try {

            $product = Product::find($request->id);
            $product->is_published = !$product->is_published;
            $product->save();

            return response()->json(['message' => 'Status Updated Successfully', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => "Something went Wrong!"], 500);
        }
    }

    public function user($id)
    {
        $users = User::where('role_id', $id)->get();
        return response()->json(['users' => $users]);
    }
}

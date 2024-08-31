<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ShopInfoUpdateRequest;
use App\Http\Requests\ShopLinkUpdateRequest;
use App\Http\Requests\ShopLogoUpdateRequest;
use App\Http\Requests\UserProfileUpdateRequest;

class UserController extends Controller
{

    use FileUploadTrait;
    /**
     * @param Request $request
     *
     * @return [view and response]
     */
    public function index(Request $request, $roleId)
    {
        if (!in_array($roleId, [Role::DESIGNER, Role::CUSTOMER, Role::MANUFACTURER])) {
            abort(403);
        }
        try {
            $roleName = Role::find($roleId)->name;
        }catch (Exception $e){
            Toastr::error('Invalid Role!');
            return redirect()->route('user.index',Role::CUSTOMER);
        }

        if ($request->ajax()) {
            $data = User::select('*')->where('role_id', $roleId);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('avatar', function ($row) {
                    return "<img src='" . getFilePath($row->avatar) . "' alt='' width='50px' height='50px' />";
                })
                ->editColumn('role_id', function ($row) {
                    if ($row->role_id == Role::SUPER_ADMIN) {
                        return '<span class="badge bg-danger">Super Admin</span>';
                    } else if ($row->role_id == Role::ADMIN) {
                        return '<span class="badge bg-warning">Admin</span>';
                    } else if ($row->role_id == Role::DESIGNER) {
                        return '<span class="badge bg-success">Designer</span>';
                    } else if ($row->role_id == Role::CUSTOMER) {
                        return '<span class="badge bg-primary">Customer</span>';
                    }else if ($row->role_id == Role::MANUFACTURER) {
                        return '<span class="badge bg-info">Manufacturer</span>';
                    }
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }
                }, true)
                ->addColumn('status', function ($row) {
                    if ($row->active_status == 1) {
                        return '<span class="badge bg-label-success">Active</span>';
                    } else {
                        return '<span class="badge bg-label-danger">Deactive</span>';
                    }
                })
                ->addColumn('action', function ($row) use ($roleId) {

                    $btn = '<div class="d-inline-block text-nowrap">' .
                        '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                        '<div class="dropdown-menu dropdown-menu-end m-0">';

                    if ($roleId == Role::CUSTOMER && hasPermission('customers_profile')) {
                        $btn .= '<a href="' . route('user.profile', $row->id) . '" class="dropdown-item"><i class="tf-icons ti ti-id" ></i> Profile</a>';
                    } else if ($roleId == Role::MANUFACTURER && hasPermission('manufacturer_profile')) {
                        $btn .= '<a href="' . route('user.profile', $row->id) . '" class="dropdown-item"><i class="tf-icons ti ti-id" ></i> Profile</a>';
                    } else if ($roleId == Role::DESIGNER && hasPermission('designer_profile')) {
                        $btn .= '<a href="' . route('user.profile', $row->id) . '" class="dropdown-item"><i class="tf-icons ti ti-id" ></i> Profile</a>';
                    }

                    if ($roleId == Role::CUSTOMER && hasPermission('customers_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item user_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    } else if ($roleId == Role::MANUFACTURER && hasPermission('manufacturer_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item user_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    } else if ($roleId == Role::DESIGNER && hasPermission('designer_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item user_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    }


                    return $btn;
                })
                ->rawColumns(['action', 'avatar', 'status', 'role_id'])
                ->make(true);
        }
        return view('user.index', compact('roleId', 'roleName'));
    }


    public function employeeList(Request $request)
    {
        $roleName = 'Employee';
        $roles = Role::whereNotIn('id', [Role::CUSTOMER, Role::SUPER_ADMIN, Role::DESIGNER,Role::MANUFACTURER])->where('active_status',1)->get();

        if ($request->ajax()) {
            $data = User::select('*')->whereNotIn('role_id', [Role::SUPER_ADMIN, Role::CUSTOMER, Role::DESIGNER, Role::MANUFACTURER]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('avatar', function ($row) {
                    return "<img src='" . getFilePath($row->avatar) . "' alt='' width='50px' height='50px' />";
                })
                ->editColumn('role_id', function ($row) {
                    if ($row->role_id == Role::ADMIN) {
                        return '<span class="badge bg-warning">'. $row->role->name .'</span>';
                    } else {
                        return '<span class="badge bg-info">'. $row->role->name .'</span>';
                    }
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
                ->addColumn('action', function ($row) {

                    $btn = '';
                    if (hasPermission('employees_profile') || hasPermission('employees_delete')) {
                        $btn = '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('employees_profile')){
                        $btn.='<a href="' . route('user.profile', $row->id) . '" class="dropdown-item"><i class="tf-icons ti ti-id" ></i> Profile</a>';
                    }
                    if (hasPermission('employees_delete')){
                        $btn.='<a href="javascript:0;" class="dropdown-item user_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                        '</div>' .
                        '</div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action', 'avatar', 'status', 'role_id'])
                ->make(true);
        }
        return view('user.employees', compact('roleName','roles'));
    }

    public function profile(User $user)
    {
        $user = $user->loadCount('products', 'orders', 'shop');
        return view('user.profile', compact('user'));
    }

    /**
     * @param Request $request
     * @param mixed $user_id
     *
     * @return [response]
     */
    public function orders(Request $request, $user_id)
    {
        $data = Order::where('user_id', $user_id)->withCount('items')->with('designer');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('order_date', function ($row) {
                return dateFormat($row->order_date);
            })
            ->addColumn('name', function ($row) {
                return $row->designer->name;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('order.details', $row) . '" class="btn btn-primary text-white px-3 py-2 me-1" >Details</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @param mixed $user_id
     *
     * @return [response]
     */
    public function carts(Request $request, $user_id)
    {
        $data = Cart::where('carts.user_id', $user_id)->with(['designer', 'product']);
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('variation', function ($row) {
                $variation = '';
                foreach ($row->variation as $key => $item) {
                    $variation .= "<span><b class='me-1'>" . $item['attribute'] . ":</b><span class='text-primary'>" . $item['value'] . "</span></span><br>";
                }
                return $variation;
            })
            ->addColumn('thumbnail_img', function ($row) {
                return '<img src="' . getFilePath($row->product->thumbnail_img) . '" width="50px" height="50px"/>';
            })
            ->addColumn('product_name', function ($row) {
                return $row->product->name;
            })
            ->addColumn('designer', function ($row) {
                return $row->designer->name;
            })
            ->addColumn('action', function ($row) use ($user_id) {

                $btn = '<a href="#" class="btn btn-success text-white" >View Product</a>';

                return $btn;
            })
            ->rawColumns(['action', 'thumbnail_img', 'variation'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @param mixed $user_id
     *
     * @return [response]
     */
    public function wishlist(Request $request, $user_id)
    {
        $data = Wishlist::where('wishlists.user_id', $user_id)->with('product');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('thumbnail_img', function ($row) {
                return '<img src="' . getFilePath($row->product->thumbnail_img) . '" width="50px" height="50px"/>';
            })
            ->addColumn('product_name', function ($row) {
                return $row->product->name;
            })
            ->addColumn('action', function ($row) {
                $btn =  '<a href="#" class="btn btn-primary text-white px-3 py-2 me-1" >View Product</a>';
                return $btn;
            })
            ->rawColumns(['action', 'thumbnail_img'])
            ->make(true);
    }

    public function products(Request $request, $user_id)
    {
        $data = Product::select('*')->where('user_id', $user_id);

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('thumbnail_img', function ($row) {
                return '<img src="' . getFilePath($row->thumbnail_img) . '" width="50px" height="50px"/>';
            })
            ->addColumn('status', function ($row) {
                if ($row->is_published == 1) {
                    return '<span class="badge bg-label-success">Published</span>';
                } else {
                    return '<span class="badge bg-label-danger">Unpublished</span>';
                }
            })
            ->editColumn('unit_price', function ($row) {
                return getPriceFormat($row->unit_price);
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="d-inline-block text-nowrap">' .
                    '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                    '<div class="dropdown-menu dropdown-menu-end m-0">' .
                    '<a href="' . route('product.edit', $row->id) . '" class="dropdown-item product_edit_button"><i class="ti ti-edit" ></i> Edit</a>' .
                    '<a href="javascript:0;" class="dropdown-item product_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                    '</div>' .
                    '</div>';

                return $btn;
            })
            ->rawColumns(['action', 'thumbnail_img', 'status'])
            ->make(true);
    }



    public function passwordReset(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',
            'user_id' => 'exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        }

        try {

            $user = User::find($request->user_id);

            $user->password = Hash::make($request->password);

            $user->save();

            return response()->json(['message' => 'Password Changed Successfully', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }


    public function update(UserProfileUpdateRequest $request)
    {
        try {
            $user = User::find($request->user_id);

            $user->name = $request->name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            if ($request->hasFile('avatar')){

                $path = $this->uploadFile($request->file('avatar'), 'user');
                if ($user->avatar){
                    $this->deleteFile($user->avatar);
                }
                $user->avatar = $path;
            }

            $user->save();

            return response()->json(['message' => 'User Information Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }


    /**
     * @return [boolean]
     */
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 403], 200);
        }

        try {

            $user = User::find($request->user_id);

            $user->active_status = !$user->active_status;

            $user->save();

            return response()->json(['text' => 'User Status Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function shopInfoUpdate(ShopInfoUpdateRequest $request)
    {
        try {
            $shop_setting = ShopSetting::where('user_id', $request->user_id)->first();

            $shop_setting->shop_name = $request->shop_name;

            $shop_setting->location = $request->address;
            $shop_setting->phone = $request->phone;
            $shop_setting->email = $request->email;
            $shop_setting->map_location = $request->map_location;
            $shop_setting->save();

            // Toastr::success('General Setting Updated');
            return response()->json(['message' => 'Shop Setting Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function shoplogoUpdate(ShopLogoUpdateRequest $request)
    {

        $general_setting = ShopSetting::where('user_id', $request->user_id)->first();

        try {
            if ($request->hasFile('light_logo')) {
                $path = $this->uploadFile($request->file('light_logo'), 'designer/' . $general_setting->user_id . '/icon');

                if ($general_setting->logo) {
                    $this->deleteFile($general_setting->logo);
                }
                $general_setting->logo = $path;
            }
            if ($request->hasFile('banner')) {

                $path = $this->uploadFile($request->file('banner'), 'designer/' . $general_setting->user_id . '/icon');
                if ($general_setting->banner) {
                    $this->deleteFile($general_setting->banner);
                }
                $general_setting->banner = $path;
            }
            if ($request->hasFile('favicon')) {

                $path = $this->uploadFile($request->file('favicon'), 'designer/' . $general_setting->user_id . '/icon');
                if ($general_setting->favicon) {
                    $this->deleteFile($general_setting->favicon);
                }
                $general_setting->favicon = $path;
            }

            $general_setting->save();

            return response()->json(['message' => 'Shop Logo Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function shoplinkUpdate(ShopLinkUpdateRequest $request)
    {
        try {
            $general_setting = ShopSetting::where('user_id',$request->user_id)->first();

            $general_setting->twitter_url = $request->twitter;
            $general_setting->facebook_url = $request->facebook;
            $general_setting->instagram_url = $request->instagram;
            $general_setting->linkedin = $request->linkedin;
            $general_setting->youtube_url = $request->youtube;
            $general_setting->tiktok_url = $request->tiktok;

            $general_setting->save();

            return response()->json(['message' => 'Social Link Updated', 'status' => 200], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500], 500);
        }
    }

    public function store(UserStoreRequest $request)
    {

        try {
            $user = new User();
            $user->name = $request->name;
            $user->role_id = $request->role;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->active_status = $request->status;

            if ($request->hasFile('avatar')) {
                $path = $this->uploadFile($request->file('avatar'), 'user');
                $user->avatar = $path;
            }
            $user->save();
            Toastr::success('User created Successfully');
        }catch (Exception $e){
            Toastr::error('Something went wrong!');
        }
        return back();
    }


    public function destroy(Request $request)
    {
        try {
            $data = User::find($request->user_id);
            if ($data->image) {
                $this->deleteFile($data->image);
            }
            $data->delete();
        }catch (Exception $e){
            Toastr::error('Something Went Wrong!');
        }
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // index
    public function designers(Request $request)
    {
        $designers = User::where('role_id', 3)
            ->where('active_status', 1)
            ->with('shop')
            ->withCount('products','portfolio','inspiration')
            ->paginate(perPage());

        return sendResponse('Designer list.', UserResource::collection($designers)->resource);
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $data = Faq::where('active_status', 1)->get();
        return sendResponse('Faq List.', FaqResource::collection($data)->resource);
    }
}

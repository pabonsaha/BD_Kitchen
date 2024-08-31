<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialSectionListResource;
use App\Http\Resources\SpecialSectionResource;
use App\Models\SpecialSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialSectionController extends Controller
{
    //

    public function list(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:1,2|integer',
        ]);
        if ($validator->fails()) {
            return sendError('Validation Error', $validator->errors(), 403);
        }
        $specialSections = SpecialSectionListResource::collection(SpecialSection::with('category')
            ->where('type', $request->type)
            ->where('is_active', 1)
            ->where('user_id', getDesignerID())
            ->paginate(perPage()))
            ->resource;

        return sendResponse('Special Section List.', $specialSections);
    }

    public function details($section_id)
    {
        $specialSection = SpecialSection::with(['category', 'details.items'])
            ->where('is_active', 1)
            ->where('id', $section_id)
            ->where('user_id', getDesignerID())
            ->first();

        return sendResponse('Special Section List.', new SpecialSectionResource($specialSection));
    }
}

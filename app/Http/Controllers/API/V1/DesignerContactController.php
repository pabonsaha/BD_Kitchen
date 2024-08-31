<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignerConntactRequest;
use App\Models\DesignerContact;
use Exception;
use Illuminate\Http\Request;

class DesignerContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesignerConntactRequest $request)
    {
        $existingContact = DesignerContact::where('email', $request->email)
            ->where('message', $request->message)
            ->where('designer_id', $request->designer_id)
            ->first();

        if ($existingContact) {
            return sendResponse('Designer contact already sent', null, 409);
        }
        try {
            $designerContact = new DesignerContact();
            $designerContact->name       = $request->name;
            $designerContact->designer_id = $request->designer_id;
            $designerContact->email      = $request->email;
            $designerContact->phone      = $request->phone;
            $designerContact->message    = $request->message;
            $designerContact->active_status = 0;
            $designerContact->save();

            return sendResponse('Designer Contact Request Send Successfully', null, 200);
        } catch (Exception $e) {
            return sendError($e->getMessage(), 'Something Went Wrong!', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

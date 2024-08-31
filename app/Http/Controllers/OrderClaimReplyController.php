<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploadTrait;
use App\Models\Order;
use App\Models\OrderClaimReply;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderClaimReplyController extends Controller
{
    use FileUploadTrait;

    public function store(Request $request){
        $request->validate([
            'message' => 'required',
            'order_claim_id' => 'required',
            'file' => 'sometimes|file|mimes:jpg,jpeg,png,gif,pdf,docx,csv,xlsx|max:2048', // Optional file validation
        ]);

        try {
            $data = new OrderClaimReply();
            $data->user_id = Auth::user()->id;
            $data->order_claim_id = $request->order_claim_id;
            $data->details = $request->message;
            $data->created_by = Auth::user()->id;

            if ($request->hasFile('file')) {
                $path = $this->uploadFile($request->file('file'), 'order-claim-reply');
                $data->file = $path;
            }
            $data->save();
            Toastr::success('Message sent successfully!');
        } catch (Exception $e) {
            Toastr::error('Something went wrong');
        }

        return back();
    }
}

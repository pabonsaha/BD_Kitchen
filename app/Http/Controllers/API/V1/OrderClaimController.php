<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderClaim;
use Illuminate\Http\Request;
use App\Models\OrderClaimReply;
use App\Models\OrderClaimIssueType;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderClaimRequest;
use App\Http\Resources\ClaimTypeResource;
use App\Http\Resources\OrderClaimResource;
use App\Http\Resources\ClaimDetailResource;

class OrderClaimController extends Controller
{
    use FileUploadTrait;

    public function claimOrder(OrderClaimRequest $request){
        try {
            $orderClaim = new OrderClaim();
            $orderClaim->order_id = $request->order_id;
            $orderClaim->user_id = Auth::user()->id;
            $orderClaim->order_claim_issue_type_id = $request->claim_issue_type_id;
            $orderClaim->subject = $request->subject;
            $orderClaim->details = $request->details;

            if ($request->hasFile('file')){
                $path = $this->uploadFile($request->file('file'), 'order-claim');
                $orderClaim->file = $path;
            }

            $orderClaim->date_time = Carbon::now();
            $orderClaim->created_by = Auth::user()->id;
            $orderClaim->save();
            return sendResponse('Order Claimed Successfully');
        }catch (Exception $e){
            return  $e;
            return sendError('Something Went Wrong!');
        }
    }

    public function claims($order_id){
        try {
            $orderClaims = OrderClaim::where('order_id', $order_id)
                ->where('user_id', Auth::user()->id)
                ->with(['user', 'order', 'orderClaimIssueType', 'createdBy', 'updatedBy'])
                ->paginate(perPage());

            return sendResponse('Order Claims.', OrderClaimResource::collection($orderClaims)->resource);
        }catch (Exception){
            return sendError('Something Went Wrong!');
        }
    }

    public function claimReply($claim_id, Request $request){
        $orderClaim = OrderClaim::find($claim_id);
        if ($orderClaim->user_id != Auth::user()->id){
            return sendError('Unauthorized!');
        }
        try {
            $data = new OrderClaimReply();
            $data->user_id = Auth::user()->id;
            $data->order_claim_id = $claim_id;
            $data->details = $request->message;
            $data->created_by = Auth::user()->id;
            if ($request->hasFile('file')) {
                $path = $this->uploadFile($request->file('file'), 'order-claim-reply');
                $data->file = $path;
            }
            $data->save();
            return sendResponse('Message Send Successfully');
        }catch (Exception $e){
            return sendError('Something Went Wrong!');
        }
    }

    public function claimsByUser(){
        try {
            $data = OrderClaim::where('user_id', Auth::user()->id)->paginate(perPage());
            return sendResponse('Order Claims.', OrderClaimResource::collection($data)->resource);
        } catch (Exception $e) {
            return sendError('Something Went Wrong!');
        }
    }

    // claimDetails
    public function claimDetails($claim_id){
        try {
            $data = OrderClaim::where('id', $claim_id)
                ->where('user_id', Auth::user()->id)
                ->with(['user', 'order', 'orderClaimIssueType', 'createdBy', 'updatedBy'])
                ->first();

            if ($data == null){
                return sendError('Order Claim Not Found!');
            }

            return sendResponse('Order Claim details', new ClaimDetailResource($data));
        } catch (Exception $e) {
            return sendError('Something Went Wrong!');
        }
    }
    // types
    public function types(){
        try {
            $data = OrderClaimIssueType::where('active_status', 1)->get();
            return sendResponse('Order Claim Types.', ClaimTypeResource::collection($data));
        } catch (Exception $e) {
            return sendError('Something Went Wrong!');
        }
    }
}

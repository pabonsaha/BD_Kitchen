<?php

namespace App\Http\Controllers;

use App\Mail\DesignerContactReply;
use App\Models\DesignerContact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class DesignerContactController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DesignerContact::with('designer.shop');
            if (Auth::user()->role_id == 3) {
                $query->where('designer_id', Auth::user()->id);
            }

            $data = $query;
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('designer_name', function ($row) {
                    if ($row->designer && $row->designer->shop) {
                        return $row->designer->name . ' (' . $row->designer->shop->shop_name . ')';
                    } elseif ($row->designer) {
                        return $row->designer->name . ' (N/A)';
                    } else {
                        return 'N/A';
                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->active_status == 1) {
                        return '<span class="badge bg-label-success">Replied</span>';
                    } else {
                        return '<span class="badge bg-label-danger">Pending</span>';
                    }
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1' || $request->get('status') == '2') {
                        $instance->where('active_status', $request->get('status'));
                    }
                }, true)
                ->addColumn('action', function ($row) {

                    $btn = '';

                    $btn = '<div class="d-inline-block text-nowrap">' .
                        '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                        '<div class="dropdown-menu dropdown-menu-end m-0">';

                    $btn .= '<a href="javascript:0;" class="dropdown-item reply_button" data-bs-toggle="modal" data-bs-target="#replyModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Reply</a>';

                    $btn .= '<a href="javascript:0;" class="dropdown-item delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                        '</div>' .
                        '</div>';

                    return $btn;
                })
                ->rawColumns(['action', 'description', 'status'])
                ->make(true);
        }
        return view('designer-contact.index');
    }


    public function destroy(Request $request)
    {
        try {
            $data = DesignerContact::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['message' => 'Designer Contact Deleted Successfully', 'status' => 200]);
            } else {
                return response()->json(['message' => "Data not found!"], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }



    public function getDesignerContact($id)
    {
        $data = DesignerContact::find($id);
        if ($data) {
            return response()->json(['data' => $data, 'status' => 200]);
        }
        return response()->json(['message' => 'Something went wrong!', 'status' => 404]);
    }



    public function sendReply(Request $request)
    {

        $data = [
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        try {
            Mail::to($request->to_email)->send(new DesignerContactReply($data));

            $contact = DesignerContact::where('email', $request->to_email)->first();
            if ($contact) {
                $contact->active_status = 1;
                $contact->save();
            }

            return response()->json(['message' => 'Reply Send Successfully', 'status' => 200]);
        } catch (Exception $e) {

            $contact = DesignerContact::where('email', $request->to_email)->first();
            if ($contact) {
                $contact->active_status = 0;
                $contact->save();
            }

            return response()->json(['message' => 'Something went wrong', 'status' => 500] );
        }
    }
}

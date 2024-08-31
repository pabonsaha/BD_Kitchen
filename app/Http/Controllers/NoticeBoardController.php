<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseCreateRequest;
use App\Http\Requests\NoticeCreateRequest;
use App\Http\Requests\NoticeUpdateRequest;
use App\Models\NoticeBoard;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\FileUploadTrait;
use App\Models\ContactUs;
use App\Models\NoticeType;
use App\Models\Role;
use App\Models\Subscriber;
use App\Models\User;

class NoticeBoardController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NoticeBoard::select('*')->with('createdBy', 'updatedBy', 'noticeType');
            return DataTables::of($data)
                ->addIndexColumn()
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
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block text-nowrap">' .
                        '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                        '<div class="dropdown-menu dropdown-menu-end m-0">' .
                        '<a href="javascript:void(0);" class="dropdown-item edit-notice" data-id="' . $row->id . '"><i class="ti ti-pencil"></i> Edit</a>' .
                        '<a href="javascript:void(0);" class="dropdown-item delete-notice text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                        '<a href="' . route('notice-board.notice.assign', $row->id) . '" class="dropdown-item assign-user-email-campaign text-primary"><i class="ti ti-users"></i>Assign Recievers</a>';


                    $btn .= '</div></div>';

                    return $btn;
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }
                }, true)

                ->addColumn('created_by', function ($row) {
                    return dataInfo($row);
                })
                ->editColumn('attachment', function ($row) {
                    return getFileElement(getFilePath($row->attachment));
                })
                ->addColumn('published_at', function ($row) {
                    return $row->published_at ? dateFormatwithTime($row->published_at) : '---';
                })
                ->addColumn('type', function ($row) {
                    return $row->noticeType ? $row->noticeType->name : 'N/A';
                })
                ->rawColumns(['status', 'action', 'created_by', 'attachment'])
                ->make(true);
        }

        $types = NoticeType::where('is_active', 1)->get();

        return view('notice-board.notice.index', compact('types'));
    }

    public function store(NoticeCreateRequest $request)
    {

        try {
            $notice = new NoticeBoard();
            $notice->title = $request->title;
            $notice->type_id = $request->notice_type;
            $notice->active_status = 0;
            $notice->published_at = null;
            $notice->description = $request->description;
            $notice->created_by = Auth::id();
            if ($request->hasFile('attachment')) {
                $path = $this->uploadFile($request->file('attachment'), 'notices');
                $notice->attachment = $path;
            }
            $notice->save();
            return response()->json(['message' => 'Notice Created Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }

    public function edit($id)
    {
        $notice = NoticeBoard::findOrFail($id);
        $notice->attachment_element = getFileElement(getFilePath($notice->attachment));
        return response()->json([
            'id' => $notice->id,
            'title' => $notice->title,
            'attachment' => $notice->attachment_element,
            'published_at' => $notice->published_at,
            'description' => $notice->description,
            'notice_type' => $notice->type_id,
            'active_status' => $notice->active_status,
        ]);
    }

    public function update(NoticeUpdateRequest $request)
    {
        try {
            $notice = NoticeBoard::findOrFail($request->id);
            $notice->title = $request->title;
            $notice->description = $request->description;
            $notice->type_id = $request->notice_type;

            if ($request->hasFile('attachment')) {
                $path = $this->uploadFile($request->file('attachment'), 'notices');
                if ($notice->attachment) {
                    $this->deleteFile($notice->attachment);
                }
                $notice->attachment = $path;
            }
            $notice->updated_by = Auth::id();
            $notice->save();
            return response()->json(['message' => 'Notice updated successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }

    public function changeStatus(Request $request)
    {
        $data = NoticeBoard::find($request->id);

        if ($data) {
            if (is_null($data->receivers)) {
                return response()->json([
                    'message' => 'Failed!, No receivers were assigned.',
                    'status' => 400
                ]);
            }

            if ($data->active_status == 1) {
                $data->active_status = 0;
            } else {
                $data->active_status = 1;
            }

            $data->save();

            return response()->json([
                'message' => 'Status updated successfully',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong!',
                'status' => 404
            ]);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $data = NoticeBoard::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['message' => 'Notice Deleted Successfully', 'status' => 200]);
            } else {
                return response()->json(['message' => 'Data not found!', 'status' => 404]);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }


    // public function assign($id)
    // {
    //     $notice = NoticeBoard::findOrFail($id);

    //     $types = Role::where('active_status', 1)
    //         ->where('id', '!=', 1)
    //         ->get();

    //     return view('notice-board.assign-receiver.index', compact('notice', 'types'));
    // }

    public function assign($id)
{
    $notice = NoticeBoard::findOrFail($id);

    $types = Role::where('active_status', 1)
        ->where('id', '!=', 1)
        ->get();

    $receiversIds = json_decode($notice->receivers ?? '[]', true);

    $selectedUsers = User::whereIn('id', $receiversIds)->get(['id', 'name', 'email']);

    $formattedUsers = $selectedUsers->map(function ($user) {
        return [
            'id' => $user->id,
            'label' => $user->name . ' (' . $user->email . ')',
            'email' => $user->email
        ];
    });

    return view('notice-board.assign-receiver.index', compact('notice', 'types', 'formattedUsers'));
}





    public function getUsersByType(Request $request)
    {
        $type = $request->type;
        $users = [];

        if ($type) {
            $users = User::where('role_id', $type)
                ->where('active_status', 1)
                ->get(['id', 'name', 'email']);
        }

        $formattedUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'label' => $user->name . ' (' . $user->email . ')',
                'email' => $user->email
            ];
        });

        return response()->json($formattedUsers);
    }


    public function updateNoticeBoardReceivers(Request $request, $id)
    {
        try {
            $notice = NoticeBoard::findOrFail($id);
            $selectedReceivers = $request->receivers ?? [];
            $notice->receivers = json_encode($selectedReceivers);
            $notice->updated_by = Auth::id();
            $notice->save();

            return response()->json(['message' => 'User Assigned Successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }


    public function getUsersByIds(Request $request)
    {
        $ids = $request->input('ids');
        $users = User::whereIn('id', $ids)->get(['id', 'name', 'email']);
        return response()->json($users);
    }
}

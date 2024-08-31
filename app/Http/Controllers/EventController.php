<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\ContactUs;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Role;
use App\Models\Subscriber;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Event::with('eventType')->where('user_id', getUserId());
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row){
                    return $row->name;
                })

                ->addColumn('event_type', function ($row){
                    return $row->eventType->name;
                })

                ->editColumn('start_date', function ($row){
                    return dateFormatwithTime($row->start_date);
                })

                ->editColumn('end_date', function ($row){
                    return dateFormatwithTime($row->end_date);
                })

                ->editColumn('event_url', function ($row){
                    return '<a href="'.$row->event_url.'" target="_blank">'.$row->event_url.'</a>';
                })

                ->editColumn('location', function ($row){
                    return $row->location;
                })

                ->editColumn('file', function ($row) {
                    return getFileElement(getFilePath($row->file));
                })

                ->editColumn('description', function ($row){
                    return $row->description;
                })
                ->addColumn('status', function ($row) {
                    if (hasPermission('event_change_status')) {
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
                    }
                    return '';
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }

                    if ($request->get('type') != ''){
                        $instance->where('event_type_id', $request->get('type'));
                    }

                }, true)
                ->addColumn('action', function ($row) {

                    $btn = '';
                    if (hasPermission('event_update') || hasPermission('event_delete')) {
                        $btn .= '<div class="d-inline-block text-nowrap">' .
                            '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical me-2"></i></button>' .
                            '<div class="dropdown-menu dropdown-menu-end m-0">';
                    }

                    if (hasPermission('event_update')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item type_edit_button" data-bs-toggle="modal" data-bs-target="#editEventModal" data-id="' . $row->id . '"><i class="ti ti-edit" ></i> Edit</a>';
                    }

                    if (hasPermission('assign_user_read')) {
                        $btn .= '<a href="' . route('event-management.event.assign-user', $row->id) . '" class="dropdown-item text-primary"><i class="ti ti-user-cog"></i>Assign Audience</a>';
                    }

                    if (hasPermission('event_delete')) {
                        $btn .= '<a href="javascript:0;" class="dropdown-item type_delete_button text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>' .
                            '</div>' .
                            '</div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action','status', 'event_url', 'file'])
                ->make(true);
        }

        $eventTypes = EventType::where('active_status', 1)
            ->where('user_id', getUserId())->get();

        return view('event-management.event.index', compact('eventTypes'));
    }

    public function store(EventStoreRequest $request)
    {
        try {
            $event = new Event();
            $event->name          = $request->name;
            $event->event_type_id = $request->event_type;
            $event->user_id       = getUserId();
            $event->start_date    = $request->start_date;
            $event->end_date      = $request->end_date;
            $event->event_url     = $request->event_url;
            $event->location      = $request->location;
            $event->description   = $request->description;
            $event->active_status = $request->active_status;

            if ($request->hasFile('file')){
                $event->file = $this->uploadFile($request->file('file'), 'event');;
            }
            $event->save();
            Toastr::success("Event Created Successfully", 'success');
        }catch (\Exception $e){
            Toastr::error("Something Went Wrong", 'error');
        }
        return back();
    }

    public function edit($id){
        try {
            $data = Event::where('id', $id)
                ->where('user_id', getUserId())->first();
            if ($data->file){
                $data->file = getFileElement(getFilePath($data->file));
            }
            return response()->json(['data' => $data, 'status' => 200], 200);
        }catch (\Exception $e){
            return response()->json(["message" => "Something Went Wrong!", 'status'=> 500]);
        }
    }

    public function update(EventStoreRequest $request)
    {
        try {
            $data = Event::where('id', $request->event_id)
                ->where('user_id', getUserId())->first();

            $data->name          = $request->name;
            $data->event_type_id = $request->event_type;
            $data->start_date    = $request->start_date;
            $data->end_date      = $request->end_date;
            $data->event_url     = $request->event_url;
            $data->location      = $request->location;
            $data->description   = $request->description;
            $data->active_status = $request->active_status;

            if ($request->hasFile('file')){
                $this->deleteFile($data->file);
                $data->file = $this->uploadFile($request->file('file'), 'event');;
            }
            $data->save();
            Toastr::success('success', 'Event Updated Successfully');
        }catch (\Exception $e){
            Toastr::error('error', 'Something went wrong!');
        }
        return back();
    }

    public function delete(Request $request)
    {
        try {
            $data = Event::where('id', $request->id)->where('user_id', getUserId())->first();
            $data->delete();
            return response()->json(['message' => 'Event Deleted Successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something Went Wrong!', 'status' => 500]);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $data = Event::where('id', $request->id)->where('user_id', getUserId())->first();
            $data->active_status = !$data->active_status;
            $data->save();
            return response()->json(['message' => 'Status Updated Successfully', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message'=> 'Something Went Wrong!', 'status' => 500]);
        }
    }

    public function assignUser($event_id)
    {
        try {
            // find event
            $event = Event::where([['id', $event_id], ['user_id', getUserId()]])->first();
            if ($event){
                $types = Role::where('id', '!=', 1)->get();
                $subscribers = Subscriber::all();
                $contact_requests = ContactUs::all();

                $users = [];
                if ($event->guest_user_ids) {
                    $guest_user_ids = json_decode($event->guest_user_ids);
                    $users = User::whereIn('id', $guest_user_ids)->get();
                }

                if ($event->file){
                    $event->file = getFileElement(getFilePath($event->file));
                }

                return view('event-management.assign-user.index', compact('event', 'types', 'subscribers', 'contact_requests', 'users'));
            }
        }catch (\Exception $e){
            Toastr::error("Something Went Wrong!", 'Error');
        }
        return back();
    }


    public function getUsersByType(Request $request)
    {
        try {
            $type = $request->input('type');
            $users = [];

            $role = Role::find($type);
            if ($role) {
                $users = $role->users()->select('name', 'email', 'id')->get()->toArray();
            }

            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(["message" => "Something Went Wrong!", 'status' => 500]);
        }
    }

    public function updateEventWithUser(Request $request, $id)
    {
        try {
            $campaign = Event::findOrFail($id);
            $selectedUserIds = $request->input('users', []);

            $campaign->guest_user_ids = json_encode($selectedUserIds);
            $campaign->save();

            return response()->json(['message' => 'Event Updated Successfully', 'status' => 200], 200);
        }catch (\Exception $e){
            return response()->json(["message" => "Something Went Wrong!", 'status' => 500]);
        }

    }


    public function calender(){
        return view('event-management.calender');
    }

    // calenderEvents

    public function calenderEvents(Request $request){
        $events = Event::where('user_id', getUserId())->get();
        $data = [];
        foreach ($events as $event){
            $data[] = [
                'id' => $event->id,
                'title' => $event->name,
                'type' =>$event->eventType->name,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'url' => $event->event_url,
                'location' => $event->location,
                'description' => $event->description,
            ];
        }
        return sendResponse('Event List', $data);
    }
}

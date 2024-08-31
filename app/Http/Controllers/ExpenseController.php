<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Requests\IdValidationRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\ExpenseType;
use Exception;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    use FileUploadTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Expense::select('*')->with('createdBy', 'updatedBy', 'expenseType');

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
                        '<a href="javascript:void(0);" class="dropdown-item edit-expense" data-id="' . $row->id . '"><i class="ti ti-pencil"></i> Edit</a>' .
                        '<a href="javascript:void(0);" class="dropdown-item delete-expense text-danger" data-id="' . $row->id . '"><i class="ti ti-trash"></i> Delete</a>';


                    $btn .= '</div></div>';

                    return $btn;
                })
                ->addColumn('type', function ($row) {
                    return $row->expenseType ? $row->expenseType->name : '-';
                })

                ->addColumn('expense_date', function ($row) {
                    return $row->expense_date ? dateFormat($row->expense_date) : '-';
                })
                ->addColumn('amount', function ($row) {
                    return getPriceFormat($row->amount);
                })

                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('active_status', $request->get('status'));
                    }
                    if ($request->get('type')) {
                        $instance->where('type_id', $request->get('type'));
                    }
                }, true)

                ->addColumn('created_by', function ($row) {
                    return dataInfo($row);
                })
                ->editColumn('voucher', function ($row) {
                    return getFileElement(getFilePath($row->voucher));
                })

                ->rawColumns(['status', 'action', 'created_by', 'voucher'])
                ->make(true);
        }

        $expenseTypes = ExpenseType::where('is_active', 1)->get();

        return view('expense-management.expenses.index', compact('expenseTypes'));
    }


    public function store(StoreExpenseRequest $request)
    {

        try {

            $expense = new Expense();
            $expense->title = $request->title;
            $expense->type_id = $request->expense_type;
            $expense->active_status = $request->active_status;
            $expense->amount = $request->amount;
            if ($request->hasFile('voucher')) {
                $path = $this->uploadFile($request->file('voucher'), 'expense_vouchers');
                $expense->voucher = $path;
            }
            $expense->expense_date = $request->expense_date;
            $expense->details = $request->details;
            $expense->created_by = auth()->id();
            $expense->save();

            return response()->json(['message' => 'Expense created successfully.', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong.', 'status' => 500]);
        }
    }

    public function edit($id)
    {

        $expense = Expense::findOrFail($id);
        $expenseTypes = ExpenseType::where('is_active',1)->get();
        $expense->attachment_element = getFileElement(getFilePath($expense->voucher));

        return response()->json([
            'id' => $expense->id,
            'title' => $expense->title,
            'amount' => $expense->amount,
            'voucher' => $expense->attachment_element,
            'expense_date' => $expense->expense_date,
            'details' => $expense->details,
            'expense_type' => $expense->type_id,
            'active_status' => $expense->active_status,
            'expenseTypes' => $expenseTypes
        ]);
    }


    public function update(UpdateExpenseRequest $request)
    {

        try {

            $expense = Expense::findOrFail($request->id);
            $expense->title = $request->title;
            $expense->type_id = $request->expense_type;
            $expense->amount = $request->amount;
            $expense->expense_date = $request->expense_date;
            $expense->details = $request->details;
            $expense->active_status = $request->active_status;

            if ($request->hasFile('voucher')) {
                    $path = $this->uploadFile($request->file('voucher'), 'expense_vouchers');

                    if ($expense->voucher) {
                        $this->deleteFile($expense->voucher);
                    }
                    $expense->voucher = $path;
                }
            $expense->updated_by = Auth::id();


            $expense->save();
            return response()->json(['message' => 'Expense updated successfully', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Expense::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['message' => 'Expense Deleted Successfully', 'status' => 200]);
            } else {
                return response()->json(['message' => 'Data not found!', 'status' => 404]);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'status' => 500]);
        }
    }




    public function changeStatus(Request $request)
    {
        $data = Expense::find($request->id);
        if ($data) {
            if ($data->active_status == 1) {
                $data->active_status = 0;
            } else {
                $data->active_status = 1;
            }
            $data->save();
            return response()->json(['message' => 'Status Updated Successfully', 'status' => 200]);
        } else {
            return response()->json(['message' => 'Data Not Found!', 'status' => 404]);
        }
    }

}

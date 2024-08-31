<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Role;
use App\Models\SubscriptionPaymentLog;
use App\Models\User;
use App\Services\StripeService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Subscription;
use Stripe\Stripe;
use Yajra\DataTables\Facades\DataTables;
use Brian2694\Toastr\Facades\Toastr;

use function PHPUnit\Framework\returnArgument;

class SubscripitonController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = User::whereIn('role_id', [Role::DESIGNER, Role::MANUFACTURER])->with('currentSubscription.plan')->whereHas('currentSubscription');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->is_subscribed == 1) {
                        return '<span class="badge bg-label-success">Active</span>';
                    } else {
                        return '<span class="badge bg-label-danger">Deactive</span>';
                    }
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })

                ->editColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn("plan", function ($row) {
                    return optional(optional($row->currentSubscription)->plan)->name;
                })
                ->addColumn("crated_date", function ($row) {

                    return dateFormatwithTime(strtotime($row->currentSubscription->created));
                })
                ->addColumn("expire_date", function ($row) {

                    return dateFormatwithTime(Carbon::createFromTimestamp($row->currentSubscription->expire_at));
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('subscription.customer.details', $row) . '" class="btn btn-primary text-white me-1">Billing Details</a>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('subscription.customer.index');
    }

    public function details($user_id)
    {
        $user = User::with('currentSubscription.plan')->where('id', $user_id)->first();

        $subscriptionPaymentList = SubscriptionPaymentLog::with('plan')->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10);


        return view('subscription.customer.details', compact('user', 'subscriptionPaymentList'));
    }

    public function stripeGenerateInvoice($invoice_no)
    {
        $stripeService = new StripeService();
        $invoice = $stripeService->generateInvoice($invoice_no);
        $invoice_hosted_url = $invoice->hosted_invoice_url;
        return redirect($invoice_hosted_url);
    }

    public function invoicePreview($invoice_no)
    {
        $stripeService = new StripeService();
        $invoice = $stripeService->generateInvoice($invoice_no);
        // dd($invoice);
        return view('subscription.customer.invoice-preview', compact('invoice'));
    }

    public function invoicePrint($invoice_no)
    {
        $stripeService = new StripeService();
        $invoice = $stripeService->generateInvoice($invoice_no);

        return view('subscription.customer.invoice', compact('invoice'));
    }

    public function invoiceDownload($invoice_no)
    {
        $stripeService = new StripeService();
        $invoice = $stripeService->generateInvoice($invoice_no);

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/'),
        ])->loadView('subscription.customer.invoice', compact('invoice'));
        return $pdf->download($invoice_no . '.pdf');
    }

    public function immediateSubscriptionCancel($user_id)
    {

        try {
            DB::beginTransaction();

            $currentActiveSubscripton = SubscriptionPaymentLog::where('user_id', $user_id)
                ->where('expire_at', '>=', strtotime(gmdate('Y-m-d 00:00:00')))
                ->orderBy('id', 'desc')
                ->first();
            User::where('id', $user_id)->update(['is_subscribed' => 0]);
            $stripeService = new StripeService();
            $stripeService->cancelSubscriptonImmediately($currentActiveSubscripton);

            DB::commit();

            Toastr::success('Subscritption Canceled successfull');
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();

            Toastr::error('Something went wrong');
            return redirect()->back();
        }
    }

    public function revokeSubscriptionCancel($user_id)
    {
        try {
            DB::beginTransaction();

            $currentActiveSubscripton = SubscriptionPaymentLog::where('user_id', $user_id)
                ->where('expire_at', '>=', strtotime(gmdate('Y-m-d 00:00:00')))
                ->orderBy('id', 'desc')
                ->first();
            $stripeService = new StripeService();
            $stripeService->cancelSubscriptonRevoke($currentActiveSubscripton);

            DB::commit();

            Toastr::success('Subscritption Canceled successfull');
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();

            Toastr::error('Something went wrong');
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailStoreRequest;
use App\Http\Requests\MailRequest;
use App\Mail\TestMail;
use App\Models\EmailSetting;
use App\Models\Subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailSettingController extends Controller
{
    public function index()
    {
        $email_setting = EmailSetting::where('user_id', Auth::user()->id)->first();
        return view('setting.email-setting',compact('email_setting'));
    }

    public function store(EmailStoreRequest $request)
    {
        try {
            $email_setting = EmailSetting::where('user_id', Auth::user()->id)->first();

            $email_setting->email_engine_type = $request->email_engine_type;
            $email_setting->from_name = $request->from_name;
            $email_setting->from_email  = $request->from_email;
            $email_setting->mail_driver = $request->mail_driver;
            $email_setting->mail_host = $request->mail_host;
            $email_setting->mail_port = $request->mail_port;
            $email_setting->mail_username = $request->mail_username;
            $email_setting->mail_password = $request->mail_password;
            $email_setting->mail_encryption = $request->mail_encryption;

            $email_setting->save();

            Toastr::success('Email Setting Updated');
            return redirect()
                ->back();
        } catch (Exception $e) {

            Toastr::error('Something went wrong');

            return redirect()->back();
        }
    }

    public function sendTestEmail(MailRequest $request)
    {
        $data= [
            'subject'=> $request->subject,
            'message'=> $request->message,
        ];

        try {
            Mail::to($request->to_email)->send(new TestMail($data));
            Toastr::success('Email Send Successfully');
        }catch (Exception $e){
            dd($e);
            Toastr::error('Something went wrong');
        }
        return back();
    }
}

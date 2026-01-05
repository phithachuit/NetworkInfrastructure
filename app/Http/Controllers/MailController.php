<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\AlertMail;
use App\Models\LogAlertModel;
use App\Models\MailModel;

class MailController extends Controller
{


    public function index() {
        $data = MailModel::orderByDesc('created_at')->get();
        return view('mail.maillist', compact('data'));
    }

    public function settingMail() {
        return view('mail.mailsetting');
    }

    public function show($id){
        $data = MailModel::orderByDesc('created_at')->get();
        // $showMail = MailModel::where('id', $id)->get()->toArray();
        $showMail = MailModel::find($id);
        return view('mail.maillist', compact('showMail', 'data'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'smtphost' => 'required|string',
            'smtpport' => 'required|number|max:6',
            'username' => 'required|string',
            'password' => 'required',
            'mailto' => 'required|email',
        ],[
            'smtphost.required' => 'Host không được để trống',
            'smtphost.string' => 'Host phải là ký tự',
            'smtpport.required' => 'Port không được để trống',
            'smtpport.string' => 'Port phải là ký tự',
            'smtpport.number' => 'Port phải là số',
            'username.required' => 'Tài khoản không được để trống',
            'username.string' => 'Tài khoản phải là ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'mailto.required' => 'Mail cần gửi không được để trống',
            'mailto.email' => 'Mail cần gửi sai định dạng',
        ]);

        // return $permissionModel->store([
        //     'permission_id' => $request->input('permission_id'),
        //     'permission_name' => $request->input('permission_name'),
        //     'permission_active' => $request->input('permission_active'),
        // ]) ? redirect()->route('permission.index')->withSuccess('Thêm nhóm thành công') 
        //   : redirect()->back()->withErrors('Thêm nhóm thất bại');
    }

    public function sendmail(){
        $content = LogAlertModel::get()->last()->toArray();

        if(!$content['mail_sent']) {
            // send mail
            Mail::to('lephithach00@gmail.com')->send(new AlertMail($content['name']));

            // update status mail
            LogAlertModel::where('id', $content['id'])->update(['mail_sent' => true]);
        }

        // dd(LogAlertModel::where('id', $content['id'])->update(['mail_sent' => false]));
    }
}

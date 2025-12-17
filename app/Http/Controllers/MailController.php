<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index() {
        return view('mail.maillist');
    }

    public function settingMail() {
        return view('mail.mailsetting');
    }
}

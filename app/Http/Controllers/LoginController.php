<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function sendLogin(Request $request){
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if($request->input('email') === 'jokivadet@gmail.com'
            && $request->input('password') === '123456') {
            // Login successful
            echo "Login successful for email: " . $request->input('email');
        } else {
            // Invalid credentials
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
        // Here you would typically check the credentials against the database
        // For demonstration, let's assume any email/password combination is valid

        // Redirect to dashboard or intended page after successful login
        // return redirect()->route('dashboard')->with('success', 'Login successful!');
        
    }
}

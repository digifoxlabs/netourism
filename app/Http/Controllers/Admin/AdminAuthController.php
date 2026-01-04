<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    //Show Login Form
    public function showLoginForm(){

        return view('admin.login');
    }

    //Login Post
        public function login(Request $request)
        {
            // Validate incoming data
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string',
            ]);

            // Credentials array
            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
            ];

            // Check remember me
            $remember = $request->has('remember');

            // Attempt login via admin guard
            if (Auth::guard('admin')->attempt($credentials, $remember)) {
                $request->session()->regenerate(); // security best practice
                return redirect()->route('admin.dashboard');
            }

            // Failed login
            return back()
                ->withInput($request->only('email')) // keep email filled
                ->withErrors(['email' => 'Invalid email or password.']);
        }
    //Handle Logout

        public function logout(Request $request) {

            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        
            return redirect()->route('admin.login');
           // return redirect('/admin/login');
        }




}
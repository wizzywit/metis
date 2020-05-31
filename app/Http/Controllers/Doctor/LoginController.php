<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Route;

class LoginController extends Controller
{

    public function __construct()
    {
      $this->middleware('guest:doctor', ['except' => ['logout']]);
      $this->middleware('guest:admin', ['except' => ['logout']]);
      $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
      return view('doctor.doctor_login');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);

      // Attempt to log the user in
      if (Auth::guard('doctor')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        if(Auth::guard('doctor')->user()->verified){
            return redirect()->intended(route('doctor.dashboard'));
        } else {
            Auth::guard('doctor')->logout();
            return redirect('/doctor/login')->with('flash_message_success', 'Account Have not been Verified, Contact Admin');
        }
      }
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'))->with('flash_message_error','Invalid Email or Password');
    }

    public function logout()
    {
        Auth::guard('doctor')->logout();
        return redirect('/doctor');
    }
}

<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:admin');
    }

    public function showLoginForm(){
        return view('admin.auth.login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required|min:6',
        ]);


        $email = $request->email;
        $password = $request->password;


        if(Auth::guard('admin')->attempt(['email'=>$email,'password'=>$password],$request->remember)){
            return redirect()->intended(route('admin'));
        }

        return redirect()->back()->withInput($request->only('email','remember'));

    }
}

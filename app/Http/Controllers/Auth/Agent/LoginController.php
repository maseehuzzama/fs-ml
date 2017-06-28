<?php

namespace App\Http\Controllers\Auth\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:agent');
    }

    public function showLoginForm(){
        return view('agent.auth.login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email'=>'required|email',
            'password'=>'required|min:6',
        ]);


        $email = $request->email;
        $password = $request->password;


        if(Auth::guard('agent')->attempt(['email'=>$email,'password'=>$password],$request->remember)){
            return redirect()->intended(route('agent'));
        }

        return redirect()->back()->withInput($request->only('email','remember'));

    }

}

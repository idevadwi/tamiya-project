<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/home');
        }else{
            return view('login');
        }
    }

    public function actionlogin(Request $request)
    {
        $rules = [
            'phone'                 => 'required|string',
            'password'              => 'required|string'
        ];

        $messages = [
            'phone.required'        => 'Please enter your phone.',
            'phone.string'          => 'Not a valid phone number',
            'password.required'     => 'Please enter your password.',
            'password.string'       => 'Not a valid password'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            return redirect('/home');
        }else{
            Session::flash('error', 'Invalid Phone or Password');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('login');
    }
}

<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{


public function showLogin()
{
    return view('auth.login');
}



public function login(Request $request)
{

    $data=$request->validate([

        'username'=>'required',
        'password'=>'required'

    ]);


    if(Auth::attempt($data))
    {

        $request->session()->regenerate();


        auth()->user()->update([

            'terakhir_login'=>now()

        ]);


        return redirect('/dashboard');

    }


    return back()->withErrors([

        'username'=>'Login gagal'

    ]);

}



public function logout(Request $request)
{

    Auth::logout();

    $request->session()->invalidate();

    return redirect('/login');

}


}
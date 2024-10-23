<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index(){
        return view('auth/login');
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'email' => ['required', 'string','email'],
            'password' => ['required', 'string']
        ]);
        if(Auth::attempt($validateData)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with("success","Login Success");
        }
        return back()->withInput()->with('error', 'Wrong Email and Password!');
    }
}

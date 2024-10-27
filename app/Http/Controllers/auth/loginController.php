<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            $user = Auth::user();
            return redirect()->route('dashboard')->with("success", "Login Success as Admin");
            
        }
        return back()->withInput()->with('error', 'Wrong Email and Password!');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Successfully logged out!');
    }
}

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
            
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard')->with("success", "Login Success as Admin");
            } elseif ($user->hasRole('reviewer')) {
                return redirect()->route('reviewer.dashboard')->with("success", "Login Success as Reviewer");
            } elseif ($user->hasRole('mahasiswa')) {
                return redirect()->route('mahasiswa.dashboard')->with("success", "Login Success as Mahasiswa");
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Invalid user role!');
            }
            
        }
            // return redirect()->route('admin.dashboard')->with("success","Login Success");

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

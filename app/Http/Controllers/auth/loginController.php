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
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);
        if(Auth::attempt($validateData)){
            $request->session()->regenerate();
            $user = Auth::user();
            return redirect()->route('dashboard');
            
        }
        return back()->withInput()->with('error', 'Username atau Password Tidak Valid!');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Berhasil Keluar!');
    }
}

<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller
{
    public function index()
    {
        return view('auth/register');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed']
        ]);
        $validateData['password'] = Hash::make($validateData['password']);
        $user = User::create($validateData);
        $user->assignRole('mahasiswa');
        if ($user) {
            // **Trigger event untuk mengirim email verifikasi**
            event(new Registered($user));

            return redirect()->route('verification.notice')->with('success', 'Registrasi berhasil! Silakan periksa email Anda untuk verifikasi.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar, silakan coba lagi.');
        }





        // return redirect(route('dashboard', absolute: false));
    }
}

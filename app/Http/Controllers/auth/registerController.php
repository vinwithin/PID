<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller
{
    public function index()
    {
        return view('auth/register');
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'identifier' => ['required', 'string'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'string', 'confirmed']
            ]);

            $validateData['password'] = Hash::make($validateData['password']);

            $user = User::create($validateData);
            $user->assignRole('mahasiswa');

            // Trigger event untuk mengirim email verifikasi
            event(new Registered($user));

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }




        // return redirect(route('dashboard', absolute: false));
    }
}

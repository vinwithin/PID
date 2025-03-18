<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function index(){
        return view('dashboard', [
            'alreadyRegist' => TeamMember::where('identifier', Auth::user()->identifier)->exists(),
            'data' => Registration::with(['registration_validation', 'ormawa', 'user'])
                ->whereHas('teamMembers', function ($query) {
                    $query->where('identifier', Auth::user()->identifier);  // Cek apakah NIM ada di tabel teammember
                })->first()

        ]);
    }
    public function profil(){
        return view('profil.index',[
            'data' => User::where('id', Auth::user()->id)->get(),
        ]);
    }
}

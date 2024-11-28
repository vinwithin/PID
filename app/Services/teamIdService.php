<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\DokumenTeknis;
use Illuminate\Support\Facades\Auth;

class teamIdService
{

    public function getRegistrationId()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        if ($user && $user->teamMembers) {
            return $user->teamMembers->registration_id; // Mengembalikan id team_member
        } else {
            return null;
        }
    }
}

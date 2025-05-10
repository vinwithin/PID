<?php

namespace App\Http\Middleware;

use App\Models\Registration;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class allTeamApprove
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = Registration::with(['registration_validation', 'teamMembers'])
            ->whereHas('teamMembers', function ($query) {
                $query->where('identifier', Auth::user()->identifier);  // Cek apakah NIM ada di tabel teammember
            })->get();
        foreach ($data as $key => $item) {
            if (!$item->teamMembers->every(fn($member) => $member->status === 'approve') && $item->nim_ketua === Auth::user()->identifier) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }
        return $next($request);
    }
}

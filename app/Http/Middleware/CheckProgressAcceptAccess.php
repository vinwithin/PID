<?php

namespace App\Http\Middleware;

use App\Models\Registration;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProgressAcceptAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->hasRole(['admin', 'reviewer', 'dosen', 'super admin'])) {
            return $next($request);
        } elseif ($user->hasRole('mahasiswa')) {
            $hasAccessToProgress =
                Registration::whereHas('registration_validation', function ($query) {
                    $query->where('status', 'Lanjutkan Program');
                })
                ->whereHas('teamMembers', function ($query) {
                    $query->where('nim', Auth::user()->nim);
                })
                ->exists();

            if (!$hasAccessToProgress) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            return $next($request);
        }
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Deadline;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisDeadline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $deadline = Deadline::where('nama_dokumen', 'Pendaftaran')->first();

        if (!$deadline) {
            return redirect()->back()->with('error', 'Jadwal registrasi program belum diatur.');
        }

        $today = now()->toDateString();

        if ($today < $deadline->dibuka) {
            return redirect()->back()->with('error', 'Pendaftaran program Pro-IDe belum dibuka.');
        }

        if ($today > $deadline->ditutup) {
            return redirect()->back()->with('error', 'Pendaftaran program Pro-IDe telah ditutup.');
        }

        return $next($request);
    }
}

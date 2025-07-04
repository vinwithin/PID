<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Registration;
use App\Models\TeamMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class dashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah user adalah anggota tim dan statusnya masih pending
        $pendingMember = TeamMember::where('identifier', $user->identifier)
            ->where('status', 'pending')
            ->first();
        if ($pendingMember) {
            session()->flash('pending_approval');
        }
        $currentYear = Carbon::now()->year;
        return view('dashboard', [

            'alreadyRegist' => TeamMember::where('identifier', Auth::user()->identifier)->whereYear('created_at', $currentYear)->exists(),
            'pendingMember' => $pendingMember,
            'data' => Registration::with(['registration_validation', 'ormawa', 'user'])
                ->whereHas('teamMembers', function ($query) {
                    $query->where('identifier', Auth::user()->identifier);
                })
                
                ->first(),
            'announce' => Announcement::all(),

        ]);
    }
    public function profil()
    {
        return view('profil.index', [
            'data' => User::where('id', Auth::user()->id)->get(),
        ]);
    }
    public function updateFotoProfil(Request $request)
    {
        try {
            // Validasi
            $request->validate([
                'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $user = Auth::user();

            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Ambil file
            $file = $request->file('foto_profil');

            // Buat nama acak
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan dengan nama acak
            $path = $file->storeAs('foto_profil', $filename, 'public');

            // Update user
            User::where('id', $user->id)->update(
                ['foto_profil' => $path]
            );

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui foto: ' . $e->getMessage());
        }
    }
}

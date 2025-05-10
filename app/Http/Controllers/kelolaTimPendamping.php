<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class kelolaTimPendamping extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = Registration::with([
            'bidang',
            'fakultas',
            'program_studi',
            'reviewAssignments',
            'registration_validation',
            'score_monev',
            'status_monev'
        ])
            ->where('nama_dosen_pembimbing', Auth::user()->id)
            ->where('status', 'submit');

        if ($search) {
            $data->where(function ($query) use ($search) {
                $query->where('nama_ketua', 'like', "%{$search}%")
                    ->orWhere('nim_ketua', 'like', "%{$search}%")
                    ->orWhere('status_supervisor', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%");
            });
        }
        $data = $data->paginate(10);
        return view('kelola-tim.index', [
            'data' => $data
        ]);
    }
    public function approve($id)
    {
        $result = Registration::where('id', $id)
            ->update(['status_supervisor' => 'approved']);
        if ($result) {
            return redirect()->back()->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->back()->with("error", "Gagal mengubah data!");
        }
    }
    public function reject($id)
    {
        $result = Registration::where('id', $id)
            ->update(['status_supervisor' => 'rejected']);
        if ($result) {
            return redirect()->back()->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->back()->with("error", "Gagal mengubah data!");
        }
    }
}

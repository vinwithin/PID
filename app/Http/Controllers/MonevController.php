<?php

namespace App\Http\Controllers;

use App\Models\KriteriaMonev;
use App\Models\Registrasi_validation;
use App\Models\Registration;
use App\Models\ScoreMonev;
use App\Models\StatusMonev;
use App\Models\User;
use App\Services\ScoreDetailMonev;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonevController extends Controller
{
    public function index()
    {
        $total = ScoreDetailMonev::scores();

        return view('monitoring-evaluasi.index', [
            'data' => Registration::with(['bidang', 'fakultas', 'program_studi', 'reviewAssignments', 'registration_validation', 'score_monev', 'status_monev'])->whereHas('registration_validation', function ($query) {
                $query->whereIn('status', ['lolos', 'Lanjutkan Program', 'Hentikan Program']);
                })->get(),
            'dataNilai' => Registration::with(['reviewAssignments', 'bidang', 'fakultas', 'program_studi'])->whereHas('status_monev', function ($query) {
                $query->where('user_id', Auth::user()->id); // Kondisi yang ingin dicek
            })->get(),
            'total' => $total['total'],


        ]);
    }

    public function createScore($id)
    {
        return view('monitoring-evaluasi.create', [
            'data' => Registration::find($id),
            'penilaian' => KriteriaMonev::all(),
        ]);
    }

    public function store(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|max:255',

            'catatan' => 'required|max:255',
        ]);
        foreach ($validatedData['nilai'] as $kriteriaMonevId => $nilai) {
            ScoreMonev::create([
                'user_id' => Auth::user()->id,
                'registration_id' => $id,
                'kriteria_monev_id' => $kriteriaMonevId,
                'nilai' => $nilai,
            ]);
        }
        $result = StatusMonev::where('registration_id', $id)->update([
            'status' => 'telah dinilai',
            'catatan' => $validatedData['catatan']
        ]);

        if ($result) {
            return redirect()->route('monev.index')->with('success', 'Berhasil menambahkan data');
        } else {
            return back()->withErrors(['error' => 'Review assignment tidak terdaftar.']);
        }
    }

    public function createReviewer($id)
    {
        return view('monitoring-evaluasi.reviewer-monev', [
            'data' => Registration::find($id),
            'reviewer_monev' => User::Role('dosen')->get(),

        ]);
    }

    public function storeReviewer(Request $request, $id)
    {
        $validatedData = $request->validate([
            'reviewer_id' => 'required',
        ]);
        $result = StatusMonev::create([
            'user_id' => $validatedData['reviewer_id'],
            'registration_id' => $id,
        ]);
        if ($result) {
            return redirect()->route('monev.index')->with('success', 'Berhasil menambahkan data');
        } else {
            return back()->withErrors(['error' => 'Review assignment tidak terdaftar.']);
        }
    }
    public function edit($id)
    {
        return view('monitoring-evaluasi.edit', [
            'data' => Registration::find($id),
            'reviewer' => StatusMonev::where('registration_id', $id)->get(),
            'reviewer_monev' => User::Role('dosen')->get(),

        ]);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'reviewer_id' => 'required',
        ]);
        $result = StatusMonev::where('registration_id', $id)->update([
            'user_id' => $validatedData['reviewer_id'],
        ]);
        if ($result) {
            return redirect()->route('monev.index')->with('success', 'Berhasil menambahkan data');
        } else {
            return back()->withErrors(['error' => 'Review assignment tidak terdaftar.']);
        }
    }

    public function detail($id)
    {
        $rubrik = ScoreDetailMonev::scoreDetail($id);
        $total = ScoreDetailMonev::scoreDetail($id);
        $bobot = ScoreDetailMonev::scoreDetail($id);
        return view('monitoring-evaluasi.detail', [
            'data_review' => StatusMonev::where('registration_id', $id)->get(),
            'dataReviewId' => StatusMonev::where('registration_id', $id)->where('user_id', Auth::user()->id)->get(),
            'data' => $rubrik['rubrik'],
            'total' => $total['total'],
            'bobot' => $bobot['bobot']

        ]);
    }

    public function approve($id)
    {
        try {
            DB::beginTransaction();
            StatusMonev::where('registration_id', $id)
                ->update(['status' => 'Lanjutkan Program']);
            $result = Registrasi_validation::where('registration_id', $id)->
            update(['status' => 'Lanjutkan Program']);
            DB::commit();
            if ($result) {
                return redirect()->route('monev.index')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('monev.index')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('monev.index')->with("error", "Gagal mengubah data!");
        };
    }
    public function reject($id)
    {
        try {
            DB::beginTransaction();
        
            // Update status pada StatusMonev
            StatusMonev::where('registration_id', $id)
                ->update(['status' => 'Hentikan Program']);
        
            // Update status pada RegistrasiValidation
            $result = Registrasi_validation::where('registration_id', $id)
                ->update(['status' => 'Hentikan Program']);
        
            // Commit transaksi jika berhasil
            DB::commit();
        
            if ($result) {
                return redirect()->route('monev.index')->with('success', 'Berhasil mengubah data');
            } else {
                return redirect()->route('monev.index')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan
        
            return redirect()->route('monev.index')->with("error", "Terjadi kesalahan, silakan coba lagi!");
        }
    }
}

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
    public function index(Request $request)
    {
        $total = ScoreDetailMonev::scores();
        $search = $request->input('search');
        $data =  Registration::select('id', 'nama_ketua', 'nim_ketua', 'judul', 'fakultas_ketua')->with([
            'user',
            'bidang',
            'fakultas',
            'program_studi',
            'reviewAssignments',
            'registration_validation',
            'score_monev',
            'status_monev',
            'laporan_kemajuan'
        ])
            ->whereHas('registration_validation', function ($query) {
                $query->whereIn('status', ['lolos', 'Lanjutkan Program', 'Hentikan Program']);
            })
            ->whereHas('laporan_kemajuan', function ($query) {
                $query->where('status', 'Valid');
            });
        if ($search) {
            $data->where(function ($query) use ($search) {
                $query->where('nama_ketua', 'like', "%{$search}%")
                    ->orWhere('nim_ketua', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%");
            });
        }
        if ($request->filled('tahun')) {
            $data->whereYear('created_at', $request->tahun);
        }
        $data = $data->latest()->paginate(10);

        $dataNilai =  Registration::select('id', 'nama_ketua', 'nim_ketua', 'judul', 'fakultas_ketua')->with(['user', 'reviewAssignments', 'bidang', 'fakultas', 'program_studi', 'laporan_kemajuan'])->whereHas('status_monev', function ($query) {
            $query->where('user_id', Auth::user()->id); // Kondisi yang ingin dicek
        });
        if ($search) {
            $dataNilai->where(function ($query) use ($search) {
                $query->where('nama_ketua', 'like', "%{$search}%")
                    ->orWhere('nim_ketua', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%");
            });
        }
        if ($request->filled('tahun')) {
            $dataNilai->whereYear('created_at', $request->tahun);
        }

        $dataNilai = $dataNilai->latest()->paginate(10);


        return view('monitoring-evaluasi.index', [
            'data' => $data,
            'dataNilai' => $dataNilai,
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
        $registration = Registration::findOrFail($id); // ID registrasi yang sedang dilihat
        $supervisorId = $registration->nama_dosen_pembimbing;
        return view('monitoring-evaluasi.reviewer-monev', [
            'data' => Registration::with(['fakultas', 'ormawa', 'program_studi'])->find($id),
            'reviewer_monev' => User::with(['registration'])->role(['dosen', 'reviewer'])
                ->where('id', '!=', $supervisorId)
                ->get(),

        ]);
    }

    public function storeReviewer(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // Validasi input
            $data = $request->validate([
                'reviewer_id' => 'required|array|min:2|max:2', // Harus memilih 2 reviewer
                'reviewer_id.*' => 'required',
            ]);
            // Ambil reviewer dari request
            $reviewer_1 = $data['reviewer_id'][0];
            $reviewer_2 = $data['reviewer_id'][1];

            // Pastikan reviewer_1 dan reviewer_2 tidak sama
            if ($reviewer_1 === $reviewer_2) {
                return back()->withErrors(['error' => 'Reviewer 1 dan 2 tidak boleh sama']);
            }
            // Simpan ke database
            StatusMonev::create([
                'user_id' => $reviewer_1,
                'registration_id' => $id,
            ]);
            StatusMonev::create([
                'user_id' => $reviewer_2,
                'registration_id' => $id,
            ]);

            DB::commit();
            return redirect()->route('monev.index')->with('success', 'Berhasil menambah data');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('monev.index')->with("error", "Gagal mengubah data!");
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
        try {
            DB::beginTransaction();
            $data = $request->validate([
                'reviewer_id' => 'required|array|min:2|max:2', // Harus memilih 2 reviewer
                'reviewer_id.*' => 'required',
            ]);
            $reviewer_1 = $data['reviewer_id'][0];
            $reviewer_2 = $data['reviewer_id'][1];

            // Pastikan reviewer_1 dan reviewer_2 tidak sama
            if ($reviewer_1 === $reviewer_2) {
                return back()->withErrors(['error' => 'Reviewer 1 dan 2 tidak boleh sama']);
            }
            StatusMonev::where('registration_id', $id)->delete();
            // Simpan reviewer baru
            StatusMonev::create([
                'user_id' => $reviewer_1,
                'registration_id' => $id,
            ]);
            StatusMonev::create([
                'user_id' => $reviewer_2,
                'registration_id' => $id,
            ]);
            DB::commit();
            return redirect()->route('monev.index')->with('success', 'Berhasil menambah data');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('monev.index')->with("error", "Gagal mengubah data!");
        }
    }

    public function detail($id)
    {
        $rubrik = ScoreDetailMonev::scoreDetail($id);
        $total = ScoreDetailMonev::scoreDetail($id);
        $bobot = ScoreDetailMonev::scoreDetail($id);
        // dd($rubrik['rubrik']);
        return view('monitoring-evaluasi.detail', [
            'id_regis' => Registration::find($id),
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
            $result = Registrasi_validation::where('registration_id', $id)->update(['status' => 'Lanjutkan Program']);
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

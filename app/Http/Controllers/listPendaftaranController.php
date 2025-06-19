<?php

namespace App\Http\Controllers;

use App\Http\Controllers\reviewer\ProposalReviewController;
use App\Models\Kriteria_penilaian;
use App\Models\Proposal_score;
use App\Models\Registrasi_validation;
use App\Models\Registration;
use App\Models\ReviewAssignment;
use App\Models\Sub_kriteria_penilaian;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class listPendaftaranController extends Controller
{
    public function filter(Request $request)
    {
        $search = $request->input('search');
        $tahun = $request->input('tahun');

        // Data untuk reviewer terkait
        $dataNilai = Registration::with('fakultas', 'reviewAssignments', 'bidang', 'registration_validation')
            ->whereHas('reviewAssignments', function ($query) {
                $query->where('reviewer_id', Auth::user()->id);
            });

        if ($search) {
            $dataNilai->where(function ($query) use ($search) {
                $query->where('nama_ketua', 'like', "%{$search}%")
                    ->orWhere('nim_ketua', 'like', "%{$search}%")
                    ->orWhere('bidang_id', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%")
                    ->orWhereHas('bidang', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%");
                    });
            });
        }
        if ($request->filled('tahun')) {
            $dataNilai->whereYear('created_at', $request->tahun);
        }
        $dataNilai = $dataNilai->latest()->paginate(10);

        // Total skor
        $totalId = ProposalReviewController::calculateScores();

        // Filter data utama
        $data = Registration::select('id', 'nama_ketua', 'nim_ketua', 'judul', 'fakultas_ketua', 'bidang_id')
            ->with(['user', 'bidang', 'fakultas', 'program_studi', 'reviewAssignments', 'registration_validation', 'score_monev', 'status_monev'])
            ->where('status_supervisor', 'approved');

        if ($search) {
            $data->where(function ($query) use ($search) {
                $query->where('nama_ketua', 'like', "%{$search}%")
                    ->orWhere('nim_ketua', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%")
                    ->orWhereHas('bidang', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%");
                    });
            });
        }
        if ($request->filled('tahun')) {
            $data->whereYear('created_at', $request->tahun);
        }
        $data = $data->latest()->paginate(10);

        return view('list_pendaftaran', [
            'data' => $data,
            'dataNilai' => $dataNilai,
            'totalId' => $totalId['totalId'],
        ]);
    }


    public function index()
    {
        $dataNilai = Registration::with(['user', 'reviewAssignments', 'bidang', 'fakultas', 'program_studi', 'total_proposal_scores'])->whereHas('reviewAssignments', function ($query) {
            $query->where('reviewer_id', Auth::user()->id); // Kondisi yang ingin dicek
        })->latest()->paginate(10);
        $totalId = ProposalReviewController::calculateScores();
        // dd($totalId['totalId']);
        return view('list_pendaftaran', [
            'data' => Registration::with([
                'user',
                'bidang',
                'fakultas',
                'program_studi',
                'reviewAssignments',
                'registration_validation',
                'score_monev',
                'status_monev',
                'total_proposal_scores'
            ])
                ->withSum('total_proposal_scores', 'total')
                ->where('status_supervisor', 'approved')
                ->whereYear('created_at', Carbon::now()->year) // hanya data tahun ini
                ->whereHas('registration_validation', function ($query) {
                    $query->whereIn('status', ['Belum valid', 'Tidak Lolos', 'valid', 'lolos']);
                })
                ->orderByRaw('(
                        SELECT SUM(total)
                        FROM total_proposal_scores
                        WHERE total_proposal_scores.registration_id = registration.id
                    ) DESC')
                ->paginate(10),


            'dataNilai' => $dataNilai,
            'totalId' => $totalId['totalId'],
        ]);
    }

    public function show($id)
    {
        $data = Registration::with(['bidang', 'fakultas', 'program_studi', 'teamMembers', 'reviewAssignments'])->find($id);
        return view('pendaftaran.detail_pendaftaran', [
            "data" => $data
        ]);
    }

    public function scoreDetail($id)
    {
        $rubrik = ProposalReviewController::calculateScoresById($id);
        $total = ProposalReviewController::calculateScoresById($id);
        $bobot = ProposalReviewController::calculateScoresById($id);
        // dd($total['total']);


        return view('pendaftaran.nilai', [
            'id_regis' => Registration::find($id),
            'data_review' => ReviewAssignment::where('registration_id', $id)->get(),
            'dataReviewId' => ReviewAssignment::where('registration_id', $id)->where('reviewer_id', Auth::user()->id)->get(),
            'data' => $rubrik['rubrik'],
            'total' => $total['total'],
            'bobot' => $bobot['bobot']

        ]);
    }
    public function approve($id)
    {
        try {
            Registrasi_validation::where('registration_id', $id)
                ->update(['status' => 'valid', 'validator_id' => Auth::user()->name]);
            return redirect()->route('pendaftaran')->with('success', 'berhasil mengubah data');
        } catch (Exception $e) {
            return redirect()->route('pendaftaran')->with("error", "Gagal mengubah data!");
        };
    }
    public function createReviewer($id)
    {
        $registration = Registration::findOrFail($id); // ID registrasi yang sedang dilihat
        $supervisorId = $registration->nama_dosen_pembimbing;
        return view('kelola-reviewer.index', [
            'data' => Registration::with(['fakultas', 'program_studi', 'ormawa'])->find($id),
            'reviewer' => User::with(['registration'])->role(['dosen', 'reviewer'])
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
                throw new Exception('Reviewer 1 dan 2 tidak boleh sama');
            }
            // Simpan ke database
            ReviewAssignment::create([
                'reviewer_id' => $reviewer_1,
                'registration_id' => $id,
                'status' => 'Menunggu Review',
                'feedback' => ''
            ]);
            ReviewAssignment::create([
                'reviewer_id' => $reviewer_2,
                'registration_id' => $id,
                'status' => 'Menunggu Review',
                'feedback' => ''
            ]);

            DB::commit();
            return redirect()->route('pendaftaran')->with('success', 'Berhasil menambah data');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('pendaftaran')->with('error', $e->getMessage());
        }
    }
    public function edit($id)
    {
        $registration = Registration::findOrFail($id); // ID registrasi yang sedang dilihat
        $supervisorId = $registration->nama_dosen_pembimbing;
        return view('kelola-reviewer.edit', [
            'data' => Registration::find($id),
            'data_reviewer' => ReviewAssignment::where('registration_id', $id)->get(),
            'reviewer' => User::with(['registration'])->role(['dosen', 'reviewer'])
                ->where('id', '!=', $supervisorId)
                ->get(),

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
                throw new Exception('Reviewer 1 dan 2 tidak boleh sama');
            }
            ReviewAssignment::where('registration_id', $id)->delete();
            // Simpan reviewer baru
            ReviewAssignment::create([
                'reviewer_id' => $reviewer_1,
                'registration_id' => $id,
                'status' => 'Menunggu Review',
                'feedback' => ''
            ]);
            ReviewAssignment::create([
                'reviewer_id' => $reviewer_2,
                'registration_id' => $id,
                'status' => 'Menunggu Review',
                'feedback' => ''
            ]);
            DB::commit();
            return redirect()->route('pendaftaran')->with('success', 'Berhasil menambah data');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('pendaftaran')->with('error', $e->getMessage());
        }
    }


    public function reject($id)
    {
        try {
            Registrasi_validation::where('registration_id', $id)
                ->update(['status' => 'Tidak Lolos', 'validator_id' => Auth::user()->name]);
            return redirect()->route('pendaftaran')->with('success', 'berhasil mengubah data');
        } catch (Exception $e) {
            return redirect()->route('pendaftaran')->with("error", "Gagal mengubah data!");
        };
    }
    public function approveUserForProgram($id)
    {
        $result = Registrasi_validation::where('registration_id', $id)
            ->update(['status' => 'lolos', 'validator_id' => Auth::user()->name]);
        if ($result) {
            return redirect()->route('pendaftaran')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('pendaftaran')->with("error", "Gagal mengubah data!");
        }
    }
}

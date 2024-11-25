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
use Exception;
use Illuminate\Http\Request;

class listPendaftaranController extends Controller
{
    public function filter(Request $request)
    {
        $filters = $request->input('filters', []);
        $dataNilai = Registration::with('reviewAssignments')->whereHas('reviewAssignments', function ($query) {
            $query->where('reviewer_id', auth()->user()->id); // Kondisi yang ingin dicek
        })->get();
        // Pastikan calculateScores() adalah metode static atau menggunakan Service Class
        $totalId = ProposalReviewController::calculateScores();
        if (empty($filters)) {
            $data = Registration::with('registration_validation')->get();
        } else {
            $data = Registration::with('registration_validation')->whereHas('registration_validation', function ($query) use ($filters) {
                $query->where('status', $filters); // Kondisi yang ingin dicek
            })->get();
        }

        return view('list_pendaftaran', [
            'data' => $data,
            'dataNilai' => $dataNilai,
            'totalId' => $totalId['totalId'],
        ]);
    }

    public function index()
    {
        $dataNilai = Registration::with('reviewAssignments')->whereHas('reviewAssignments', function ($query) {
            $query->where('reviewer_id', auth()->user()->id); // Kondisi yang ingin dicek
        })->get();
        $totalId = ProposalReviewController::calculateScores();
        // dd($totalId['totalId']);
        return view('list_pendaftaran', [
            'data' => Registration::all(),
            'dataNilai' => $dataNilai,
            'totalId' => $totalId['totalId'],
        ]);
    }

    public function show($id)
    {
        $data = Registration::find($id);
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
            'reviewer' => Proposal_score::with('user')->where('registration_id', $id)->get(),
            'data' => $rubrik['rubrik'],
            'total' => $total['total'],
            'bobot' => $bobot['bobot']

        ]);
    }
    public function approve($id)
    {
        try{   
            Registrasi_validation::where('registration_id', $id)
                ->update(['status' => 'valid']);
            $availableReviewers = User::role('reviewer')
                    ->withCount(['reviewAssignments' => function ($query) {
                        $query->where('status', 'pending');
                    }])
                    ->get();

            if ($availableReviewers->count() < 2) {
                throw new \Exception('Jumlah reviewer yang tersedia kurang dari 2');
            }

                // Pilih 2 reviewer dengan beban tugas paling sedikit
            $selectedReviewers = $availableReviewers
                ->sortBy('review_assignments_count')
                ->take(2);
                // Buat assignment untuk kedua reviewer terpilih
            foreach ($selectedReviewers as $reviewer) {
                ReviewAssignment::create([
                    'registration_id' => $id,
                    'reviewer_id' => $reviewer->id,
                    'status' => 'pending',
                    'feedback' => ''
                ]);
               
            } 

            return redirect()->route('pendaftaran')->with('success', 'berhasil mengubah data');
        }catch (Exception $e) {
            return redirect()->route('pendaftaran')->with("error", "Gagal mengubah data!");
        };
    }
}

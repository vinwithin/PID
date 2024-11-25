<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Kriteria_penilaian;
use App\Models\Proposal_score;
use App\Models\Registration;
use App\Models\ReviewAssignment;
use App\Models\Sub_kriteria_penilaian;
use Illuminate\Http\Request;

class ProposalReviewController extends Controller
{
    public static function calculateScoresById($id)
    {
        $rubrik = [];
        $nilais = [];
        $jumlah = [];
        $kriterias = [];
        $bobot = [];

        foreach (Kriteria_penilaian::all() as $kriteria) {
            $kriterias[$kriteria->id] = $kriteria->bobot;
        }
        foreach (Proposal_score::with('sub_kriteria_penilaian.kriteria_penilaian')->where('registration_id', $id)->get() as $value) {
            $nilais[$value->user->name][$value->sub_kriteria_penilaian->kriteria_penilaian_id][$value->id] = $value->nilai;
            $rubrik[$value->user->name][$value->sub_kriteria_penilaian->kriteria_penilaian->nama][$value->sub_kriteria_penilaian->nama] = $value->nilai;
            $bobot[$value->sub_kriteria_penilaian->kriteria_penilaian->nama] = $value->sub_kriteria_penilaian->kriteria_penilaian->bobot;
        }
        foreach ($nilais as $key => $value) {
            foreach ($value as $val => $v) {
                foreach ($v as $k => $nilai) {
                    $jumlah[$key][$val][$k] = $nilai * $kriterias[$val];
                }
            }
        }
        foreach ($jumlah as $key => $val) {
            foreach ($val as $k => $v) {
                $total[$key][$k] = array_sum($v);
            }
        }
        foreach ($total as $val => $value) {
            $totalScores[$val] = array_sum($value);
        }
        return [
            'total' => $totalScores,
            'bobot' => $bobot,
            'rubrik' => $rubrik,
        ];
    }
    public static function calculateScores()
    {
        $nilais = [];
        $jumlah = [];
        $kriterias = [];
        $total = [];
        $totalScores = [];

        $totalId = [];

        foreach (Kriteria_penilaian::all() as $kriteria) {
            $kriterias[$kriteria->id] = $kriteria->bobot;
        }
        foreach (Sub_kriteria_penilaian::with('kriteria_penilaian', 'proposal_score')->get() as $value) {
            if ($value->proposal_score->isNotEmpty()) {
                foreach ($value->proposal_score as $proposalScore) {
                    $nilais[$proposalScore->user->name][$value->kriteria_penilaian_id][$value->id] = $proposalScore->nilai;
                    $totalId[$proposalScore->registration_id] = [];
                }
            }
        }
        foreach ($nilais as $key => $value) {
            foreach ($value as $val => $v) {
                foreach ($v as $k => $nilai) {
                    $jumlah[$key][$val][$k] = $nilai * $kriterias[$val];
                }
            }
        }
        foreach ($jumlah as $key => $val) {
            foreach ($val as $k => $v) {
                $total[$key][$k] = array_sum($v);
            }
        }
        foreach ($total as $val => $value) {
            $totalScores[$val] = array_sum($value);
        }

        foreach ($totalId as $key => $k) {
            foreach ($total as $value => $val) {
                $totalId[$key][$value] = array_sum($val);
            }
        }

        return [
            'totalId' => $totalId,
        ];
    }

    public function index($id)
    {
        return view('reviewer.review', [
            'data' => Registration::find($id),
            'penilaian' => Kriteria_penilaian::all(),
        ]);
    }

    public function store(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|max:255',
            'feedback' => 'required|max:255',
        ]);
        foreach ($validatedData['nilai'] as $subKriteriaId => $nilai) {
            Proposal_score::create([
                'user_id' => auth()->user()->id,
                'registration_id' => $id,
                'sub_kriteria_penilaian_id' => $subKriteriaId,
                'nilai' => $nilai,
            ]);
        }
        $existingReview = ReviewAssignment::where('reviewer_id', auth()->user()->id)
            ->where('registration_id', $id)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'feedback' => $validatedData['feedback'],
            ]);
        } else {
            return back()->withErrors(['error' => 'Review assignment tidak terdaftar.']);
        }
        return redirect()->route('pendaftaran')->with('success', 'Berhasil menambahkan data');
    }
}

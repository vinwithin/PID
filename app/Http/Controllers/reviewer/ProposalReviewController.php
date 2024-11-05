<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Kriteria_penilaian;
use App\Models\Proposal_score;
use App\Models\Registration;
use App\Models\Sub_kriteria_penilaian;
use Illuminate\Http\Request;

class ProposalReviewController extends Controller
{
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
            ]);
            foreach ($validatedData['nilai'] as $subKriteriaId => $nilai) {
                Proposal_score::create([
                    'user_id' => auth()->user()->id,
                    'registration_id' => $id,
                    'sub_kriteria_penilaian_id' => $subKriteriaId,
                    'nilai' => $nilai,
                ]);
            }
            return redirect()->route('listPendaftaran')->with('success', 'Berhasil menambahkan data');
        // } catch (\Exception $e) {
        //     return redirect()->route('listPendaftaran')->with('error', 'Gagal menambahkan data');
        // }
    }
}

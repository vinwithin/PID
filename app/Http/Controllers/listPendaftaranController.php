<?php

namespace App\Http\Controllers;

use App\Models\Kriteria_penilaian;
use App\Models\Proposal_score;
use App\Models\Registrasi_validation;
use App\Models\Registration;
use App\Models\Sub_kriteria_penilaian;
use Illuminate\Http\Request;

class listPendaftaranController extends Controller
{
    public function calculateScores()
    {
        $nilais = [];
        $jumlah = [];
        $kriterias = [];
        $total = [];
        $totalScores = [];
        $rubrik = [];
        $bobot = [];

        foreach (Kriteria_penilaian::all() as $kriteria) {
            $kriterias[$kriteria->id] = $kriteria->bobot;
        }
        foreach (Sub_kriteria_penilaian::with('kriteria_penilaian', 'proposal_score')->get() as $value) {
            if ($value->proposal_score->isNotEmpty()) {
                foreach ($value->proposal_score as $proposalScore) {
                    $nilais[$proposalScore->user->name][$value->kriteria_penilaian_id][$value->id] = $proposalScore->nilai;
                    $rubrik[$proposalScore->user->name][$value->kriteria_penilaian->nama][$value->nama] = $proposalScore->nilai;
                    $bobot[$value->kriteria_penilaian->nama] = $value->kriteria_penilaian->bobot;
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
        foreach($total as $value => $val){
            $totalScores[$value] = array_sum($val);
        }
        return [
            'total' => $totalScores,
            'nilais' => $nilais,
            'rubrik' => $rubrik,
            'bobot' => $bobot,
        ];
    }
    public function index()
    {
        $dataNilai = Registration::with('registration_validation')->whereHas('registration_validation', function ($query) {
            $query->where('status', 'valid'); // Kondisi yang ingin dicek
        })->get();
        $total = $this->calculateScores();
        return view('list_pendaftaran', [
            'data' => Registration::all(),
            'dataNilai' => $dataNilai,
            'total' => $total['total'] ,
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
        $rubrik = $this->calculateScores();
        $total = $this->calculateScores();
        $bobot = $this->calculateScores();
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
        $result = Registrasi_validation::where('registration_id', $id)
            ->update(['status' => 'valid']);
        if ($result) {
            return redirect()->route('listPendaftaran')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('listPendaftaran')->with("error", "Gagal mengubah data!");
        }
    }
}

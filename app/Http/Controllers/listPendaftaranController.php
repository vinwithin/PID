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
    public function calculateScoresById($id)
    {
        $rubrik = [];
        $nilais = [];
        $jumlah = [];
        $kriterias = [];
        $bobot = [];

        foreach (Kriteria_penilaian::all() as $kriteria) {
            $kriterias[$kriteria->id] = $kriteria->bobot;
        }
        foreach (Proposal_score::with('sub_kriteria_penilaian')->where('registration_id', $id)->get() as $value) {
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
    public function calculateScores()
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
    public function index()
    {
        $dataNilai = Registration::with('registration_validation')->whereHas('registration_validation', function ($query) {
            $query->where('status', 'valid'); // Kondisi yang ingin dicek
        })->get();
        $totalId = $this->calculateScores();
        // dd($total['total']);
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
        $rubrik = $this->calculateScoresById($id);
        $total = $this->calculateScoresById($id);
        $bobot = $this->calculateScoresById($id);
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

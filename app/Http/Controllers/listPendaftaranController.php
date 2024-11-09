<?php

namespace App\Http\Controllers;

use App\Models\Kriteria_penilaian;
use App\Models\Registrasi_validation;
use App\Models\Registration;
use App\Models\Sub_kriteria_penilaian;
use Illuminate\Http\Request;

class listPendaftaranController extends Controller
{
    public function index()
    {
        $nilais = [];
        $jumlah = [];
        $kriterias = [];
        $total = [];
        $dataNilai = Registration::with('registration_validation')->whereHas('registration_validation', function ($query) {
            $query->where('status', 'valid'); // Kondisi yang ingin dicek
        })->get();
        foreach (Kriteria_penilaian::all() as $kriteria) {
            $kriterias[$kriteria->id] = $kriteria->bobot;
        }
        foreach (Sub_kriteria_penilaian::with('kriteria_penilaian', 'proposal_score')->get() as $nilai) {
            $nilais[$nilai->kriteria_penilaian_id][$nilai->id] = $nilai->proposal_score[0]->nilai;
        }

        foreach ($nilais as $key => $val) {
            foreach ($val as $k => $v) {
                $jumlah[$key][$k] = $v * $kriterias[$key];
            }
        }
        foreach ($jumlah as $key => $val) {
            $total[$key] = array_sum($val);
        }
        return view('list_pendaftaran', [
            'data' => Registration::all(),
            'dataNilai' => $dataNilai,
            'total' => array_sum($total),
        ]);
    }
    public function show($id)
    {
        $data = Registration::find($id);
        return view('pendaftaran.detail_pendaftaran', [
            "data" => $data
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

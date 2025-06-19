<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\DokumenTeknis;
use App\Models\KriteriaMonev;
use App\Models\ScoreMonev;
use Illuminate\Support\Facades\Auth;

class ScoreDetailMonev
{

    public static function scoreDetail($id)
    {
        $rubrik = [];
        $nilais = [];
        $jumlah = [];
        $kriterias = [];
        $bobot = [];
        $total = [];

        foreach (KriteriaMonev::all() as $kriteria) {
            $kriterias[$kriteria->id] = $kriteria->bobot;
        }
        foreach (ScoreMonev::with(['kriteria_monev', 'user'])->where('registration_id', $id)->get() as $value) {
            $nilais[$value->user->name][$value->kriteria_monev_id] = $value->nilai;
            $rubrik[$value->user->name][$value->kriteria_monev->nama][$value->kriteria_monev->deskripsi] = $value->nilai;
            $bobot[$value->kriteria_monev->nama] = $value->kriteria_monev->bobot;
        }
        foreach ($nilais as $key => $value) {
            foreach ($value as $k => $nilai) {
                $jumlah[$key][$k] = $nilai * $kriterias[$k];
            }
        }
        // dd($jumlah);

        foreach ($jumlah as $key => $val) {
            $total[$key] = array_sum($val);
        }
        // dd($rubrik);


        // foreach ($total as $val => $value) {
        //     $totalScores[$val] = array_sum($value);
        // }

        return [
            'total' => $total,
            'bobot' => $bobot,
            'rubrik' => $rubrik,
        ];
    }
    public static function scores()
    {
        $nilais = [];
        $jumlah = [];
        $kriterias = [];
        $total = [];
        $totalScores = [];

        $totalId = [];

        foreach (KriteriaMonev::all() as $kriteria) {
            $kriterias[$kriteria->id] = $kriteria->bobot;
        }
        foreach (KriteriaMonev::with(['score_monev.user', 'user'])->get() as $value) {
            if ($value->score_monev->isNotEmpty()) {
                foreach ($value->score_monev as $scoreMonev) {
                    $nilais[$scoreMonev->registration_id][$scoreMonev->user->name][$value->id] = $scoreMonev->nilai;
                    $totalId[$scoreMonev->registration_id] = [];
                }
            }
        }
        // dd($nilais);
        foreach ($nilais as $key => $values) {
            foreach ($values as $id => $value) {
                foreach ($value as $val => $v) {
                   
                        $jumlah[$key][$id][$val]= $v * $kriterias[$val];
                    
                }
            }
        }
        // dd($jumlah);

        foreach ($jumlah as $id => $values) {
            foreach ($values as $key => $value) {
               
                    $total[$id][$key] = array_sum($value);
               
            }
        }
        return [
            'total' => $total,
        ];
    }
}

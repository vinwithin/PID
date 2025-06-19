<?php

namespace App\Exports;

use App\Models\Registration;
use App\Services\ScoreDetailMonev;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class nilaiMonevExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // Eager-load everything you’ll need
        $registrasis = Registration::with([
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
            ->whereYear('created_at', Carbon::now()->year) // hanya data tahun ini
            ->whereHas('registration_validation', function ($q) {
                $q->whereIn('status', [
                    'lolos',
                    'Lanjutkan Program',
                    'Hentikan Program'
                ]);
            })
            ->whereHas('laporan_kemajuan', function ($q) {
                $q->where('status', 'Valid');
            })->get();

        foreach ($registrasis as $i => $data) {
            $rubrik =  ScoreDetailMonev::scores();
            $nilai =  ScoreDetailMonev::scoreDetail($data->id);
            if ($i === 0) {
                // first sheet: special
                $sheets[] = new FirstNilaiMonev(
                    $registrasis,
                    $rubrik,
                    'First ID ' . $data->id
                );
                $sheets[] = new nilaiMonevPerTeam(
                    $data,
                    $rubrik,
                    $nilai,
                    'ID ' . $data->id
                );
            } else {
                $sheets[] = new nilaiMonevPerTeam(
                    $data,
                    $rubrik,
                    $nilai,
                    'ID ' . $data->id
                );
            }
        }

        return $sheets;
    }
}

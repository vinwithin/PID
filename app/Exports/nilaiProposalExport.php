<?php

namespace App\Exports;

use App\Http\Controllers\reviewer\ProposalReviewController;
use App\Models\Registration;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class nilaiProposalExport implements WithMultipleSheets
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
            'total_proposal_scores'
        ])
            ->where('status_supervisor', 'approved')
            ->whereYear('created_at', Carbon::now()->year) // hanya data tahun ini
            ->whereHas('registration_validation', function ($query) {
                $query->whereIn('status', ['Belum valid', 'Tidak Lolos', 'valid', 'lolos']);
            })
            ->orderBy('created_at', 'asc') // atau 'desc' jika ingin dari terbaru
            ->get();


        $sheets[] = new FirstProposalExport(
            $registrasis,

            'First ID '
        );



        return $sheets;
    }
}

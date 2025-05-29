<?php

namespace App\Exports;

use App\Http\Controllers\reviewer\ProposalReviewController;
use App\Models\Registration;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class nilaiProposalExport implements WithMultipleSheets
{


    public function sheets(): array
    {
        $sheets = [];

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
            ->whereHas('registration_validation', function ($query) {
                $query->whereIn('status', ['Belum valid', 'Tidak Lolos', 'valid', 'lolos']);
            })->get();

        foreach ($registrasis as $data) {
            $rubrik = ProposalReviewController::calculateScoresById($data->id);

            $sheets[] = new NilaiProposalPerTeam(
                $data,
                $rubrik,
                'ID ' . $data->id
            );
        }

        return $sheets;
    }
}

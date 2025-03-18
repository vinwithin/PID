<?php

namespace App\Http\Controllers;

use App\Http\Controllers\reviewer\ProposalReviewController;
use App\Models\Registration;
use App\Models\ReviewAssignment;
use App\Models\StatusMonev;
use App\Models\User;
use App\Services\ScoreDetailMonev;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generate($id_regis, $reviewer)
    {
        $rubrik = ProposalReviewController::calculateScoresById($id_regis);
        $total = ProposalReviewController::calculateScoresById($id_regis);
        $bobot = ProposalReviewController::calculateScoresById($id_regis);
        $reviewerId = User::where('name', $reviewer)->firstOrFail()->id;
        $dataPdf = [
            'data' => collect($rubrik['rubrik'])->only($reviewer)->all(),
            // 'review' => 
            'total' => $total['total'][$reviewer],
            'bobot' => $bobot['bobot'],
            'data_regis' => Registration::find($id_regis),
            'dataReviewId' => ReviewAssignment::where('registration_id', $id_regis)
                ->where('reviewer_id', $reviewerId)
                ->get(),

        ];
        // dd($dataPdf);

        $pdf = Pdf::loadView('pdf.template', $dataPdf);

        return $pdf->download("laporan_{$reviewer}.pdf");
    }
    public function generate_nilai($id_regis, $reviewer)
    {
        $rubrik = ScoreDetailMonev::scoreDetail($id_regis);
        $total = ScoreDetailMonev::scoreDetail($id_regis);
        $bobot = ScoreDetailMonev::scoreDetail($id_regis);
        $reviewerId = User::where('name', $reviewer)->firstOrFail()->id;
        $dataPdf = [
            'data' => collect($rubrik['rubrik'])->only($reviewer)->all(),
            // 'review' => 
            'total' => $total['total'][$reviewer],
            'bobot' => $bobot['bobot'],
            'data_regis' => Registration::find($id_regis),
            'dataReviewId' => StatusMonev::where('registration_id', $id_regis)
                ->where('user_id', $reviewerId)
                ->get(),

        ];
        // dd($dataPdf);

        $pdf = Pdf::loadView('pdf.monev', $dataPdf);

        return $pdf->download("laporan_{$reviewer}.pdf");
    }
}

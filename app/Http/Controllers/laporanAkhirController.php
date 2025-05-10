<?php

namespace App\Http\Controllers;

use App\Models\DokumenTeknis;
use App\Services\teamIdService;
use Illuminate\Http\Request;

class laporanAkhirController extends Controller
{

    protected $teamIdService;

    public function __construct(teamIdService $teamIdService)
    {
        $this->teamIdService = $teamIdService;
    }
    public function index(){
       $data = DokumenTeknis::where('team_id', $this->teamIdService->getRegistrationId())->get();
        return view('laporan-akhir.index', [
            'data' => $data,
        ]);
    }
}

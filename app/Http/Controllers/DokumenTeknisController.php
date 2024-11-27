<?php

namespace App\Http\Controllers;

use App\Models\DokumenTeknis;
use App\Services\DokumenTeknisService;
use App\Services\teamIdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenTeknisController extends Controller
{
    protected $dokumenTeknisService;
    protected $teamIdService;

    public function __construct(DokumenTeknisService $dokumenTeknisService, teamIdService $teamIdService)
    {
        $this->dokumenTeknisService = $dokumenTeknisService;
        $this->teamIdService = $teamIdService;

    }
    public function index()
    {
        return view('dokumen-teknis.create',[
            'dokumenExist' => DokumenTeknis::with('teamMembers')->whereHas('teamMembers', function ($query) {
                $query->where('registration_id', $this->teamIdService->getRegistrationId()); // Cek apakah NIM ada di tabel team_member
            })->exists()
        ]);
    }

    public function store(Request $request)
    {
        $result = $this->dokumenTeknisService->storeDokumenTeknis($request);
        if ($result) {
            return redirect()->route('dokumen-teknis')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumen-teknis')->with("error", "Gagal menambahkan data!");
        }
    }
}

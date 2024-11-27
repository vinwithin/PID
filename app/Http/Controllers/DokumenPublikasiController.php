<?php

namespace App\Http\Controllers;

use App\Models\DokumenPublikasi;
use App\Services\DokumenPublikasiService;
use App\Services\teamIdService;
use Illuminate\Http\Request;

class DokumenPublikasiController extends Controller
{
    protected $dokumenPublikasiService;
    protected $teamIdService;

    public function __construct(DokumenPublikasiService $dokumenPublikasiService, teamIdService $teamIdService)
    {
        $this->dokumenPublikasiService = $dokumenPublikasiService;
        $this->teamIdService = $teamIdService;
    }
    public function index(){
        return view('dokumen-publikasi.create',[
            'dokumenExist' => DokumenPublikasi::with('teamMembers')->whereHas('teamMembers', function ($query) {
                $query->where('registration_id', $this->teamIdService->getRegistrationId()); // Cek apakah NIM ada di tabel team_member
            })->exists()
        ]);
    }
    public function store(Request $request)
    {
        $result = $this->dokumenPublikasiService->storeDokumenPublikasi($request);
        if ($result) {
            return redirect()->route('dokumen-teknis')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumen-teknis')->with("error", "Gagal menambahkan data!");
        }
    }
}

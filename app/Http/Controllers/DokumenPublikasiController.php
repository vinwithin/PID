<?php

namespace App\Http\Controllers;

use App\Models\DokumenPublikasi;
use App\Models\Registration;
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
            'dataAdmin' => Registration::with(['dokumenPublikasi', 'registration_validation'])
            ->whereHas('registration_validation', function ($query) {
                $query->where('status', 'lolos');
            })->get(),
            'data' => DokumenPublikasi::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId())->get(),
            'dokumenExist' => DokumenPublikasi::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId()) 
            ->exists()
        ]);
    }
    public function store(Request $request)
    {
        $result = $this->dokumenPublikasiService->storeDokumenPublikasi($request);
        if ($result) {
            return redirect()->route('dokumen-publikasi')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumen-publikasi')->with("error", "Gagal menambahkan data!");
        }
    }

    public function edit($id){
        return view('dokumen-publikasi.edit',[
            'data' => DokumenPublikasi::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $result = $this->dokumenPublikasiService->updateDokumenPublikasi($request, $id);
        if ($result) {
            return redirect()->route('dokumen-publikasi')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumen-publikasi')->with("error", "Gagal menambahkan data!");
        }
    }
}

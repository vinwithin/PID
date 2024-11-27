<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiKegiatan;
use App\Models\User;
use App\Services\teamIdService;
use Illuminate\Http\Request;

class DokumenKegiatanController extends Controller
{
    protected $teamIdService;

    public function __construct(teamIdService $teamIdService)
    {
        $this->teamIdService = $teamIdService;
    }
    public function index(){
        return view('dokumentasi-kegiatan.create',[
            'dokumenExist' => DokumentasiKegiatan::with('teamMembers')->whereHas('teamMembers', function ($query) {
                $query->where('registration_id', $this->teamIdService->getRegistrationId()); // Cek apakah NIM ada di tabel team_member
            })->exists()
        ]);
    }
    public function store(Request $request){
        
        $validateData = $request->validate([
            'link_youtube' => 'required|string',
            'link_social_media' => 'required|string',
            'link_dokumentasi' => 'required|string',
        ]);
        $validateData['registration_id'] = $this->teamIdService->getRegistrationId();
        $result = DokumentasiKegiatan::create($validateData);
        if ($result) {
            return redirect()->route('dokumentasi-kegiatan')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumentasi-kegiatan')->with("error", "Gagal menambahkan data!");
        }
    }
}

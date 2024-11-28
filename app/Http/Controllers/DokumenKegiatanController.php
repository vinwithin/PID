<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiKegiatan;
use App\Models\Registration;
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
           'dataAdmin' => Registration::with(['dokumentasiKegiatan', 'registration_validation'])
            ->whereHas('registration_validation', function ($query) {
                $query->where('status', 'lolos');
            })->get(),
            'data' => DokumentasiKegiatan::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId())->get(),
            'dokumenExist' => DokumentasiKegiatan::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId()) 
                ->exists()
        ]);
    }
    public function store(Request $request){
        
        $validateData = $request->validate([
            'link_youtube' => 'required|string',
            'link_social_media' => 'required|string',
            'link_dokumentasi' => 'required|string',
        ]);
        $validateData['team_id'] = $this->teamIdService->getRegistrationId();
        $result = DokumentasiKegiatan::create($validateData);
        if ($result) {
            return redirect()->route('dokumentasi-kegiatan')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumentasi-kegiatan')->with("error", "Gagal menambahkan data!");
        }
    }
    public function edit($id){
        return view('dokumentasi-kegiatan.edit',[
            'data' => DokumentasiKegiatan::find($id),
        ]);
    }

    public function update(Request $request, $id){
        
        $validateData = $request->validate([
            'link_youtube' => 'required|string',
            'link_social_media' => 'required|string',
            'link_dokumentasi' => 'required|string',
        ]);
        $validateData['team_id'] = $this->teamIdService->getRegistrationId();
        $result = DokumentasiKegiatan::where('id', $id)->update($validateData);
        if ($result) {
            return redirect()->route('dokumentasi-kegiatan')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumentasi-kegiatan')->with("error", "Gagal menambahkan data!");
        }
    }
}

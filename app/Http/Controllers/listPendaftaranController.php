<?php

namespace App\Http\Controllers;

use App\Models\Registrasi_validation;
use App\Models\Registration;
use Illuminate\Http\Request;

class listPendaftaranController extends Controller
{
    public function index(){
        $dataNilai = Registration::with('registration_validation')->whereHas('registration_validation', function ($query) {
            $query->where('status', 'valid'); // Kondisi yang ingin dicek
        })->get();
        return view('list_pendaftaran',[
            'data' => Registration::all(),
            'dataNilai' => $dataNilai
        ]);
    }

    public function approve($id){
        $result = Registrasi_validation::where('registration_id', $id)
                  ->update(['status' => 'valid']);
        if ($result) {
            return redirect()->route('listPendaftaran')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('listPendaftaran')->with("error", "Gagal mengubah data!");
        }
    }
    
}

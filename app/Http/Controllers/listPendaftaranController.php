<?php

namespace App\Http\Controllers;

use App\Models\Registrasi_validation;
use App\Models\Registration;
use Illuminate\Http\Request;

class listPendaftaranController extends Controller
{
    public function index(){
        return view('list_pendaftaran',[
            'data' => Registration::all(),
        ]);
    }

    public function approve($id){
        $result = Registrasi_validation::where('registration_id', $id)
                  ->update(['status' => 'valid']);
        if ($result) {
            return redirect()->route('admin.listPendaftaran')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('admin.listPendaftaran')->with("error", "Gagal mengubah data!");
        }
    }
    
}

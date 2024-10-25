<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\Registration;
use Illuminate\Http\Request;

class reviewerListPendaftaranController extends Controller
{
    public function index()
    {
        $data = Registration::with('registration_validation')->whereHas('registration_validation', function ($query) {
            $query->where('status', 'valid'); // Kondisi yang ingin dicek
        })->get();
        return view('reviewer.pendaftaran.list_pendaftaran', [
            'data' => $data,
        ]);
    }
    public function nilai(Request $request, $id){
        $validateData = $request->validate([
            'nilai' => 'required',
        ]);
        $validateData["user_id"] = auth()->user()->id;
        $validateData["registration_id"] = $id;
        $result = Penilaian::create($validateData);
        if ($result) {
            return redirect()->route('reviewer.listPendaftaran')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('reviewer.listPendaftaran')->with("error", "Gagal mengubah data!");
        }

    }       
}

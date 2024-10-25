<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class listPendaftaranController extends Controller
{
    public function index(){
        return view('admin.pendaftaran.list_pendaftaran',[
            'data' => Registration::all(),
        ]);
    }
    
}

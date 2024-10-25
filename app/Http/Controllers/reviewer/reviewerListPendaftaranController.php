<?php

namespace App\Http\Controllers\reviewer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class reviewerListPendaftaranController extends Controller
{
    public function index(){
        return view('reviewer.pendaftaran.list_pendaftaran',[
            'data' => Registration::all(),
        ]);
    }
}

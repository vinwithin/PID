<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class mhsController extends Controller
{
    public function index(){
        return view('mahasiswa.dashboard');
    }
}

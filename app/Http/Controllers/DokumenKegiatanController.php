<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokumenKegiatanController extends Controller
{
    public function index(){
        return view('dokumentasi-kegiatan.create');
    }
}

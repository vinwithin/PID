<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokumenPublikasiController extends Controller
{
    public function index(){
        return view('dokumen-publikasi.create');
    }
}

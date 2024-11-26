<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokumenTeknisController extends Controller
{
    public function index(){
        return view('dokumen-teknis.create');
    }
}

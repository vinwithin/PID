<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;

class berandaController extends Controller
{
    public function index(){
        return view('guest.beranda', [
            'data' => Publikasi::where('status', 'valid')->get()
        ]);
    }
}

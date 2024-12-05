<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;

class berandaController extends Controller
{
    public function index()
    {
        return view('guest.beranda', [
            'data' => Publikasi::where('status', 'valid')
                ->orderBy('created_at', 'desc') // 'desc' untuk urutan terbaru ke lama
                ->get()
        ]);
    }

    public function detailPublikasi()
    {
        return view('guest.publikasi.index', [
            'data' => Publikasi::where('status', 'valid')->paginate(8),
        ]);
    }

    public function detail(Publikasi $publikasi)
    {
        return view('guest.publikasi.detail', [
            'data' => $publikasi
        ]);
    }
}

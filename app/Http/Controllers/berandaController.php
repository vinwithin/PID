<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Announcement;
use App\Models\DokumenPublikasi;
use App\Models\Publikasi;
use App\Models\VideoKonten;
use Illuminate\Http\Request;

class berandaController extends Controller
{
    public function index()
    {
        return view('guest.beranda', [
            'data' => Publikasi::where('status', 'valid')
                ->orderBy('created_at', 'desc') // Urutkan dari terbaru ke lama
                ->take(8) // Ambil hanya 8 data
                ->get(),
            'video' => VideoKonten::paginate(10),
            'foto' => Album::where('status', 'valid')->paginate(10),
            'artikel' => DokumenPublikasi::where('visibilitas', 'yes')->with(['teamMembers', 'registration'])->paginate(10),
            'announce' => Announcement::where('status', 'published')->latest()->take(2)->get()

        ]);
    }

    public function detailPublikasi()
    {
        return view('guest.publikasi.index', [
            'data' => Publikasi::where('status', 'valid')->paginate(12),
        ]);
    }

    public function detail(Publikasi $publikasi)
    {
        return view('guest.publikasi.detail', [
            'data' => $publikasi
        ]);
    }
}

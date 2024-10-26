<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class publikasiController extends Controller
{
    public function index()
    {
        return view('mahasiswa.publikasi.index', [
            "data" => Publikasi::all()
        ]);
    }

    public function show()
    {
        return view('mahasiswa.publikasi.create');
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:png,jpg,jpeg|max:2024',
        ]);
        $filepath = [];

        if ($request->hasFile('upload')) {
            $filepath = $request->file;
            $request->session()->put('image', $filepath);

            $originName = $request->file('upload')->getClientOriginalName();
            // $imageName = pathinfo($originName, PATHINFO_FILENAME);
            // $extension = $request->file('upload')->getClientOriginalExtension();
            $imageName = time() . '.' . $originName;
            // $url = Storage::temporaryUrl(
            //     $request->file, now()->addMinutes(5)
            // );
            // $request->file('upload')->move(public_path('media'), $imageName);
            // $request->file('upload')->storeAs('uploads', $imageName, 'public');

            // $request->file('upload')->storeAs('public/publikasi/', $imageName);
            $gambar = $request->session()->get('image', []);
            return response()->json(['fileName' => $imageName, 'uploaded' => 1, "url" => $gambar]);
            // $url = asset('storage/publikasi/' . $imageName);
        }
    }
}

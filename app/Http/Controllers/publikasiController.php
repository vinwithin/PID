<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class publikasiController extends Controller
{
    public function index()
    {
        return view('publikasi.index', [
            "data" => Publikasi::all()
        ]);
    }

    public function show()
    {
        return view('publikasi.create');
    }

    public function edit($id)
    {
        return view('publikasi.edit',[
            "data" => Publikasi::find($id)
        ]);
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:png,jpg,jpeg|max:2024',
        ]);
        $filepath = [];

        if ($request->hasFile('upload')) {
            $file = $request->file('upload')->getClientOriginalName();

            // $originName = $request->file('upload')->getClientOriginalName();
            // $imageName = pathinfo($originName, PATHINFO_FILENAME);
            // $extension = $request->file('upload')->getClientOriginalExtension();
            $imageName = time() . '.' . $file;
            $filepath = $imageName;
            // $request->file('upload')->storeAs('public', $imageName);
            // $url = asset('storage/' . $imageName);
            $request->session()->put('images', $filepath);
            $gambar = $request->session()->get('images');
            $url = asset('storage/'. $gambar);
            return response()->json(['fileName' => $imageName, 'uploaded' => 1, "url" => $url]);
        }
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $validateData['user_id'] = auth()->user()->id;
        $validateData['status'] = 'Belum valid';
        preg_match_all('/data:image[^>]+=/i', $validateData['content'], $matches);
        $imageTags = $matches[0];
            if (count($imageTags) > 0) {
                foreach ($imageTags as $tagImage) {
                    $image = preg_replace('/^data:image\/\w+;base64,/', '', $tagImage);
                    $extension = explode('/', explode(':', substr($tagImage, 0, strpos($tagImage, ';')))[1])[1];
                    $allowedTypes = ['jpeg', 'jpg', 'png', 'gif'];
                    if (!in_array($extension, $allowedTypes)) {
                        return response()->json([
                            'message' => 'Invalid image type. Allowed types: ' . implode(', ', $allowedTypes)
                        ], 422);
                    }
                    $imageName = Str::random(10) . '.' . $extension;
                    Storage::disk('public')->put('media/' . $imageName, base64_decode($image));
                    $validateData['content'] = str_replace($tagImage,  asset('/storage/media/'.$imageName), $validateData['content']);
                }
            }

        $result = Publikasi::create($validateData);
        if ($result) {
            return redirect()->route('publikasi')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('publikasi')->with("error", "Gagal menambahkan data!");
        }

    }

    public function detail($id){
        $publikasi = Publikasi::find($id);
        return view('mahasiswa.publikasi.detail',[
            'data' => $publikasi
        ]);
    }

    public function update(Request $request, $id){
        $validateData = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $validateData['user_id'] = auth()->user()->id;
        $validateData['status'] = 'Belum valid';
        preg_match_all('/data:image[^>]+=/i', $validateData['content'], $matches);
        $imageTags = $matches[0];
            if (count($imageTags) > 0) {
                foreach ($imageTags as $tagImage) {
                    $image = preg_replace('/^data:image\/\w+;base64,/', '', $tagImage);
                    $extension = explode('/', explode(':', substr($tagImage, 0, strpos($tagImage, ';')))[1])[1];
                    $allowedTypes = ['jpeg', 'jpg', 'png', 'gif'];
                    if (!in_array($extension, $allowedTypes)) {
                        return response()->json([
                            'message' => 'Invalid image type. Allowed types: ' . implode(', ', $allowedTypes)
                        ], 422);
                    }
                    $imageName = Str::random(10) . '.' . $extension;
                    Storage::disk('public')->put('media/' . $imageName, base64_decode($image));
                    $validateData['content'] = str_replace($tagImage,  asset('/storage/media/'.$imageName), $validateData['content']);
                }
            }

        $result = Publikasi::where('id', $id)->update($validateData);
        if ($result) {
            return redirect()->route('publikasi')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('publikasi')->with("error", "Gagal menambahkan data!");
        }
    }
}

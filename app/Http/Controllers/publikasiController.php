<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class publikasiController extends Controller
{
    public function index()
    {
        return view('publikasi.index', [
            "data" => Publikasi::where('user_id', auth()->user()->id)->get()
        ]);
    }

    public function show()
    {
        return view('publikasi.create');
    }

    public function edit($id)
    {
        return view('publikasi.edit', [
            "data" => Publikasi::find($id)
        ]);
    }

    public function filter(Request $request)
    {
        $filters = $request->input('filters', []);

        if (empty($filters)) {
            $data = Publikasi::all();
        } else {
            $data = Publikasi::where('status', $filters)->get();
        }

        return view('publikasi.index', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:2024',
        ]);
        $validateData['user_id'] = auth()->user()->id;
        $validateData['slug'] = SlugService::createSlug(Publikasi::class, 'slug', $validateData['title']);
        $validateData['status'] = 'Belum valid';
        $thumbnail_name = time() . '_' . $request->thumbnail->getClientOriginalName();
        // $request->thumbnail->storeAs('storage/media/thumbnails', $thumbnail_name);
        Storage::disk('public')->put('media/thumbnails/' . $thumbnail_name, $request->thumbnail);
        $validateData['thumbnail'] = $thumbnail_name;
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
                $validateData['content'] = str_replace($tagImage,  asset('/storage/media/' . $imageName), $validateData['content']);
            }
        }

        $result = Publikasi::create($validateData);
        if ($result) {
            return redirect()->route('publikasi')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('publikasi')->with("error", "Gagal menambahkan data!");
        }
    }

    public function detail($id)
    {
        $publikasi = Publikasi::find($id);
        return view('publikasi.detail', [
            'data' => $publikasi
        ]);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $validateData['user_id'] = auth()->user()->id;
        $validateData['slug'] = SlugService::createSlug(Publikasi::class, 'slug', $validateData['title']);
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
                $validateData['content'] = str_replace($tagImage,  asset('/storage/media/' . $imageName), $validateData['content']);
            }
        }

        $result = Publikasi::where('id', $id)->update($validateData);
        if ($result) {
            return redirect()->route('publikasi')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('publikasi')->with("error", "Gagal menambahkan data!");
        }
    }

    public function approve($id)
    {
        $result = Publikasi::where('id', $id)
            ->update(['status' => 'valid']);
        if ($result) {
            return redirect()->route('publikasi')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('publikasi')->with("error", "Gagal mengubah data!");
        }
    }

    public function destroy($id){
        $firstRow = Publikasi::select('content')->find($id);
        $imageTags = [];
        if ($firstRow) {
            // Use regular expression to extract img tags
            preg_match_all('/storage[^>]+(png|jpg|jpeg)/i', $firstRow->body, $matches);

            // Add extracted img tags to the array
            $imageTags = $matches[0];
            if (count($imageTags) > 0) {
                foreach ($imageTags as $tag) {

                    // Delete the file
                    unlink($tag);
                }
            }
        }
        // unlink("storage/media/artikel/thumbnails/".$artikel->image_artikel);
        Publikasi::where('id', $id)->delete();
        return redirect()->route('publikasi')->with('success', 'Artikel Berhasil Dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class beritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%");
        }

        $data = $query->with('user')->paginate(10);
        return view('berita.index', [
            'data' => $data
        ]);
    }
    public function create()
    {
        return view('berita.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:3024',
        ]);
        $validateData['created_by'] = Auth::user()->id;
        $validateData['slug'] = SlugService::createSlug(Berita::class, 'slug', $validateData['title']);
        $validateData["excerpt"] =  Str::limit(strip_tags($request->content), 100);
        if ($request->hasFile('thumbnail')) {
            $thumbnail_name = time() . '_' . $request->thumbnail->getClientOriginalName();
            $path = $request->thumbnail->storeAs('berita', $thumbnail_name, 'public');
            $validateData['thumbnail'] = $path;
        }
        $result = Berita::create($validateData);
        if ($result) {
            return redirect()->route('berita')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('berita')->with("error", "Gagal menambahkan data!");
        }
    }

    public function edit($id)
    {
        return view('berita.edit', [
            'data' => Berita::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:3024',
        ]);
        $validateData['created_by'] = Auth::user()->id;
        $validateData['slug'] = SlugService::createSlug(Berita::class, 'slug', $validateData['title']);
        $validateData["excerpt"] =  Str::limit(strip_tags($request->content), 100);
        $photo = Berita::where('id', $id)->get();
        if (!empty($photo->thumbnail)) {
            Storage::disk('public')->delete($photo->thumbnail);
        }
        if ($request->hasFile('thumbnail')) {
            $thumbnail_name = time() . '_' . $request->thumbnail->getClientOriginalName();
            $path = $request->thumbnail->storeAs('berita', $thumbnail_name, 'public');
            $validateData['thumbnail'] = $path;
        }
        $result = Berita::where('id', $id)->update($validateData);
        if ($result) {
            return redirect()->route('berita')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('berita')->with("error", "Gagal menambahkan data!");
        }
    }
    public function detail($id)
    {
        return view('berita.detail', [
            'data' => Berita::find($id),
        ]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Ambil semua foto yang terkait dengan album
            $photo = Berita::where('id', $id)->get();
            // Hapus setiap foto dari storage
            if (!empty($photo->thumbnail)) {
                Storage::disk('public')->delete($photo->thumbnail);
            }
            // Hapus data dari database
            Berita::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('berita')->with('success', 'Album dan foto berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

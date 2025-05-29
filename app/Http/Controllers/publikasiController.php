<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use App\Services\teamIdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class publikasiController extends Controller
{
    protected $teamIdService;

    public function __construct(teamIdService $teamIdService)
    {
        $this->teamIdService = $teamIdService;
    }
    public function index(Request $request)
    {
        $filters = $request->input('filters', []);
        $search = $request->input('search');

        $query = Publikasi::with('registration');

        // Filter berdasarkan status jika ada
        if (!empty($filters)) {
            $query->whereIn('status', $filters);
        }

        // Filter berdasarkan pencarian jika ada
        if (!empty($search)) {
            $query->where('title', 'like', "%$search%");
        }

        // Urutkan berdasarkan tanggal terbaru
        $dataAll = $query->latest()->paginate(10);

        return view('publikasi.index', [
            "data" => Publikasi::with('registration')
                ->where('team_id', $this->teamIdService->getRegistrationId())
                ->orderBy('created_at', 'desc')
                ->latest()
                ->paginate(10),
            "dataAll" => $dataAll,
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
            $data = Publikasi::with('registration')
                ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
                ->get();
        } else {
            $data = Publikasi::with('registration')->where('status', $filters)->get();
        }

        return view('publikasi.index', [
            'dataAll' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:3024',
        ]);
        $validateData['user_id'] = Auth::user()->id;
        $validateData['slug'] = SlugService::createSlug(Publikasi::class, 'slug', $validateData['title']);
        if (Auth::user()->hasRole('admin')) {
            $validateData['status'] = 'valid';
            $validateData['team_id'] = '';
        } else {
            $validateData['status'] = 'Belum valid';
            $validateData['team_id'] = $this->teamIdService->getRegistrationId();
        }
        $validateData["excerpt"] =  Str::limit(strip_tags($request->content), 100);
        $thumbnail_name = time() . '_' . $request->thumbnail->getClientOriginalName();
        $request->thumbnail->storeAs('public/media/thumbnails', $thumbnail_name);
        $validateData['thumbnail'] = $thumbnail_name;

        preg_match_all('/data:image\/[a-zA-Z]+;base64,([^\"]+)/', $validateData['content'], $matches);
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
            'content' => 'required',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:2024',

        ]);
        $validateData['user_id'] = Auth::user()->id;
        $validateData['status'] = 'Belum valid';
        $validateData['slug'] = SlugService::createSlug(Publikasi::class, 'slug', $validateData['title']);
        $validateData["excerpt"] =  Str::limit(strip_tags($request->content), 100);
        if ($request->hasFile('thumbnail')) {
            $thumbnail_name = time() . '_' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->storeAs('public/media/thumbnails', $thumbnail_name);
            $validateData['thumbnail'] = $thumbnail_name;
        }
        preg_match_all('/data:image\/[a-zA-Z]+;base64,([^\"]+)/', $validateData['content'], $matches);
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
    public function reject($id)
    {
        $result = Publikasi::where('id', $id)
            ->update(['status' => 'Ditolak']);
        if ($result) {
            return redirect()->route('publikasi')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('publikasi')->with("error", "Gagal mengubah data!");
        }
    }

    public function destroy($id)
    {
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

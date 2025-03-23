<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhotos;
use App\Models\DokumentasiKegiatan;
use App\Models\VideoKonten;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KelolaKontenController extends Controller
{
    public function extractYouTubeVideoId($url)
    {
        $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
        preg_match($regExp, $url, $match);
        return (isset($match[7]) && strlen($match[7]) == 11) ? $match[7] : null;
    }
    public function index()
    {
        return view('kelola-konten.video.index', [
            'data' => VideoKonten::with(['dokumentasi_kegiatan'])->paginate(10),
        ]);
    }
    public function updateStatus(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required', // Ganti 'your_table' dengan nama tabel yang sesuai
            'status' => 'required|in:On,Off' // Pastikan status hanya 'On' atau 'Off'
        ]);

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // $item = VideoKonten::find($request->id); // Ambil data berdasarkan ID

            if ($request->status == 'On') {
                // Jika status 'On', simpan link_youtube
                VideoKonten::where('id', $request->id)->update(['visibilitas' => 'on']);
            } else {
                // Jika status 'Off', hapus data terkait berdasarkan media_dokumentasi_id
                VideoKonten::where('id', $request->id)->update(['visibilitas' => 'off']);
            }

            // $item->save(); // Simpan perubahan

            // Commit transaksi
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function foto()
    {
        return view('kelola-konten.foto.index', [
            'data' => Album::with(['album_photos'])->paginate(10)
        ]);
    }
    public function createFoto()
    {
        return view('kelola-konten.foto.create');
    }

    public function storeFoto(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_album' => 'required|string',
                'album_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            DB::beginTransaction();

            $album = Album::create(['nama' => $validatedData['nama_album'], 'status' => "belum valid"]);

            // Simpan foto-foto album
            if ($request->hasFile('album_photos')) {
                foreach ($request->file('album_photos') as $photo) {
                    $filename = time() . '_' . $photo->getClientOriginalName();
                    $path = $photo->storeAs('album_photos', $filename, 'public');
                    AlbumPhotos::create([
                        'album_id' => $album->id,
                        'path_photos' => $path
                    ]);
                }
            }

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->route('kelola-konten.foto')->with('success', 'Berhasil menambahkan data');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('kelola-konten.foto')->with('success', 'Berhasil menambahkan data');
        }
    }
    public function editFoto($id)
    {
        return view('kelola-konten.foto.edit', [
            'data' => Album::with(['album_photos'])->find($id),
        ]);
    }
    public function updateFoto(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_album' => 'required|string',
            'album_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // Update nama album
            Album::where('id', $id)->update(['nama' => $validatedData['nama_album']]);

            // Jika ada file baru, hapus semua foto lama lalu tambahkan yang baru
            if ($request->hasFile('album_photos')) {
                // Ambil foto lama dari database
                $oldPhotos = AlbumPhotos::where('album_id', $id)->get();

                // Hapus hanya jika ada foto lama
                foreach ($oldPhotos as $oldPhoto) {
                    if (!empty($oldPhoto->path_photos)) { // Cek apakah path_photos tidak null
                        Storage::disk('public')->delete($oldPhoto->path_photos);
                    }
                }

                // Hapus semua data lama di database
                AlbumPhotos::where('album_id', $id)->delete();

                // Simpan foto baru
                foreach ($request->file('album_photos') as $photo) {
                    $filename = time() . '_' . $photo->getClientOriginalName();
                    $path = $photo->storeAs('album_photos', $filename, 'public');

                    AlbumPhotos::create([
                        'album_id' => $id,
                        'path_photos' => $path
                    ]);
                }
            }


            DB::commit();
            return redirect()->route('kelola-konten.foto')->with('success', 'Album berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function deleteFoto($id)
    {
        DB::beginTransaction();
        try {
            // Ambil semua foto yang terkait dengan album
            $photos = AlbumPhotos::where('album_id', $id)->get();

            // Hapus setiap foto dari storage
            foreach ($photos as $photo) {
                if (!empty($photo->path_photos)) {
                    Storage::disk('public')->delete($photo->path_photos);
                }
            }

            // Hapus data dari database
            AlbumPhotos::where('album_id', $id)->delete();
            Album::where('id', $id)->delete();

            DB::commit();
            return redirect()->route('kelola-konten.foto')->with('success', 'Album dan foto berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function detail($id)
    {
        return view('kelola-konten.foto.detail', [
            'data' => AlbumPhotos::where('album_id', $id)->get()
        ]);
    }


    public function updateStatusFoto(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required', // Ganti 'your_table' dengan nama tabel yang sesuai
            'condition' => 'required|in:On,Off' // Pastikan status hanya 'On' atau 'Off'
        ]);

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // $item = VideoKonten::find($request->id); // Ambil data berdasarkan ID

            if ($request->condition == 'On') {
                // Jika status 'On', simpan link_youtube
                Album::where('id', $request->id)->update([
                    'status' => 'valid'
                ]);
            } else {
                // Jika status 'Off', hapus data terkait berdasarkan media_dokumentasi_id
                Album::where('id', $request->id)->update([
                    'status' => 'belum valid'
                ]);
            }

            // $item->save(); // Simpan perubahan

            // Commit transaksi
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            return redirect()->route('kelola-konten.foto')->with("error", "Gagal mengubah data!");
        }
    }

    public function create()
    {
        return view('kelola-konten.video.create');
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'link_youtube' => 'required|string'
        ]);
        $videoId = $this->extractYouTubeVideoId($validateData['link_youtube']);
        if (!$videoId) {
            return redirect()->route('kelola-konten.video')->with('error', 'Link video tidak valid!');
        }
        $validateData['link_youtube'] = "https://www.youtube.com/embed/" . $videoId;
        $validateData['created_by'] = Auth::user()->name;
        $validateData['visibilitas'] = 'off';
        DB::beginTransaction();
        $result = VideoKonten::create($validateData);
        DB::commit();
        if ($result) {
            return redirect()->route('kelola-konten.video')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('kelola-konten.video')->with("error", "Gagal mengubah data!");
        }
    }
    public function edit($id){
        return view('kelola-konten.video.edit', [
            'data' => VideoKonten::find($id),
        ]);
    }
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'link_youtube' => 'required|string'
        ]);
        $videoId = $this->extractYouTubeVideoId($validateData['link_youtube']);
        if (!$videoId) {
            return redirect()->route('kelola-konten.video')->with('error', 'Link video tidak valid!');
        }
        $validateData['link_youtube'] = "https://www.youtube.com/embed/" . $videoId;
        $validateData['visibilitas'] = 'on';
        DB::beginTransaction();
        $result = VideoKonten::where('id', $id)->update($validateData);
        DB::commit();
        if ($result) {
            return redirect()->route('kelola-konten.video')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('kelola-konten.video')->with("error", "Gagal mengubah data!");
        }
    }
    public function destroy($id){
        DB::beginTransaction();
        try {
            // Hapus data dari database
            VideoKonten::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('kelola-konten.video')->with('success', 'Video berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

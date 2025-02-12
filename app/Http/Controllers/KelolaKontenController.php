<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\DokumentasiKegiatan;
use App\Models\VideoKonten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaKontenController extends Controller
{
    public function index(){
        return view('kelola-konten.video.index', [
            'data' => DokumentasiKegiatan::with(['video_konten'])->paginate(10),
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
                VideoKonten::create([
                    'link_youtube' => $request->link_youtube,
                    'media_dokumentasi_id' => $request->id
                ]);
            } else {
                // Jika status 'Off', hapus data terkait berdasarkan media_dokumentasi_id
                VideoKonten::where('media_dokumentasi_id', $request->id)->delete();
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

    public function foto(){
        return view('kelola-konten.foto.index', [
            'data' => Album::with(['album_photos'])->paginate(10)
        ]);
    }

    public function detail($id){
        return view('kelola-konten.foto.detail',[
            'data' => Album::where('media_dokumentasi_id', $id)->get()
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
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

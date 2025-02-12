<?php

namespace App\Http\Controllers;

use App\Models\DokumenPublikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaArtikel extends Controller
{
    public function index(){
        return view('kelola-konten.artikel.index', [
            'data' => DokumenPublikasi::with(['teamMembers', 'registration'])->paginate(10),
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
                DokumenPublikasi::where('id', $request->id)->update([
                    'visibilitas' => 'yes'
                ]);
            } else {
                // Jika status 'Off', hapus data terkait berdasarkan media_dokumentasi_id
                DokumenPublikasi::where('id', $request->id)->update([
                    'visibilitas' => 'no'
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

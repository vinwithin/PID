<?php

namespace App\Http\Controllers;

use App\Models\LaporanKemajuan;
use App\Models\Registration;
use App\Services\teamIdService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanKemajuanController extends Controller
{
    protected $teamIdService;

    public function __construct(teamIdService $teamIdService)
    {
        $this->teamIdService = $teamIdService;
    }
    private function storeFile($file, $prefix)
    {
        $fileName = $prefix . '_' . $file->getClientOriginalName();
        $file->storeAs('public/laporan-kemajuan/', $fileName);

        return $fileName;
    }
    public function index(Request $request)
    {
        $team_id = $this->teamIdService->getRegistrationId();
        $dataAll = Registration::select('id', 'judul')->with(['laporan_kemajuan', 'registration_validation'])
            ->whereHas('registration_validation', function ($query) {
                $query->whereIn('status', ['lolos', 'lanjutkan program']);
            });

        // Tambahkan pencarian jika ada parameter 'search'
        if ($request->has('search')) {
            $search = $request->input('search');
            $dataAll->where('judul', 'like', "%$search%");
        }

        // Cek jika user adalah reviewer, tambahkan filter status valid
        if (Auth::user()->hasRole(['reviewer', 'dosen'])) {
            $dataAll->whereHas('laporan_kemajuan', function ($query) {
                $query->where('status', 'Valid');
            });
        }
        $dataAll = $dataAll->paginate(10);

        return view('laporan-kemajuan.index', [
            'data'  => LaporanKemajuan::where('team_id', $team_id)->get(),
            'dataAdmin' => $dataAll,
        ]);
    }


    public function store(Request $request)
    {
        $validateData = $request->validate([
            'file' => 'required', // Hanya menerima PDF dan DOC/DOCX, maksimal 2MB
        ]);

        $team_id = $this->teamIdService->getRegistrationId();
        // Ambil user yang sedang login
        $existingLaporan = LaporanKemajuan::where('team_id', $team_id)->first();

        // Jika sudah ada laporan sebelumnya, hapus file lama
        if ($existingLaporan && $existingLaporan->file_path) {
            Storage::delete($existingLaporan->file_path);
        }

        // Simpan file baru
        $filename = $this->storeFile($request->file('file'), 'file_laporan_kemajuan_' . $team_id);


        // Jika laporan sudah ada, update; jika belum, buat baru
        if ($existingLaporan) {
            $existingLaporan->update(['file_path' => $filename, 'status' => 'pending', 'komentar' => '']);
        } else {
            LaporanKemajuan::create([
                'team_id' => $team_id,
                'file_path' => $filename,
                'status' => 'pending', // Default status
            ]);
        }

        return response()->json([
            'message' => 'Laporan berhasil diunggah',
        ]);
    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $result = LaporanKemajuan::where('id', $id)
                ->update(['status' => 'Valid']);

            DB::commit();
            if ($result) {
                return redirect()->route('laporan-kemajuan')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('laporan-kemajuan')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('laporan-kemajuan')->with("error", "Gagal mengubah data!");
        };
    }
    public function reject(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validateData = $request->validate([
                'komentar' => 'required|string|min:1',
            ]);
            $result = LaporanKemajuan::where('id', $id)
                ->update(['status' => 'Ditolak', 'komentar' => $validateData['komentar']]);

            DB::commit();
            if ($result) {
                return redirect()->route('laporan-kemajuan')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('laporan-kemajuan')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('laporan-kemajuan')->with("error", "Gagal mengubah data!");
        };
    }
}

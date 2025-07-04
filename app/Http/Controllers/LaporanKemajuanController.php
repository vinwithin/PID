<?php

namespace App\Http\Controllers;

use App\Models\LaporanKemajuan;
use App\Models\Registration;
use App\Services\teamIdService;
use Carbon\Carbon;
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
        $year = $request->filled('tahun') ? $request->tahun : Carbon::now()->year;
        $search = $request->input('search');

        // Query untuk data Admin / Reviewer / Dosen
        $dataAllQuery = Registration::select('id', 'judul')
            ->with(['laporan_kemajuan', 'registration_validation'])
            ->whereYear('created_at', $year)
            ->whereHas('registration_validation', function ($query) {
                $query->whereIn('status', ['lolos', 'Lanjutkan Program']);
            });

        // Tambahkan filter pencarian jika ada
        if ($search) {
            $dataAllQuery->where('judul', 'like', "%$search%");
        }

        // Filter tambahan berdasarkan role user
        if (Auth::user()->hasRole('reviewer')) {
            $dataAllQuery->whereHas('laporan_kemajuan', function ($query) {
                $query->where('status', 'Valid');
            });
        } elseif (Auth::user()->hasRole('dosen')) {
            $dataAllQuery->where('nama_dosen_pembimbing', Auth::user()->id);
        }

        // Paginate hasil query Admin/Reviewer/Dosen
        $dataAll = $dataAllQuery->latest()->paginate(10);

        // Data Mahasiswa: Laporan Kemajuan milik tim-nya sendiri
        $currentYear = Carbon::now()->year;
        $userData = LaporanKemajuan::where('team_id', $team_id)
            ->whereYear('created_at', $currentYear)
            ->get();

        return view('laporan-kemajuan.index', [
            'data' => $userData,
            'dataAdmin' => $dataAll,
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:5048',
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
            $existingLaporan->update(['file_path' => $filename, 'status' => 'Belum Valid', 'komentar' => '']);
        } else {
            LaporanKemajuan::create([
                'team_id' => $team_id,
                'file_path' => $filename,
                'status' => 'Belum Valid', // Default status
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

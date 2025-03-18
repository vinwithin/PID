<?php

namespace App\Http\Controllers;

use App\Models\DokumenPublikasi;
use App\Models\Registration;
use App\Services\DokumenPublikasiService;
use App\Services\teamIdService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokumenPublikasiController extends Controller
{
    protected $dokumenPublikasiService;
    protected $teamIdService;

    public function __construct(DokumenPublikasiService $dokumenPublikasiService, teamIdService $teamIdService)
    {
        $this->dokumenPublikasiService = $dokumenPublikasiService;
        $this->teamIdService = $teamIdService;
    }
    public function index(Request $request)
    {
        $dataAll = Registration::with(['dokumenPublikasi', 'registration_validation'])
            ->whereHas('registration_validation', function ($query) {
                $query->where('status', 'Lanjutkan Program');
            })->paginate(10);

        $query = Registration::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('judul', 'like', "%$search%");
            $dataAll = $query->with(['dokumenPublikasi', 'registration_validation'])->whereHas('registration_validation', function ($query) {
                $query->where('status', 'Lanjutkan Program');
            })->paginate(10);
        }
        return view('dokumen-publikasi.create', [
            'dataAdmin' => $dataAll,
            'data' => DokumenPublikasi::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId())->get(),
            'dokumenExist' => DokumenPublikasi::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId())
                ->exists()
        ]);
    }
    public function store(Request $request)
    {
        $result = $this->dokumenPublikasiService->storeDokumenPublikasi($request);
        if ($result) {
            return redirect()->route('dokumen-publikasi')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumen-publikasi')->with("error", "Gagal menambahkan data!");
        }
    }

    public function edit($id)
    {
        return view('dokumen-publikasi.edit', [
            'data' => DokumenPublikasi::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $result = $this->dokumenPublikasiService->updateDokumenPublikasi($request, $id);
        if ($result) {
            return redirect()->route('dokumen-publikasi')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumen-publikasi')->with("error", "Gagal menambahkan data!");
        }
    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $result = DokumenPublikasi::where('id', $id)
                ->update(['status' => 'Valid']);

            DB::commit();
            if ($result) {
                return redirect()->route('dokumen-publikasi')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('dokumen-publikasi')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('dokumen-publikasi')->with("error", "Gagal mengubah data!");
        };
    }
    public function reject($id)
    {
        try {
            DB::beginTransaction();
            $result = DokumenPublikasi::where('id', $id)
                ->update(['status' => 'Ditolak']);

            DB::commit();
            if ($result) {
                return redirect()->route('dokumen-publikasi')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('dokumen-publikasi')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('dokumen-publikasi')->with("error", "Gagal mengubah data!");
        };
    }
}

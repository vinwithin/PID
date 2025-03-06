<?php

namespace App\Http\Controllers;

use App\Models\DokumenTeknis;
use App\Models\Registration;
use App\Models\TeamMember;
use App\Services\DokumenTeknisService;
use App\Services\teamIdService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DokumenTeknisController extends Controller
{
    protected $dokumenTeknisService;
    protected $teamIdService;

    public function __construct(DokumenTeknisService $dokumenTeknisService, teamIdService $teamIdService)
    {
        $this->dokumenTeknisService = $dokumenTeknisService;
        $this->teamIdService = $teamIdService;

    }
    public function index()
    {
        return view('dokumen-teknis.create',[
            'dataAdmin' => Registration::with(['dokumenTeknis', 'registration_validation'])
            ->whereHas('registration_validation', function ($query) {
                $query->where('status', 'Lanjutkan Program');
            })->get(),
            'data' => DokumenTeknis::where('team_id', $this->teamIdService->getRegistrationId())->get(),
            'dokumenExist' => DokumenTeknis::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId())->exists()
        ]);
    }

    public function store(Request $request)
    {
        $result = $this->dokumenTeknisService->storeDokumenTeknis($request);
        if ($result) {
            return redirect()->route('dokumen-teknis')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumen-teknis')->with("error", "Gagal menambahkan data!");
        }
    }

    public function edit($id){
        return view('dokumen-teknis.edit',[
            'data' => DokumenTeknis::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $result = $this->dokumenTeknisService->updateDokumenTeknis($request, $id);
        if ($result) {
            return redirect()->route('dokumen-teknis')->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->route('dokumen-teknis')->with("error", "Gagal menambahkan data!");
        }
    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $result = DokumenTeknis::where('id', $id)
                ->update(['status' => 'Valid']);
            
            DB::commit();
            if ($result) {
                return redirect()->route('dokumen-teknis')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('dokumen-teknis')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('dokumen-teknis')->with("error", "Gagal mengubah data!");
        };
    }
    public function reject($id)
    {
        try {
            DB::beginTransaction();
            $result = DokumenTeknis::where('id', $id)
                ->update(['status' => 'Ditolak']);
            
            DB::commit();
            if ($result) {
                return redirect()->route('dokumen-teknis')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('dokumen-teknis')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('dokumen-teknis')->with("error", "Gagal mengubah data!");
        };
    }
}

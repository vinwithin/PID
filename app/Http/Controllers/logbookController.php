<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\logbookValidations;
use App\Services\teamIdService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class logbookController extends Controller
{
    protected $teamIdService;

    public function __construct(teamIdService $teamIdService)
    {
        $this->teamIdService = $teamIdService;
    }
    public function index(Request $request)
    {

        $search = request('search');

        $logbooksQuery = Logbook::with(['teamMembers', 'logbook_validations', 'registration'])
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('logbooks')
                    ->groupBy('team_id');
            })
            ->where('status', 'Valid');

        if ($search) {
            $logbooksQuery->where(function ($query) use ($search) {
                $query->whereHas('registration', function ($q) use ($search) {
                    $q->where('nama_ketua', 'like', "%{$search}%")
                        ->orWhere('judul', 'like', "%{$search}%");
                });
            })->orWhereHas('registration.user', function ($query) use ($search) {
                $query->where('nama_dosen_pembimbing', 'like', "%{$search}%");
            });
        }
        if ($request->filled('tahun')) {
            $logbooksQuery->whereYear('created_at', $request->tahun);
        }

        $logbooks = $logbooksQuery->latest()->paginate(10);


        // Untuk dospem
        $dospemQuery = Logbook::with(['teamMembers', 'logbook_validations', 'registration'])
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('logbooks')
                    ->groupBy('team_id');
            })->whereHas('registration', function ($query) {
                $query->where('nama_dosen_pembimbing', Auth::user()->id);
            });

        if ($search) {
            $dospemQuery->where(function ($query) use ($search) {
                $query->whereHas('registration', function ($q) use ($search) {
                    $q->where('nama_ketua', 'like', "%{$search}%")
                        ->orWhere('judul', 'like', "%{$search}%");
                });
            })->orWhereHas('registration.user', function ($query) use ($search) {
                $query->where('nama_dosen_pembimbing', 'like', "%{$search}%");
            });
        }
        if ($request->filled('tahun')) {
            $dospemQuery->whereYear('created_at', $request->tahun);
        }
        $dospem = $dospemQuery->latest()->paginate(10);

        $currentYear = Carbon::now()->year;
        $data_user = Logbook::with(['registration', 'teamMembers', 'logbook_validations'])->where('team_id', $this->teamIdService->getRegistrationId());

        if ($search) {
            $data_user->where(function ($query) use ($search) {
                $query->where('status', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%")
                    ->orWhere('link_bukti', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $data = $data_user->paginate(10);

        return view('logbook.index', [
            'data' => $data,
            'dataAdmin' => $logbooks,
            'dataDospem' => $dospem
        ]);
    }

    public function detail($id)
    {
        return view('logbook.admin.detail', [
            'data_dospem' => Logbook::with(['teamMembers', 'logbook_validations', 'registration'])
                ->where('team_id', $id)
                ->paginate(10),
            'data' => Logbook::with(['teamMembers', 'logbook_validations', 'registration'])
                ->where('team_id', $id)
                ->where('status', 'Valid')
                ->paginate(10),

        ]);
    }

    public function create()
    {
        return view('logbook.create');
    }

    public function edit($id)
    {
        return view('logbook.edit', [
            'data' => Logbook::find($id),
        ]);
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|min:50',
            'link_bukti' => 'required|url|max:255',
        ]);
        $validateData['team_id'] = $this->teamIdService->getRegistrationId();
        $validateData['status'] = 'Menunggu Validasi';
        $result = Logbook::create($validateData);
        if ($result) {
            return redirect()->route('logbook')->with('success', 'berhasil manambah data');
        } else {
            return redirect()->route('logbook')->with("error", "Gagal menambah data!");
        }
    }

    public function update(Request $request, $id)
    {

        $validateData = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|min:50',
            'link_bukti' => 'required|url|max:255',
        ]);
        $validateData['status'] = 'Menunggu Validasi';
        LogbookValidations::where('logbook_id', $id)->delete();
        $result = Logbook::where('id', $id)->update($validateData);
        if ($result) {
            return redirect()->route('logbook')->with('success', 'berhasil mengubah data');
        } else {
            return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
        }
    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $result = Logbook::where('id', $id)
                ->update(['status' => 'Valid']);

            DB::commit();
            if ($result) {
                return redirect()->back()->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
        };
    }
    public function reject($id)
    {
        try {
            DB::beginTransaction();
            $result = Logbook::where('id', $id)
                ->update(['status' => 'Ditolak']);

            DB::commit();
            if ($result) {
                return redirect()->back()->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
        };
    }
    public function approveAdmin($id)
    {
        try {
            DB::beginTransaction();
            $result = LogbookValidations::updateOrCreate(
                [
                    'logbook_id' => $id,
                    'validated_by' => Auth::user()->id,
                    'role' => Auth::user()->getRoleNames()->first(),
                ],
                [
                    'status' => 'Valid'
                ]
            );


            DB::commit();
            if ($result) {
                return redirect()->back()->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
        };
    }
    public function rejectAdmin($id)
    {
        try {
            DB::beginTransaction();

            $result = LogbookValidations::updateOrCreate(
                [
                    'logbook_id' => $id,
                    'validated_by' => Auth::user()->id,
                    'role' => Auth::user()->getRoleNames()->first(),
                ],
                [
                    'status' => 'Ditolak'
                ]
            );


            DB::commit();
            if ($result) {
                return redirect()->back()->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('logbook')->with("error", "Gagal mengubah data!");
        };
    }
}

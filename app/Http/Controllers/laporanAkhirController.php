<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhotos;
use App\Models\DocumentFinalReport;
use App\Models\DocumentTypes;
use App\Models\DokumenTeknis;
use App\Models\Registration;
use App\Models\VideoKonten;
use App\Services\teamIdService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class laporanAkhirController extends Controller
{

    protected $teamIdService;

    public function __construct(teamIdService $teamIdService)
    {
        $this->teamIdService = $teamIdService;
    }
    public function extractYouTubeVideoId($url)
    {
        $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
        preg_match($regExp, $url, $match);
        return (isset($match[7]) && strlen($match[7]) == 11) ? $match[7] : null;
    }
    public function index(Request $request)
    {
        $search = request('search');
        $year = $request->filled('tahun')
            ? $request->tahun
            : Carbon::now()->year;
        $dataQuery = DocumentFinalReport::with(['teamMembers', 'registration'])
            ->whereYear('created_at', $year)
            ->whereIn('id', function ($query) {
                $query->selectRaw('MIN(id)')
                    ->from('document_final_reports')
                    ->groupBy('team_id');
            });

        if ($search) {
            $dataQuery->where(function ($query) use ($search) {
                $query->whereHas('registration', function ($q) use ($search) {
                    $q->where('nama_ketua', 'like', "%{$search}%")
                        ->orWhere('judul', 'like', "%{$search}%");
                });
            })->orWhereHas('registration.user', function ($query) use ($search) {
                $query->where('nama_dosen_pembimbing', 'like', "%{$search}%");
            });
        }

        $data = $dataQuery->latest()->paginate(10);


        return view('laporan-akhir.index', [
            'dataRegist' => Registration::whereHas('teamMembers', function ($query) {
                $query->where('identifier', Auth::user()->identifier);  // Cek apakah NIM ada di tabel teammember
            })->get(),
            'dataAdmin' => $data,
            'data' => DocumentFinalReport::where('team_id', $this->teamIdService->getRegistrationId())->get(),
            'document_types' => DocumentTypes::all(),
            'data_album' => Album::with(['album_photos'])->where('team_id', $this->teamIdService->getRegistrationId())->get()
        ]);
    }

    public function detail($id)
    {
        return view('laporan-akhir.admin.detail', [
            'document_types' => DocumentTypes::all(),
            'data' => DocumentFinalReport::with(['teamMembers', 'registration'])
                ->where('team_id', $id)
                ->paginate(10),
            'data_album' => Album::with(['album_photos'])->where('team_id', $id)->get()

        ]);
    }

    public function storeFileKetercapaian(Request $request)
    {
        $documentIds = $request->input('document_id');
        $validateData = $request->validate([
            'document_id' => 'required',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:5480', // max 20MB // max 2MB per photo
            'publish_status' => 'required|string|in:Publish,Draft',
        ]);
        $teamId = $this->teamIdService->getRegistrationId();
        $existing = DocumentFinalReport::where('team_id', $teamId)
            ->where('document_type_id', $documentIds)
            ->first();

        if ($existing && $existing->content) {
            Storage::disk('public')->delete($existing->content);
        }

        $file_name = time() . '_' . $request->file_path->getClientOriginalName();
        $path = $request->file_path->storeAs('laporan-akhir', $file_name, 'public');

        // Hapus file lama jika ada
        $validateData['file_path'] = $path;

        if ($existing) {
            $existing->update(['content' => $validateData['file_path'], 'publish_status' => $validateData['publish_status'], 'status' => 'Belum Valid']);
        } else {
            DocumentFinalReport::create([
                'team_id' => $teamId,
                'document_type_id' => $documentIds,
                'content' => $validateData['file_path'],
                'publish_status' => $validateData['publish_status'],
            ]);
        }

        return redirect()->route('laporan-akhir')->with('success', 'Berhasil menambahkan data');
    }

    public function storeFile(Request $request)
    {
        $documentIds = $request->input('document_id');
        $validateData = $request->validate([
            'document_id' => 'required',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:5480', // max 20MB // max 2MB per photo
        ]);
        $teamId = $this->teamIdService->getRegistrationId();
        $existing = DocumentFinalReport::where('team_id', $teamId)
            ->where('document_type_id', $documentIds)
            ->first();

        if ($existing && $existing->content) {
            Storage::disk('public')->delete($existing->content);
        }

        $file_name = time() . '_' . $request->file_path->getClientOriginalName();
        $path = $request->file_path->storeAs('laporan-akhir', $file_name, 'public');
        $validateData['file_path'] = $path;

        if ($existing) {
            $existing->update(['content' => $validateData['file_path'], 'status' => 'Belum Valid']);
        } else {
            DocumentFinalReport::create([
                'team_id' =>  $this->teamIdService->getRegistrationId(),
                'document_type_id' => $documentIds,
                'content' => $validateData['file_path'],
            ]);
        }

        return redirect()->route('laporan-akhir')->with('success', 'Berhasil menambahkan data');
    }

    public function storeLink(Request $request)
    {
        $documentIds = $request->input('document_id');
        $validateData = $request->validate([
            'document_id' => 'required|integer',
            'link' => 'required|string',
        ]);

        $link = $validateData['link'];
        $documentId = $validateData['document_id'];
        DB::beginTransaction();
        // Cek apakah link adalah YouTube
        if (strpos($link, 'youtube.com') !== false || strpos($link, 'youtu.be') !== false) {
            $videoId = $this->extractYouTubeVideoId($link);

            if (!$videoId) {
                return redirect()->route('laporan-akhir')
                    ->with('error', 'Link video tidak valid!');
            }
            $link = "https://www.youtube.com/embed/" . $videoId;
            // Simpan ke tabel VideoKonten
            VideoKonten::create([
                'created_by' => Auth::user()->name,
                'link_youtube' => $link,
                'visibilitas' => 'off'
            ]);
        }
        $teamId = $this->teamIdService->getRegistrationId();
        $existing = DocumentFinalReport::where('team_id', $teamId)
            ->where('document_type_id', $documentIds)
            ->first();
        // Simpan ke DocumentFinalReport
        if ($existing) {
            $existing->update([
                'content' => $link,
                'status' => 'Belum Valid'
            ]);
        } else {
            DocumentFinalReport::create([
                'team_id' => $this->teamIdService->getRegistrationId(),
                'document_type_id' => $documentIds,
                'content' => $link,
            ]);
        }
        DB::commit();
        return redirect()->route('laporan-akhir')->with('success', 'Berhasil menambahkan data');
    }

    public function storeAlbum(Request $request)
    {
        try {
            DB::beginTransaction();
            $validateData = $request->validate([
                'nama' => 'required|string',
                'album_photos' => 'array|min:3',
                'album_photos.*' => 'image|mimes:jpg,jpeg,png|max:2120',
            ]);
            $teamId = $this->teamIdService->getRegistrationId();
            $existing = Album::where('team_id', $teamId)
                ->first();

            if ($existing) {
                AlbumPhotos::where('album_id', $existing->id)->get()->each(function ($photo) {
                    Storage::disk('public')->delete($photo->path_photos);
                    $photo->delete();
                });
                $existing->update(['nama' => $validateData['nama'], 'status' => "Belum Valid"]);
                if ($request->hasFile('album_photos')) {

                    foreach ($request->file('album_photos') as $photo) {
                        $filename = time() . '_' . $photo->getClientOriginalName();
                        $path = $photo->storeAs('album_photos', $filename, 'public');
                        AlbumPhotos::where('album_id', $existing->id)->update([
                            'path_photos' => $path
                        ]);
                    }
                }
            } else {
                $album = Album::create(['team_id' =>  $teamId, 'nama' => $validateData['nama'], 'status' => "Belum Valid"]);
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
            }
            DB::commit();
            return redirect()->route('laporan-akhir')->with('success', 'Berhasil menambahkan data');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('laporan-akhir')->with('error', 'Gagal menambahkan data!');
        }


        // Commit transaksi jika semua operasi berhasil

    }
    public function detailAlbum($id)
    {
        return view('laporan-akhir.detail', [
            'data' => Album::where('id', $id)->get(),
        ]);
    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $result = DocumentFinalReport::where('id', $id)
                ->update(['status' => 'Valid']);

            DB::commit();
            if ($result) {
                return redirect()->back()->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->back()->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->back()->with("error", "Gagal mengubah data!");
        };
    }
    public function reject(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validateData = $request->validate([
                'komentar' => 'required|string|min:1',
            ]);
            $result = DocumentFinalReport::where('id', $id)
                ->update(['status' => 'Ditolak', 'komentar' => $validateData['komentar']]);

            DB::commit();
            if ($result) {
                return redirect()->back()->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->back()->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->back()->with("error", "Gagal mengubah data!");
        };
    }

    public function approveAlbum($id)
    {
        try {
            DB::beginTransaction();
            $result = Album::where('id', $id)
                ->update(['status' => 'Valid']);

            DB::commit();
            if ($result) {
                return redirect()->back()->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->back()->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->back()->with("error", "Gagal mengubah data!");
        };
    }
    public function rejectAlbum(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $validateData = $request->validate([
                'komentar' => 'required|string|min:1',
            ]);
            $result = Album::where('id', $id)
                ->update(['status' => 'Ditolak', 'komentar' => $validateData['komentar']]);

            DB::commit();
            if ($result) {
                return redirect()->back()->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->back()->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->back()->with("error", "Gagal mengubah data!");
        };
    }
}

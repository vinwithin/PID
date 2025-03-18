<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhotos;
use App\Models\DokumentasiKegiatan;
use App\Models\Registration;
use App\Models\User;
use App\Models\VideoKonten;
use App\Services\teamIdService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DokumenKegiatanController extends Controller
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
        $dataAll = Registration::with(['dokumentasiKegiatan', 'registration_validation'])
            ->whereHas('registration_validation', function ($query) {
                $query->where('status', 'Lanjutkan Program');
            })->paginate(10);

        $query = Registration::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('judul', 'like', "%$search%");
            $dataAll = $query->with(['dokumentasiKegiatan', 'registration_validation'])->whereHas('registration_validation', function ($query) {
                $query->where('status', 'Lanjutkan Program');
            })->paginate(10);
        }
        return view('dokumentasi-kegiatan.create', [
            'dataAdmin' => $dataAll,
            'data' => DokumentasiKegiatan::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId())->get(),
            'dokumenExist' => DokumentasiKegiatan::with('teamMembers')->where('team_id', $this->teamIdService->getRegistrationId())
                ->exists()
        ]);
    }

    public function detail($id)
    {
        return view('dokumentasi-kegiatan.admin.detail', [
            'data' => Album::where('media_dokumentasi_id', $id)->get()
        ]);
    }

    public function store(Request $request)
    {
        // Validasi semua data sekaligus
        $validatedData = $request->validate([
            'link_youtube' => 'required|string',
            'link_social_media' => 'required|string',
            'link_dokumentasi' => 'required|string',
            'nama' => 'required|string',
            'album_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Ekstrak video ID dari link YouTube
        $videoId = $this->extractYouTubeVideoId($validatedData['link_youtube']);
        if (!$videoId) {
            return redirect()->route('dokumentasi-kegiatan')->with('error', 'Link video tidak valid!');
        }

        // Menambahkan team_id dan link_video ke dalam array validatedData
        $validatedData['team_id'] = $this->teamIdService->getRegistrationId();
        $validatedData['status'] = 'pending';
        $validatedData['link_youtube'] = "https://www.youtube.com/embed/" . $videoId;

        // Mulai transaksi database
        DB::beginTransaction();
        // try {
        // Simpan data ke dalam tabel DokumentasiKegiatan
        $DokumentasiKegiatan = DokumentasiKegiatan::create($validatedData);
        VideoKonten::create(['created_by' =>  Auth::user()->name, 'media_dokumentasi_id' => $DokumentasiKegiatan->id, 'link_youtube' => $validatedData['link_youtube'], 'visibilitas' => 'off']);
        // Simpan data ke dalam tabel Album
        $album = Album::create(['team_id' =>  $this->teamIdService->getRegistrationId(), 'media_dokumentasi_id' => $DokumentasiKegiatan->id, 'nama' => $validatedData['nama'], 'status' => "belum valid"]);

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

        return redirect()->route('dokumentasi-kegiatan')->with('success', 'Berhasil menambahkan data');
        // } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        //    
    }
    public function edit($id)
    {
        return view('dokumentasi-kegiatan.edit', [
            'data' => DokumentasiKegiatan::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'link_youtube' => 'required|string',
            'link_social_media' => 'required|string',
            'link_dokumentasi' => 'required|string',
            'nama' => 'required|string',
            'album_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Ekstrak video ID dari link YouTube
        $videoId = $this->extractYouTubeVideoId($validatedData['link_youtube']);
        $validatedData['status'] = 'pending';

        if (!$videoId) {
            return redirect()->route('dokumentasi-kegiatan')->with('error', 'Link video tidak valid!');
        }

        // Menambahkan team_id dan link_video ke dalam array validatedData
        $validatedData['team_id'] = $this->teamIdService->getRegistrationId();
        $validatedData['link_youtube'] = "https://www.youtube.com/embed/" . $videoId;

        // Mulai transaksi database
        DB::beginTransaction();
        // try {
        // Simpan data ke dalam tabel DokumentasiKegiatan
        DokumentasiKegiatan::where('id', $id)->update(['link_youtube' => $validatedData['link_youtube'], 'link_social_media' => $validatedData['link_social_media'], 'link_dokumentasi' => $validatedData['link_dokumentasi']]);
        VideoKonten::where('media_dokumentasi_id', $id)->update(['created_by' =>  Auth::user()->name, 'link_youtube' => $validatedData['link_youtube']]);

        // Simpan data ke dalam tabel Album
        $album = Album::where('media_dokumentasi_id', $id)->update(['nama' => $validatedData['nama']]);

        // Simpan foto-foto album
        if ($request->hasFile('album_photos')) {
            foreach ($request->file('album_photos') as $photo) {
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('album_photos', $filename, 'public');
                AlbumPhotos::where('album_id', $album->id)->update([
                    'path_photos' => $path
                ]);
            }
        }

        // Commit transaksi jika semua operasi berhasil
        DB::commit();

        return redirect()->route('dokumentasi-kegiatan')->with('success', 'Berhasil menambahkan data');
        // } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        //     DB::rollBack();
        //     return redirect()->route('dokumentasi-kegiatan')->with('error', 'Gagal menambahkan data!');
        // }

    }
    public function approve($id)
    {
        try {
            DB::beginTransaction();
            $result = DokumentasiKegiatan::where('id', $id)
                ->update(['status' => 'Valid']);

            DB::commit();
            if ($result) {
                return redirect()->route('dokumentasi-kegiatan')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('dokumentasi-kegiatan')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('dokumentasi-kegiatan')->with("error", "Gagal mengubah data!");
        };
    }
    public function reject($id)
    {
        try {
            DB::beginTransaction();
            $result = DokumentasiKegiatan::where('id', $id)
                ->update(['status' => 'Ditolak']);

            DB::commit();
            if ($result) {
                return redirect()->route('dokumentasi-kegiatan')->with('success', 'berhasil mengubah data');
            } else {
                return redirect()->route('dokumentasi-kegiatan')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('dokumentasi-kegiatan')->with("error", "Gagal mengubah data!");
        };
    }
}

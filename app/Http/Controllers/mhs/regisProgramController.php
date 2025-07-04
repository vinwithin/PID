<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\DokumenRegistrasi;
use App\Models\Fakultas;
use App\Models\Ormawa;
use App\Models\ProgramStudi;
use App\Models\Registration;
use App\Models\TeamMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class regisProgramController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Cek apakah user adalah anggota tim dan statusnya masih pending
        $pendingMember = TeamMember::where('identifier', $user->identifier)
            ->where('status', 'pending')
            ->first();
        // dd($pendingMember->id);
        if ($pendingMember) {
            session()->flash('pending_approval', 'Anda memiliki undangan tim yang belum dikonfirmasi. Silakan terima atau tolak.');
        }
        $currentYear = Carbon::now()->year;
        return view('mahasiswa.register-program', [
            'bidang' => Bidang::all(),
            'fakultas' => Fakultas::all(),
            'program_studi' => ProgramStudi::all(),
            'ormawa' => Ormawa::all(),
            'registrationExists' => TeamMember::where('identifier', Auth::user()->identifier)->whereYear('created_at', $currentYear)->exists(),

            'data' => Registration::with(['registration_validation', 'teamMembers'])
                ->whereYear('created_at', $currentYear)
                ->whereHas('teamMembers', function ($query) {
                    $query->where('identifier', Auth::user()->identifier);  // Cek apakah NIM ada di tabel teammember
                })->get()
        ]);
    }
    public function show($id)
    {
        $user = Auth::user();
        // Cek apakah user adalah anggota tim dan statusnya masih pending
        $pendingMember = TeamMember::where('identifier', $user->identifier)
            ->where('status', 'pending')
            ->first();


        return view('mahasiswa.cekPendaftaran', [
            'data' => Registration::with(['registration_validation', 'document_registration'])->where('id', $id)->first(),
            'pendingMember' => $pendingMember
        ]);
    }
    public function step(Request $request)
    {
        $step = $request->step;
        try {
            switch ($step) {
                case 1:
                    $validatedData = $request->validate([
                        'nama_ketua' => 'required|string|max:255',
                        'nim_ketua' => 'required|string',
                        'prodi_ketua' => 'required|string',
                        'fakultas_ketua' => 'required|string',
                        'nohp_ketua' => 'required|string|regex:/^08[0-9]{9,12}$/',
                        'nama_ormawa' => 'required|string',
                        'judul' => 'required|string',
                        'bidang_id' => 'required',
                        'regency' => 'required',
                        'district' => 'required',
                        'village' => 'required',
                    ], [
                        'nama_ketua.required' => 'Nama ketua harus diisi.',
                        'nim_ketua.required' => 'NIM ketua tidak boleh kosong.',
                        'prodi_ketua.required' => 'Program studi ketua wajib diisi.',
                        'fakultas_ketua.required' => 'Fakultas ketua harus diisi.',
                        'nohp_ketua.required' => 'Nomor HP ketua wajib diisi.',
                        'nohp_dosen_pembimbing.required' => 'Nomor HP dosen pembimbing wajib diisi.',
                        'nohp_dosen_pembimbing.string' => 'Nomor HP harus berupa teks.',
                        'nohp_dosen_pembimbing.regex' => 'Nomor HP harus diawali dengan 08 dan terdiri dari 10-13 angka.',
                        'nama_ormawa.required' => 'Nama ORMAWA harus diisi.',
                        'judul.required' => 'Judul program harus diisi.',
                        'bidang_id.required' => 'Bidang harus dipilih.',
                        'regency.required' => 'Kabupaten/Kota harus dipilih.',
                        'district.required' => 'Kecamatan harus dipilih.',
                        'village.required' => 'Desa harus dipilih.'
                    ]);


                    // Store in session for next stepif
                    // Registration::create($validatedData);
                    $request->session()->put('registration_step1', $validatedData);
                    break;

                case 2:
                    $validatedData = $request->validate([
                        'anggota_tim' => 'required|array|min:10|max:15',
                        'anggota_tim.*.nama' => 'required|string|max:255',
                        'anggota_tim.*.identifier' => 'required|string|max:20',
                        'anggota_tim.*.prodi' => 'required|string|max:255',
                        'anggota_tim.*.fakultas' => 'required|string|max:255',
                        'anggota_tim.*.jabatan' => 'nullable|string|max:20',
                    ], [
                        'anggota_tim.required' => 'Harus ada minimal 10 anggota tim.',
                        'anggota_tim.array' => 'Format anggota tim tidak valid.',
                        'anggota_tim.min' => 'Minimal harus ada 10 anggota tim.',
                        'anggota_tim.max' => 'Anggota tim tidak boleh lebih dari 15 orang.',

                        'anggota_tim.*.nama.required' => 'Nama anggota wajib diisi.',
                        'anggota_tim.*.nama.string' => 'Nama anggota harus berupa teks.',
                        'anggota_tim.*.nama.max' => 'Nama anggota tidak boleh lebih dari 255 karakter.',

                        'anggota_tim.*.identifier.required' => 'NIM anggota wajib diisi.',
                        'anggota_tim.*.identifier.string' => 'NIM harus berupa teks.',
                        'anggota_tim.*.identifier.max' => 'NIM tidak boleh lebih dari 20 karakter.',

                        'anggota_tim.*.prodi.required' => 'Program studi anggota wajib diisi.',
                        'anggota_tim.*.prodi.string' => 'Program studi harus berupa teks.',
                        'anggota_tim.*.prodi.max' => 'Program studi tidak boleh lebih dari 255 karakter.',

                        'anggota_tim.*.fakultas.required' => 'Fakultas anggota wajib diisi.',
                        'anggota_tim.*.fakultas.string' => 'Fakultas harus berupa teks.',
                        'anggota_tim.*.fakultas.max' => 'Fakultas tidak boleh lebih dari 255 karakter.',

                        'anggota_tim.*.jabatan.string' => 'Jabatan harus berupa teks.',
                        'anggota_tim.*.jabatan.max' => 'Jabatan tidak boleh lebih dari 20 karakter.'
                    ]);

                    $request->session()->put('registration_step2', $validatedData);
                    break;
                case 3:
                    $validatedData = $request->validate([
                        'nama_dosen_pembimbing' => 'required|string|max:255',
                        'nohp_dosen_pembimbing' => 'required|string|regex:/^08[0-9]{9,12}$/'
                    ], [
                        'nama_dosen_pembimbing.required' => 'Nama dosen pembimbing wajib diisi.',
                        'nama_dosen_pembimbing.string' => 'Nama dosen pembimbing harus berupa teks.',
                        'nama_dosen_pembimbing.max' => 'Nama dosen pembimbing tidak boleh lebih dari 255 karakter.',

                        'nohp_dosen_pembimbing.required' => 'Nomor HP dosen pembimbing wajib diisi.',
                        'nohp_dosen_pembimbing.string' => 'Nomor HP harus berupa teks.',
                        'nohp_dosen_pembimbing.regex' => 'Nomor HP harus diawali dengan 08 dan terdiri dari 10-13 angka.'
                    ]);



                    $request->session()->put('registration_step3', $validatedData);
                    break;
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi data input dari form
            $validatedData = $request->validate([
                'sk_organisasi' => 'required|file|mimes:pdf|max:2048',
                'surat_kerjasama' => 'required|file|mimes:pdf|max:2048',
                'surat_rekomendasi_pembina' => 'required|file|mimes:pdf|max:2048',
                'proposal' => 'required|file|mimes:pdf|max:5048'
            ], [
                'sk_organisasi.required' => 'Surat Keputusan organisasi harus diunggah.',
                'sk_organisasi.mimes' => 'SK Organisasi harus dalam format PDF.',
                'sk_organisasi.max' => 'Ukuran SK Organisasi tidak boleh lebih dari 2MB.',

                'surat_kerjasama.required' => 'Surat Kerjasama harus diunggah.',
                'surat_kerjasama.mimes' => 'Surat Kerjasama harus dalam format PDF.',
                'surat_kerjasama.max' => 'Ukuran Surat Kerjasama tidak boleh lebih dari 2MB.',

                'surat_rekomendasi_pembina.required' => 'Surat Rekomendasi Pembina harus diunggah.',
                'surat_rekomendasi_pembina.mimes' => 'Surat Rekomendasi Pembina harus dalam format PDF.',
                'surat_rekomendasi_pembina.max' => 'Ukuran Surat Rekomendasi Pembina tidak boleh lebih dari 2MB.',

                'proposal.required' => 'Proposal harus diunggah.',
                'proposal.mimes' => 'Proposal harus dalam format PDF.',
                'proposal.max' => 'Ukuran Proposal tidak boleh lebih dari 2MB.'
            ]);



            // Ambil data dari langkah sebelumnya yang disimpan di session
            $step1Data = $request->session()->get('registration_step1');
            $step2Data = $request->session()->get('registration_step2');
            $step3Data = $request->session()->get('registration_step3');

            // Gabungkan data yang sudah divalidasi dengan data dari session
            // $registrationData = array_merge($step1Data, $step2Data, $validatedData);

            // Tambahkan user_id dan informasi ketua ke dalam array data
            $registrationData = Registration::create([
                'user_id' => Auth::user()->id,
                'nama_ketua' => $step1Data['nama_ketua'],
                'nim_ketua' => $step1Data['nim_ketua'],
                'prodi_ketua' => $step1Data['prodi_ketua'],
                'fakultas_ketua' => $step1Data['fakultas_ketua'],
                'nohp_ketua' => $step1Data['nohp_ketua'],
                'nama_ormawa' => $step1Data['nama_ormawa'],
                'judul' => $step1Data['judul'],
                'bidang_id' => $step1Data['bidang_id'],
                'nama_dosen_pembimbing' => $step3Data["nama_dosen_pembimbing"],
                'nohp_dosen_pembimbing' => $step3Data["nohp_dosen_pembimbing"],
                'status_supervisor' => 'pending'
            ]);
            $createData = [];
            foreach ($validatedData as $key => $file) {
                // $path = $file->store('registration-documents');
                $filename = $key . '_' . time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public', $filename);
                // $path = $request->file('registration-documents')->store('public');
                $createData[$key] = $filename;
            }
            if (!empty($createData)) {
                $registrationData->document_registration()->create($createData);
            }

            // Simpan anggota tim ke tabel terkait
            foreach ($step2Data['anggota_tim'] as $index => $member) {
                // Tambahkan status "approve" untuk anggota pertama
                if ($index === 0) {
                    $member['status'] = 'approve';
                }

                $registrationData->teamMembers()->create($member);
            }

            $registrationData->registration_validation()->create([
                'status' => 'Belum valid', // atau status yang sesuai
                'catatan' => 'Menunggu di validasi',
                'validator_id' => '', // misalnya pengguna yang memvalidasi
            ]);
            $registrationData->lokasi()->create([
                'province' => 15,
                'regency' => $step1Data['regency'],
                'district' => $step1Data['district'],
                'village' => $step1Data['village'],
            ]);
            DB::commit();
            // Hapus data dari session setelah berhasil disimpan
            $request->session()->forget([
                'registration_step1',
                'registration_step2',
                'registration_step3'
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Mendaftar'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }

        // Redirect ke halaman dashboard mahasiswa
        // return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil disimpan.');
    }
    public function search(Request $request)
    {
        $nim = $request->input('nim');

        // Cari user berdasarkan NIM
        $user = User::where('identifier', $nim)->whereHas('roles', function ($query) {
            $query->where('name', 'mahasiswa');
        })->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'status' => 'error',
            ]);
        }

        // Cek apakah NIM sudah terdaftar di tabel registration
        $currentYear = Carbon::now()->year;

        $isRegistered = TeamMember::where('identifier', $nim)
            ->whereYear('created_at', $currentYear)
            ->exists();

        $isTeam = TeamMember::where('identifier', $nim)
            ->whereYear('created_at', $currentYear)
            ->whereIn('registration_id', function ($query) use ($currentYear) {
                $query->select('registration_id')
                    ->from('team_members')
                    ->where('identifier', Auth::user()->identifier)
                    ->whereYear('created_at', $currentYear);
            })->exists();


        if ($isRegistered || $isTeam) {
            return response()->json([
                'message' => 'NIM sudah terdaftar dalam program',
                'status' => 'error',
                'is_registered' => true
            ]);
        }

        // Jika user ditemukan dan belum terdaftar
        return response()->json([
            'name' => $user->name,
            'status' => 'success',
            'is_registered' => false
        ]);
    }

    public function getProdi()
    {
        $prodi = ProgramStudi::all();

        return response()->json($prodi);
    }
    public function getDosen()
    {
        $dosen = User::whereHas('roles', function ($query) {
            $query->where('name', 'dosen');
        })->select('id', 'name')->get();

        return response()->json($dosen);
    }

    public function edit($id)
    {
        return view('mahasiswa.edit-program', [
            'data' => Registration::with(['user', 'document_registration'])->find($id),
            'bidang' => Bidang::all(),
            'fakultas' => Fakultas::all(),
            'program_studi' => ProgramStudi::all(),
            'ormawa' => Ormawa::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Validasi data input dari form
            $validatedData = $request->validate([
                'sk_organisasi' => 'file|mimes:pdf|max:2048',
                'surat_kerjasama' => 'file|mimes:pdf|max:2048',
                'surat_rekomendasi_pembina' => 'file|mimes:pdf|max:2048',
                'proposal' => 'file|mimes:pdf|max:10048'
            ], [
                'sk_organisasi.mimes' => 'SK Organisasi harus dalam format PDF.',
                'sk_organisasi.max' => 'Ukuran SK Organisasi tidak boleh lebih dari 2MB.',

                'surat_kerjasama.mimes' => 'Surat Kerjasama harus dalam format PDF.',
                'surat_kerjasama.max' => 'Ukuran Surat Kerjasama tidak boleh lebih dari 2MB.',

                'surat_rekomendasi_pembina.mimes' => 'Surat Rekomendasi Pembina harus dalam format PDF.',
                'surat_rekomendasi_pembina.max' => 'Ukuran Surat Rekomendasi Pembina tidak boleh lebih dari 2MB.',

                'proposal.mimes' => 'Proposal harus dalam format PDF.',
                'proposal.max' => 'Ukuran Proposal tidak boleh lebih dari 10MB.'
            ]);

            $existingFiles = DokumenRegistrasi::where('registration_id', $id)->first();
            $updateData = [];

            foreach ($validatedData as $key => $value) {

                // Hapus file lama jika ada
                if (!empty($existingFiles->$key)) {
                    Storage::delete('public/' . $existingFiles->$key);
                }

                // Simpan file baru
                $filename = $key . '_' . time() . '_' . $value->getClientOriginalName();
                $value->storeAs('public', $filename);

                // Masukkan ke array update
                $updateData[$key] = $filename;
            }

            // Lakukan update hanya jika ada data yang berubah
            if (!empty($updateData)) {
                DokumenRegistrasi::where('registration_id', $id)->update($updateData);
            }



            // Ambil data dari langkah sebelumnya yang disimpan di session
            $step1Data = $request->session()->get('registration_step1');
            $step2Data = $request->session()->get('registration_step2');
            $step3Data = $request->session()->get('registration_step3');

            // Gabungkan data yang sudah divalidasi dengan data dari session
            // $registrationData = array_merge($step1Data, $step2Data, $validatedData);

            // Tambahkan user_id dan informasi ketua ke dalam array data
            $registrationData = Registration::findOrFail($id);
            $registrationData->update([
                'user_id' => Auth::user()->id,
                'nama_ketua' => $step1Data['nama_ketua'],
                'nim_ketua' => $step1Data['nim_ketua'],
                'prodi_ketua' => $step1Data['prodi_ketua'],
                'fakultas_ketua' => $step1Data['fakultas_ketua'],
                'nohp_ketua' => $step1Data['nohp_ketua'],
                'nama_ormawa' => $step1Data['nama_ormawa'],
                'judul' => $step1Data['judul'],
                'bidang_id' => $step1Data['bidang_id'],
                'nama_dosen_pembimbing' => $step3Data["nama_dosen_pembimbing"],
                'nohp_dosen_pembimbing' => $step3Data["nohp_dosen_pembimbing"],
                'status_supervisor' => 'pending'

            ]);



            // Simpan anggota tim ke tabel terkait
            $registrationData->teamMembers()->where('registration_id', $id)->delete();
            foreach ($step2Data['anggota_tim'] as $index => $member) {
                // Tambahkan status "approve" untuk anggota pertama
                if ($index === 0) {
                    $member['status'] = 'approve';
                }

                $registrationData->teamMembers()->create($member);
            }
            $registrationData->lokasi()->update([
                'province' => 15,
                'regency' => $step1Data['regency'],
                'district' => $step1Data['district'],
                'village' => $step1Data['village'],
            ]);
            DB::commit();
            // Hapus data dari session setelah berhasil disimpan
            $request->session()->forget([
                'registration_step1',
                'registration_step2',
                'registration_step3'
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Mengedit Data'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function approve($id)
    {
        $result = TeamMember::where('id', $id)->update(
            ['status' => 'approve']
        );

        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Anda telah menyetujui keikutsertaan dalam tim.');
        }

        return redirect()->back()->with('error', 'Data anggota tim tidak ditemukan atau sudah diproses.');
    }

    public function reject($id)
    {
        $result = TeamMember::where('id', $id)->update(
            ['status' => 'reject']
        );
        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Anda telah menolak keikutsertaan dalam tim.');
        }

        return redirect()->back()->with('error', 'Data anggota tim tidak ditemukan atau sudah diproses.');
    }
    public function submit($id)
    {
        $result = Registration::where('id', $id)->update(
            ['status' => 'submit']
        );
        if ($result) {
            return redirect()->route('dashboard')->with('success', 'Proposal anda telah dikirim untuk diproses di tahap selanjutnya.');
        }

        return redirect()->back()->with('error', 'Gagal mengirim proposal, coba lagi.');
    }
}

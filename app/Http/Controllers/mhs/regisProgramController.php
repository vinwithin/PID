<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Fakultas;
use App\Models\Ormawa;
use App\Models\ProgramStudi;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class regisProgramController extends Controller
{
    public function index()
    {
        return view('mahasiswa.register-program', [
            'bidang' => Bidang::all(),
            'fakultas' => Fakultas::all(),
            'program_studi' => ProgramStudi::all(),
            'ormawa' => Ormawa::all(),
            'registrationExists' => Registration::where('user_id', auth()->user()->id)->exists(),
            'data' => Registration::with('registration_validation')->where('user_id', auth()->user()->id)->get(),
        ]);
    }
    public function show($id){
        return view('mahasiswa.cekPendaftaran',[
            'data' => Registration::with('registration_validation')->where('id', $id)->first()
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
                        'nohp_ketua' => 'required|string',
                        'nama_ormawa' => 'required|string',
                        'judul' => 'required|string',
                        'bidang_id' => 'required',
                        'province' => 'required',
                        'regency' => 'required',
                        'district' => 'required',
                        'village' => 'required',
                    ]);

                    // Store in session for next stepif
                    // Registration::create($validatedData);
                    $request->session()->put('registration_step1', $validatedData);

                    // if ($result) {
                    //     return 'berhasil';
                    // } else {
                    //     return response()->json([
                    //         'success' => false,
                    //         'message' => 'kontol: '
                    //     ], 500);
                    // }
                    break;

                case 2:
                    $validatedData = $request->validate([
                        'sk_organisasi' => 'required|file|mimes:pdf|max:2048',
                        'surat_kerjasama' => 'required|file|mimes:pdf|max:2048',
                        'surat_rekomendasi_pembina' => 'required|file|mimes:pdf|max:2048',
                        'proposal' => 'required|file|mimes:pdf|max:2048'
                    ]);
                    $filePaths = [];
                    foreach ($validatedData as $key => $file) {
                        // $path = $file->store('registration-documents');
                        $filename = $key . '_' . time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('public', $filename);
                        // $path = $request->file('registration-documents')->store('public');
                        $filePaths[$key] = $filename;
                    }
                    $request->session()->put('registration_step2', $filePaths);
                    break;




                case 3:
                    $validatedData = $request->validate([
                        'anggota_tim' => 'required|array|min:1|max:13',
                        'anggota_tim.*.nama' => 'required|string|max:255',
                        'anggota_tim.*.nim' => 'required|string|max:20',
                        'anggota_tim.*.prodi' => 'required|string|max:255',
                        'anggota_tim.*.fakultas' => 'required|string|max:255',
                        'anggota_tim.*.jabatan' => 'nullable|string|max:20',
                    ]);
                    $request->session()->put('registration_step3', $validatedData);
                    break;
            }
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Step ' . $step . ' saved successfully'
            // ]);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $request->session()->put('registration_step4', $request->all());
        try {
            // Validasi data input dari form
            $validatedData = $request->validate([
                'nama_dosen_pembimbing' => 'required|string',
                'nidn_dosen_pembimbing' => 'required|string',
                'nohp_dosen_pembimbing' => 'required|string'
            ]);

            // Ambil data dari langkah sebelumnya yang disimpan di session
            $step1Data = $request->session()->get('registration_step1');
            $step2Data = $request->session()->get('registration_step2');
            $step3Data = $request->session()->get('registration_step3');

            // Gabungkan data yang sudah divalidasi dengan data dari session
            // $registrationData = array_merge($step1Data, $step2Data, $validatedData);

            // Tambahkan user_id dan informasi ketua ke dalam array data
            $registrationData = Registration::create([
                'user_id' => auth()->user()->id,
                'nama_ketua' => $step1Data['nama_ketua'],
                'nim_ketua' => $step1Data['nim_ketua'],
                'prodi_ketua' => $step1Data['prodi_ketua'],
                'fakultas_ketua' => $step1Data['fakultas_ketua'],
                'nohp_ketua' => $step1Data['nohp_ketua'],
                'nama_ormawa' => $step1Data['nama_ormawa'],
                'judul' => $step1Data['judul'],
                'bidang_id' => $step1Data['bidang_id'],
                'sk_organisasi' => $step2Data['sk_organisasi'],
                'surat_kerjasama' => $step2Data['surat_kerjasama'],
                'surat_rekomendasi_pembina' => $step2Data['surat_rekomendasi_pembina'],
                'proposal' => $step2Data['proposal'],
                'nama_dosen_pembimbing' => $validatedData["nama_dosen_pembimbing"],
                'nidn_dosen_pembimbing' => $validatedData["nidn_dosen_pembimbing"],
                'nohp_dosen_pembimbing' => $validatedData["nohp_dosen_pembimbing"]
            ]);

            // Buat entri baru di tabel registrations
            // $registration = Registration::create($registrationData);

            // Simpan anggota tim ke tabel terkait
            foreach ($step3Data['anggota_tim'] as $member) {
                $registrationData->teamMembers()->create($member);
            }
            $registrationData->registration_validation()->create([
                'status' => 'Belum valid', // atau status yang sesuai
                'catatan' => 'Menunggu di validasi',
                'validator_id' => '', // misalnya pengguna yang memvalidasi
            ]);
            $registrationData->lokasi()->create([
                'province' => $step1Data['province'], 
                'regency' => $step1Data['regency'],
                'district' => $step1Data['district'], 
                'village' => $step1Data['village'], 
            ]);

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
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }

        // Redirect ke halaman dashboard mahasiswa
        // return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil disimpan.');
    }
}

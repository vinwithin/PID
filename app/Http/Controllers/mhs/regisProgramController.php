<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class regisProgramController extends Controller
{
    public function index()
    {
        return view('mahasiswa.register-program', [
            'bidang' => Bidang::all()
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
                    ]);

                    // Store in session for next step
                    $request->session()->put('registration_step1', $validatedData);
                    break;

                case 2:
                    $validatedData = $request->validate([
                        'sk_organisasi' => 'required|file|mimes:pdf|max:2048',
                        'surat_kerjasama' => 'required|file|mimes:pdf|max:2048',
                        'surat_rekomendasi_pembina' => 'required|file|mimes:pdf|max:2048',
                        'proposal' => 'required|file|mimes:pdf|max:5048'
                    ]);

                    // Store files and save paths in session
                    $filePaths = [];
                    foreach ($validatedData as $key => $file) {
                        $path = $file->store('registration-documents');
                        $filePaths[$key] = $path;
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
            $step1Data = $request->session()->get('registration_step1');
            dd($step1Data['nama_ketua']);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_dosen_pembimbing' => 'required|string',
            'nidn_dosen_pembimbing' => 'required|string',
            'nohp_dosen_pembimbing' => 'required|string'
        ]);

        // Get data from previous steps
        $step1Data = $request->session()->get('registration_step1');
        $step2Data = $request->session()->get('registration_step2');
        $step3Data = $request->session()->get('registration_step3');

        // // Create registration
        $registration = Registration::create([
            'user_id' => auth()->user()->id,
            'nama_ketua' => $step1Data['nama_ketua'],
            'nim_ketua' => $step1Data['nim_ketua'],
            'prodi_ketua' => $step1Data['prodi_ketua'],
            'fakultas_ketua' => $step1Data['fakultas_ketua'],
            'nohp_ketua' => $step1Data['nohp_ketua'],
            'nama_ormawa' => $step1Data['nama_ormawa'],
            'judul' => $step1Data['judul'],
            'bidang_id' => $step1Data['bidang_id'],
        ]);

        // // Save team members
        foreach ($step3Data['team_members'] as $member) {
            $registration->teamMembers()->create($member);
        }

        // Save all documents
        $allDocuments = array_merge(
            $step2Data,
            array_map(function($file) {
                return $file->store('registration-documents');
            }, $validatedData)
        );

        // foreach ($allDocuments as $type => $path) {
        //     RegistrationDocument::create([
        //         'registration_id' => $registration->id,
        //         'document_type' => $type,
        //         'file_path' => $path
        //     ]);
        // }

        // // Clear session data
        // $request->session()->forget([
        //     'registration_step1',
        //     'registration_step2'
        // ]);

        // DB::commit();
        // return redirect()->route('registration.success');
    }
}

<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\DokumenTeknis;

class DokumenTeknisService
{
    protected $teamIdService;

    public function __construct(teamIdService $teamIdService)
    {
        $this->teamIdService = $teamIdService;
    }
    public function storeDokumenTeknis(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'file_manual' => 'required|file',
            'status_manual' => 'required|string',
            'file_proposal' => 'required|file',
            'file_laporan_keuangan' => 'required|file',
        ]);
        $validatedData['team_id'] = $this->teamIdService->getRegistrationId();
        $validatedData['status'] = 'Belum Valid';
        // Process file uploads
        $validatedData['file_manual'] = $this->storeFile($request->file('file_manual'), 'file_manual');
        $validatedData['file_proposal'] = $this->storeFile($request->file('file_proposal'), 'file_proposal');
        $validatedData['file_laporan_keuangan'] = $this->storeFile($request->file('file_laporan_keuangan'), 'file_laporan_keuangan');

        // Save to the database
        return DokumenTeknis::create($validatedData);
    }

    public function updateDokumenTeknis(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'file_manual' => 'required|file|mimes:pdf,doc,docx|max:2120', // max 5MB
            'status_manual' => 'required|string',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:2120', // max 5MB
            'file_laporan_keuangan' => 'required|file|mimes:pdf,doc,docx|max:2120', // max 5MB

        ]);
        $validatedData['team_id'] = $this->teamIdService->getRegistrationId();
        $validatedData['status'] = 'Belum Valid';
        $validatedData['komentar'] = '';


        // Process file uploads
        $validatedData['file_manual'] = $this->storeFile($request->file('file_manual'), 'file_manual');
        $validatedData['file_proposal'] = $this->storeFile($request->file('file_proposal'), 'file_proposal');
        $validatedData['file_laporan_keuangan'] = $this->storeFile($request->file('file_laporan_keuangan'), 'file_laporan_keuangan');

        // Save to the database
        return DokumenTeknis::where('id', $id)->update($validatedData);
    }

    private function storeFile($file, $prefix)
    {
        $fileName = $prefix . '_' . time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/dokumen-teknis/', $fileName);

        return $fileName;
    }
}

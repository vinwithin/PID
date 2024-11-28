<?php

namespace App\Services;

use App\Models\DokumenPublikasi;
use Illuminate\Http\Request;
use App\Models\DokumenTeknis;

class DokumenPublikasiService
{
    protected $teamIdService;

    public function __construct(teamIdService $teamIdService)
    {
        $this->teamIdService = $teamIdService;
    }
    public function storeDokumenPublikasi(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'file_artikel' => 'required|file',
            'status_artikel' => 'required|string',
            'link_artikel' => 'required|string',
            'file_haki' => 'required|file',
            'status_haki' => 'required|string',
        ]);
        $validatedData['team_id'] = $this->teamIdService->getRegistrationId();
        // Process file uploads
        $validatedData['file_artikel'] = $this->storeFile($request->file('file_artikel'), 'file_artikel');
        $validatedData['file_haki'] = $this->storeFile($request->file('file_haki'), 'file_haki');

        // Save to the database
        return DokumenPublikasi::create($validatedData);
    }

    public function updateDokumenPublikasi(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'file_artikel' => 'required|file',
            'status_artikel' => 'required|string',
            'link_artikel' => 'required|string',
            'file_haki' => 'required|file',
            'status_haki' => 'required|string',
        ]);
        $validatedData['team_id'] = $this->teamIdService->getRegistrationId();
        // Process file uploads
        $validatedData['file_artikel'] = $this->storeFile($request->file('file_artikel'), 'file_artikel');
        $validatedData['file_haki'] = $this->storeFile($request->file('file_haki'), 'file_haki');

        // Save to the database
        return DokumenPublikasi::where('id', $id)->update($validatedData);
    }

    private function storeFile($file, $prefix)
    {
        $fileName = $prefix . '_' . time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/dokumen-publikasi/', $fileName);

        return $fileName;
    }
}

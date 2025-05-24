<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class deadlineController extends Controller
{
    public function index()
    {
        return view('deadline.index', [
            'data' => Deadline::paginate(10)
        ]);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_dokumen' => 'required|string',
            'dibuka' => 'required|date',
            'ditutup' => 'required|date|after_or_equal:dibuka',
        ]);

        Deadline::create($validateData);
        return redirect()->route('deadline')->with('success', 'Deadline berhasil dibuat.');
    }
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'nama_dokumen' => 'required|string',
            'dibuka' => 'required|date',
            'ditutup' => 'required|date|after_or_equal:dibuka',
        ]);

        Deadline::where('id', $id)->update($validateData);
        return redirect()->route('deadline')->with('success', 'Deadline berhasil diubah.');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Deadline::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('deadline')->with('success', 'Data Berhasil Dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

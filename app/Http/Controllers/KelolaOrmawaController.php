<?php

namespace App\Http\Controllers;

use App\Models\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaOrmawaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data_ormawa = Ormawa::query(); // gunakan query builder, bukan all()

        if ($search) {
            $data_ormawa->where('nama', 'like', "%{$search}%");
        }

        $data = $data_ormawa->paginate(10);

        return view('kelola-ormawa.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelola-ormawa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string'
        ]);
        $result = Ormawa::create($validateData);
        if ($result) {
            return redirect()->back()->with('success', 'Berhasil menambah data');
        } else {
            return redirect()->back()->with("error", "Gagal menambah data!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validateData = $request->validate([
            'nama' => 'required|string|min:3'
        ]);
        $result = Ormawa::where('id', $id)->update($validateData);
        if ($result) {
            return redirect()->back()->with('success', 'Berhasil menambah data');
        } else {
            return redirect()->back()->with("error", "Gagal menambah data!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
    public function destroyFromLink($id)
    {
        DB::beginTransaction();
        try {
            Ormawa::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('kelola-ormawa.index')->with('success', 'Data Berhasil Dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

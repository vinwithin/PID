<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class annouceController extends Controller
{
    public function index()
    {
        return view('announce.index', [
            'data' => Announcement::with('user')->get()
        ]);
    }
    public function create()
    {
        return view('announce.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validateData = $request->validate([
                'category'       => 'required|string|max:255',
                'title'     => 'required|string|min:10',
                'start_date'  => 'required|date',
                'end_date'    => 'nullable|date|after_or_equal:start_date',
            ]);
            $validateData['created_by'] = Auth::user()->id;
            $result = Announcement::create($validateData);
            DB::commit();
            if ($result) {
                return redirect()->route('announcement')->with('success', 'Berhasil mengubah data');
            } else {
                return redirect()->route('announcement')->with("error", "Gagal mengubah data!");
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan

            return redirect()->route('announcement')->with("error", "Terjadi kesalahan, silakan coba lagi!");
        }
    }
    public function edit($id)
    {
        return view('announce.edit', [
            'data' => Announcement::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        // 
        $validateData = $request->validate([
            'title'     => 'required|string|min:10',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);
        $validateData['created_by'] = Auth::user()->id;
        $result = Announcement::where('id', $id)->update($validateData);
        if ($result) {
            return redirect()->route('announcement')->with('success', 'Berhasil mengubah data');
        } else {
            return redirect()->route('announcement')->with("error", "Gagal mengubah data!");
        }
    }
    public function destroy($id)
    {
        Announcement::where('id', $id)->delete();
        return redirect()->route('announcement')->with('success', 'Artikel Berhasil Dihapus!');
    }
    
}

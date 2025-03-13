<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class masterDataController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('roles', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }
        $data = $query->get();
        return view('master-data.index', [
            'data' => $data,
        ]);
    }

    public function edit($id)
    {
        return view('master-data.edit', [
            'data' => User::find($id),
            'dataRole' => Role::all(),
        ]);
    }
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'role' => 'required'
        ]);
        $user = User::findOrFail($id);

        // Ganti role user dengan yang baru
        $result = $user->syncRoles($validateData['role']);
        if ($result) {
            return redirect()->route('manage-users')->with('success', 'Role berhasil diubah');
        } else {
            return redirect()->route('manage-users')->with('error', 'Role gagal diubah');
        }
    }
    public function create()
    {
        return view('master-data.create', [
            'data' => Role::all()
        ]);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string'],
            'role' => ['required', 'string']
        ]);
        $validateData['password'] = Hash::make($validateData['password']);
        $user = User::create($validateData);
        $user->assignRole($validateData['role']);
        if ($user) {
            return redirect()->route('manage-users')->with('success', 'Registered successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to Registered');
        }
    }
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('manage-users')->with('success', 'Pengguna Berhasil Dihapus!');
    }
}

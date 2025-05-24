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
        $data = $query->paginate(10);
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
            'name' => ['required', 'string', 'max:255'],
            'identifier' => ['required', 'string', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $id],
            'password' => ['nullable', 'string'],
            'role' => ['required', 'string']
        ]);
        $role = $validateData['role'];
        $user = User::findOrFail($id);
        unset($validateData['role']);
        if (empty($validateData['password'])) {
            unset($validateData['password']);
        } else {
            // Hash password jika diisi
            $validateData['password'] = Hash::make($validateData['password']);
        }
        // Ganti role user dengan yang baru
        $user->syncRoles($role);
        $result = $user->update($validateData);
        if ($result) {
            return redirect()->route('manage-users')->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->route('manage-users')->with('error', 'Data gagal diubah');
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
            'identifier' => ['required', 'string', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string'],
            'role' => ['required', 'string']
        ]);
        $validateData['password'] = Hash::make($validateData['password']);
        $user = User::create($validateData);
        $user->assignRole($validateData['role']);
        if ($user) {
            return redirect()->route('manage-users')->with('success', 'Data berhasil ditambah');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambah data');
        }
    }
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('manage-users')->with('success', 'Pengguna Berhasil Dihapus!');
    }
}

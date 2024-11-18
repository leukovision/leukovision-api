<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|string',
        ]);
    
        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'email' => $validated['email'],
            'full_name' => $validated['full_name'],
        ]);
    
        return response()->json($user, 201);
    }

    public function index()
    {
        $users = User::all(['user_id as id_users', 'username', 'email', 'full_name']);
        return response()->json(['status' => 'success', 'data' => ['users' => $users]], 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'Pengguna tidak ditemukan'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'Pengguna tidak ditemukan'], 404);
        }
    
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|string',
        ]);
        
    
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
    
        $user->update($validated);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Pengguna berhasil diperbarui',
            'data' => $user
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'Pengguna gagal dihapus. Id tidak ditemukan'], 404);
        }

        $user->delete();
        return response()->json(['status' => 'success', 'message' => 'Pengguna berhasil dihapus'], 200);
    }
}

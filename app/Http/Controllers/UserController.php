<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'username' => 'required|string|unique:users,username',
                'password' => 'required|string|min:8',
                'email' => 'required|email|unique:users,email',
                'full_name' => 'required|string',
            ]);

            // Membuat pengguna baru
            $user = User::create([
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'email' => $validated['email'],
                'full_name' => $validated['full_name'],
            ]);

            // Mengembalikan respons sukses
            return response()->json([
                'status' => 'success',
                'message' => 'User berhasil dibuat',
                'data' => $user
            ], 201);
        } catch (ValidationException $e) {
            // Menangani error validasi
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Menangani error umum lainnya
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $users = User::all(['user_id as id_users', 'username', 'email', 'full_name']);

            if ($users->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Data belum ada'], 404);
            }

            return response()->json(['status' => 'success', 'data' => ['users' => $users]], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            // Mencari pengguna berdasarkan ID
            $user = User::find($id);

            // Jika pengguna tidak ditemukan
            if (!$user) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Pengguna tidak ditemukan',
                ], 404);
            }

            // Jika pengguna ditemukan, kembalikan data
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            // Menangani error umum
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data pengguna',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Mencari pengguna berdasarkan ID
            $user = User::find($id);

            // Jika pengguna tidak ditemukan
            if (!$user) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Pengguna tidak ditemukan',
                ], 404);
            }

            // Validasi input
            $validated = $request->validate([
                'username' => 'sometimes|required|string|unique:users,username,' . $user->user_id . ',user_id',
                'password' => 'sometimes|required|string|min:8',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->user_id . ',user_id',
                'full_name' => 'sometimes|required|string',
            ]);

            // Hash password jika ada
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            // Memperbarui data pengguna
            $user->update($validated);

            // Mengembalikan respons sukses
            return response()->json([
                'status' => 'success',
                'message' => 'Pengguna berhasil diperbarui',
                'data' => $user,
            ], 200);
        } catch (ValidationException $e) {
            // Menangani error validasi
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Menangani error umum lainnya
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui pengguna',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Mencari pengguna berdasarkan ID
            $user = User::find($id);

            // Jika pengguna tidak ditemukan
            if (!$user) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Pengguna gagal dihapus. Id tidak ditemukan',
                ], 404);
            }

            // Menghapus pengguna
            $user->delete();

            // Mengembalikan respons sukses
            return response()->json([
                'status' => 'success',
                'message' => 'Pengguna berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            // Menangani error umum lainnya
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus pengguna',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

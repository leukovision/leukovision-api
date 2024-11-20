<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string',
                'age' => 'required|integer',
                'gender' => 'required|string',
                'address' => 'required|string',
            ]);

            // Membuat data pasien baru
            $patient = Patient::create($validated);

            // Mengembalikan respons sukses
            return response()->json([
                'status' => 'success',
                'message' => 'Pasien berhasil dibuat',
                'data' => $patient,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
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
                'message' => 'Terjadi kesalahan saat membuat pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $patients = Patient::all(['patient_id as id_patient', 'name', 'age', 'gender', 'address']);

            if ($patients->isEmpty()) {
                return response()->json(['status' => 'fail', 'message' => 'Data pasien belum ada'], 404);
            }

            return response()->json(['status' => 'success', 'data' => ['patients' => $patients]], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $patient = Patient::find($id);

            if (!$patient) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Pasien tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $patient,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $patient = Patient::find($id);

            if (!$patient) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Pasien tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string',
                'age' => 'required|integer',
                'gender' => 'required|string',
                'address' => 'required|string',
            ]);

            $patient->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Pasien berhasil diperbarui',
                'data' => $patient,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::find($id);

            if (!$patient) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Pasien gagal dihapus. Id tidak ditemukan',
                ], 404);
            }

            $patient->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Pasien berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus pasien',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

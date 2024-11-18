<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'address' => 'required|string',
        ]);

        $patient = Patient::create($validated);

        return response()->json($patient, 201);
    }

    public function index()
    {
        $patients = Patient::all(['patient_id as id_patient', 'name', 'age']);
        return response()->json(['status' => 'success', 'data' => ['patients' => $patients]], 200);
    }

    public function show($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['status' => 'fail', 'message' => 'Pasien tidak ditemukan'], 404);
        }

        return response()->json($patient, 200);
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'age' => 'required|integer',
        'address' => 'required|string',
    ]);

    $patient = Patient::find($id);

    if (!$patient) {
        return response()->json(['status' => 'fail', 'message' => 'Pasien tidak ditemukan'], 404);
    }

    $patient->update($validated);

    return response()->json(['status' => 'success', 'data' => $patient], 200);
}


    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['status' => 'fail', 'message' => 'Pasien gagal dihapus. Id tidak ditemukan'], 404);
        }

        $patient->delete();
        return response()->json(['status' => 'success', 'message' => 'Pasien berhasil dihapus'], 200);
    }
}

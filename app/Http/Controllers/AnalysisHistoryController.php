<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisHistory;

class AnalysisHistoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|integer|exists:patients,patient_id',
            'diagnosis' => 'required|string',
            'tingkat_keyakinan' => 'required|string',
            'jumlah_sel' => 'required|integer',
            'sel_abnormal' => 'required|integer',
            'rata_rata_keyakinan' => 'required|string',
            'rekomendasi_medis' => 'required|string',
            'timestamp' => 'required|date',
        ]);

        $history = AnalysisHistory::create($validated);

        return response()->json($history, 201);
    }

    public function index()
    {
        $histories = AnalysisHistory::all();
        return response()->json(['status' => 'success', 'data' => ['analysis_history' => $histories]], 200);
    }

    public function show($id)
    {
        $history = AnalysisHistory::find($id);
        if (!$history) {
            return response()->json(['status' => 'fail', 'message' => 'Riwayat analisis tidak ditemukan'], 404);
        }

        return response()->json($history, 200);
    }

    public function destroy($id)
    {
        $history = AnalysisHistory::find($id);
        if (!$history) {
            return response()->json(['status' => 'fail', 'message' => 'Riwayat analisis gagal dihapus. Id tidak ditemukan'], 404);
        }

        $history->delete();
        return response()->json(['status' => 'success', 'message' => 'Riwayat analisis berhasil dihapus'], 200);
    }
}

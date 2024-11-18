<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AnalysisHistoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Route::prefix('users')->group(function () {
//     Route::post('/', [UserController::class, 'store']);
//     Route::get('/', [UserController::class, 'index']);
//     Route::get('/{id}', [UserController::class, 'show']);
//     Route::put('/{id}', [UserController::class, 'update']);
//     Route::delete('/{id}', [UserController::class, 'destroy']);
// });

// Route::prefix('patients')->group(function () {
//     Route::post('/', [PatientController::class, 'store']);
//     Route::get('/', [PatientController::class, 'index']);
//     Route::get('/{id}', [PatientController::class, 'show']);
//     Route::put('/{id}', [PatientController::class, 'update']);
//     Route::delete('/{id}', [PatientController::class, 'destroy']);
// });

Route::resource('patients', PatientController::class);
Route::resource('users', UserController::class);

Route::post('/analysis_history', [AnalysisHistoryController::class, 'store']);
Route::get('/analysis_history', [AnalysisHistoryController::class, 'index']);
Route::get('/analysis_history/{id}', [AnalysisHistoryController::class, 'show']);
Route::delete('/analysis_history/{id}', [AnalysisHistoryController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

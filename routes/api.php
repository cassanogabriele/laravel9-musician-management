<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MusiciansController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('musicians', [MusiciansController::class, 'index']);
Route::post('musicians', [MusiciansController::class, 'store']);
Route::get('musicians/{id}', [MusiciansController::class, 'show']);
Route::get('musicians/{id}/edit', [MusiciansController::class, 'edit']);
Route::put('musicians/{id}/edit', [MusiciansController::class, 'update']);
Route::delete('musicians/{id}/delete', [MusiciansController::class, 'destroy']);
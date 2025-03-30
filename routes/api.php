<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MusiciansController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Récupérer les musiciens par style
Route::get('musicians', [MusiciansController::class, 'index']);
// Récupérer les styles de musiciens
Route::get('styles', [MusiciansController::class, 'styles']);
// Récupérer les musiciens récemment ajoutés 
Route::get('/musicians/recent', [MusiciansController::class, 'recent']);
// Création d'un musicien
Route::post('musicians', [MusiciansController::class, 'store']);
Route::get('musicians/{id}', [MusiciansController::class, 'show']);
Route::get('musicians/{id}/edit', [MusiciansController::class, 'edit']);
Route::put('musicians/{id}/edit', [MusiciansController::class, 'update']);
Route::delete('musicians/{id}/delete', [MusiciansController::class, 'destroy']);
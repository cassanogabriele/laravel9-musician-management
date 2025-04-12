<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MusiciansController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WishlistController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/announcements', [MusiciansController::class, 'store']); 
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
// Récupérer les annonces de l'utlisateur 
Route::get('/announces', [MusiciansController::class, 'userAnnounces']);

// Listes de souhaits

// Créer une liste de souhait
Route::post('/wishlist', [WishlistController::class, 'store']);
// Récupérer les listes de souhaits de l'utilisateur 
Route::get('/wishlists/{userId}', [WishlistController::class, 'getUserWishlists']);
// Ajouter un musicien à une liste de souhaits
Route::post('/wishlist/add-musician', [WishlistController::class, 'addMusicianToWishlist']);
// Supprimer un musicien d'une liste de souhaits
Route::delete('/wishlist/{wishlistId}/musician/{musicianId}', [WishlistController::class, 'removeMusician']);
Route::get('/wishlists', [WishlistController::class, 'index']);
Route::get('/wishlist/{id}', [WishlistController::class, 'show']);



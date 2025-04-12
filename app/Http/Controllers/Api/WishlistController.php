<?php

namespace App\Http\Controllers\Api; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Musician;
use App\Models\Wishlist;
use App\Models\MusicianWishlist;
use Illuminate\Support\Facades\Validator;

// WishlistController.php
class WishlistController extends Controller
{
    // Créer une nouvelle wishlist
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'musician_id' => 'required|exists:musicians,id',
        ]);
    
        try {    
            // Création de la wishlist
            $wishlist = Wishlist::create([
                'name' => $validated['name'],
                'user_id' => $validated['user_id'],
            ]);
    
            // Ajout du musicien à la wishlist avec Eloquent
            MusicianWishlist::create([
                'musician_id' => $validated['musician_id'],
                'wishlist_id' => $wishlist->id,
            ]);
        
            return response()->json([
                'message' => 'Wishlist créée et musicien ajouté !',
                'wishlist' => $wishlist
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de la wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Récupérer les wishlists de l'utilisateur connecté   
    public function getUserWishlists(Request $request, $userId)
    {
        // On récupère les wishlists en fonction de l'ID de l'utilisateur
        $wishlists = Wishlist::with('musicians')
            ->where('user_id', $userId)
            ->get();
    
        // Retourner les wishlists de l'utilisateur sous forme de réponse JSON
        return response()->json($wishlists);
    }
    
    // Ajouter un musicien à une wishlist existante
    public function addMusicianToWishlist(Request $request)
    {
        $wishlist = Wishlist::findOrFail($request->wishlist_id);
        $musician = Musician::findOrFail($request->musician_id);

        $wishlist->musicians()->attach($musician);

        return response()->json($wishlist);
    }

    // Afficher toutes les wishlists d'un utilisateur
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())->get();
        return response()->json($wishlists);
    }

    public function removeMusician($wishlistId, $musicianId)
    {
        // Vérifie si la wishlist existe
        $wishlist = Wishlist::find($wishlistId);
        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist non trouvée'], 404);
        }

        // Vérifie si le musicien existe
        $musician = Musician::find($musicianId);
        if (!$musician) {
            return response()->json(['message' => 'Musicien non trouvé'], 404);
        }

        // Supprime le musicien de la wishlist
        $wishlist->musicians()->detach($musicianId);

        // Répond avec un succès et le nom du musicien supprimé
        return response()->json([            
            'musicianName' => $musician->name
        ], 200);
    }
}

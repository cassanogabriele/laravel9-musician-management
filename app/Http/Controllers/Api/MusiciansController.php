<?php

namespace App\Http\Controllers\Api; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Musician;
use Illuminate\Support\Facades\Validator;

class MusiciansController extends Controller
{
    // Récupérer les musiciens par style
    public function index(Request $request)
    {    
        // Filtrer par style si un paramètre est envoyé
        if ($request->has('style')) {
            $musicians = Musician::where('style', $request->style)->get();
        } else {
            $musicians = Musician::all();
        }
    
        return response()->json([
            'status' => 200,
            'musicians' => $musicians
        ], 200);
    }

    // Récupérer tous les styles distincts (pour le menu déroulant )
    public function styles(Request $request)
    {
        $styles = Musician::select('style')->distinct()->pluck('style');

        return response()->json([
            'status' => 200,
            'styles' => $styles,
        ], 200);

    }

    // Récupéré les musiciens récemment ajoutés
    public function recent()
    {
        $musicians = Musician::orderBy('created_at', 'desc')->take(6)->get();

        return response()->json([
            'status' => 200,
            'musicians' => $musicians
        ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'style' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $musician = Musician::create([
                'name' => $request->name,
                'style' => $request->style,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
    
            return response()->json([
                'status' => 200,
                'message' => 'Musicien ajouté avec succès',
                'data' => $musician
            ], 200);
        }
    }    

    public function show($id)
    {
        $musician = Musician::find($id);

        if($musician)
        {
            return response()->json([
                'status' => 200,
                'message' => "Le musicien a été trouvé avec succès"
            ], 422);
        } else{
            return response()->json([
                'status' => 500,
                'messsage' => "Quelque chose n'est pas bon !"
            ], 500);
        }
    }

    public function edit($id)
    {
        $musician = Musician::find($id);

        if ($musician) {
            return response()->json([
                'status' => 200,
                'musician' => $musician,
                'message' => "Le musicien a été trouvé avec succès"
            ], 200); 
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Musicien non trouvé"
            ], 404); 
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'style' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10', // Correction ici
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $musician = Musician::find($id);               
            
            if ($musician) {
                // Mise à jour des données
                $musician->update([
                    'name' => $request->name,
                    'style' => $request->style,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);  
                
                return response()->json([
                    'status' => 200,
                    'message' => "Le musicien a été mis à jour avec succès"
                ], 200); // Correction du statut
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Pas de musicien trouvé !"
                ], 404); // Correction du statut
            }
        }
    }

    public function destroy($id)
    {
        $musician = Musician::find($id);   

        if ($musician) {
            $musician->delete();  

            // Renvoie un message de succès après la suppression
            return response()->json([
                'status' => 200,
                'message' => "Le musicien a été supprimé avec succès"
            ], 200); // Code HTTP 200 pour une suppression réussie
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Pas de musicien trouvé !"
            ], 404); // Code HTTP 404 si le musicien n'est pas trouvé
        }
    }

}

<?php
namespace App\Http\Controllers;

use App\Models\Biere;
use Illuminate\Http\Request;

class BiereController extends Controller
{
    public function index()
    {
        $bieres = Biere::all();
        return response()->json($bieres, 200);
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
        ]);

        $biere = Biere::create($validated);

        return response()->json([
            'message' => 'Bière ajoutée avec succès',
            'biere' => $biere
        ], 201);
    }

    public function update(Request $request, Biere $biere)
    {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prix' => 'sometimes|required|numeric',
        ]);

        $biere->update($validated);

        return response()->json([
            'message' => 'Bière mise à jour avec succès',
            'biere' => $biere
        ], 200);
    }

    public function destroy(Biere $biere)
    {
        $biere->delete();

        return response()->json([
            'message' => 'Bière supprimée avec succès'
        ], 204);
    }
}

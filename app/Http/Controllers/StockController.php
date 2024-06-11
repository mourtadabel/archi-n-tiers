<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stock = Stock::all();
        return response()->json($stock, 200);
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'biere_id' => 'required|exists:bieres,id',
            'quantite_stock' => 'required|numeric',
        ]);

        $stock = Stock::create($validated);

        return response()->json([
            'message' => 'Stock ajouté avec succès',
            'stock' => $stock
        ], 201);
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'biere_id' => 'sometimes|required|exists:bieres,id',
            'quantite_stock' => 'sometimes|required|numeric',
        ]);

        $stock->update($validated);

        return response()->json([
            'message' => 'Stock mis à jour avec succès',
            'stock' => $stock
        ], 200);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return response()->json([
            'message' => 'Stock supprimé avec succès'
        ], 204);
    }
}

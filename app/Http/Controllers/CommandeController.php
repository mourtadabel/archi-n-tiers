<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function upload(Request $request)
    {
        DB::beginTransaction();

        try {
            $commande = Commande::create([
                'valide' => false,
            ]);

            foreach ($request->bieres as $item) {
                $biere = Stock::where('biere_id', $item['biere_id'])->first();
                
                if (!$biere || $biere->quantite_stock < $item['quantite']) {
                    throw new \Exception('La quantité de stock est insuffisante pour la bière ID ' . $item['biere_id']);
                }

                $commande->bieres()->attach($item['biere_id'], ['quantite' => $item['quantite']]);

                $biere->quantite_stock -= $item['quantite'];
                $biere->save();
            }

            DB::commit();

            return response()->json(['message' => 'Commande créée avec succès'], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function index($id)
    {
        $commande = Commande::with('bieres')->find($id);

        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }

        $quantite_stock = [];
        foreach ($commande->bieres as $biere) {
            $stock = Stock::where('biere_id', $biere->id)->first();
            $quantite_stock[$biere->id] = $stock ? $stock->quantite_stock : 0;
        }

        return response()->json([
            'id_commande' => $commande->id,
            'valide' => $commande->valide,
            'contenu' => $commande->bieres,
            'quantite_stock' => $quantite_stock
        ]);
    }
}

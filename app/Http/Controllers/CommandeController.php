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
        // Validez les données de la requête...
        
        // Démarrez une transaction
        DB::beginTransaction();

        try {
            // Créez la commande avec le statut de validation par défaut à false
            $commande = Commande::create([
                'valide' => false,
                // Autres champs de la commande...
            ]);

            // Pour chaque bière dans la commande
            foreach ($request->bieres as $item) {
                // Vérifiez si la bière existe et si elle a une quantité suffisante en stock
                $biere = Stock::where('biere_id', $item['biere_id'])->first();
                
                if (!$biere || $biere->quantite_stock < $item['quantite']) {
                    throw new \Exception('La quantité de stock est insuffisante pour la bière ID ' . $item['biere_id']);
                }

                // Créez une entrée dans la table pivot biere_commande pour chaque bière commandée
                $commande->bieres()->attach($item['biere_id'], ['quantite' => $item['quantite']]);

                // Mettez à jour la quantité de stock de la bière
                $biere->quantite_stock -= $item['quantite'];
                $biere->save();
            }

            // Validez la transaction
            DB::commit();

            return response()->json(['message' => 'Commande créée avec succès'], 201);
        } catch (\Exception $e) {
            // En cas d'erreur, annulez la transaction
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        // Récupérez les détails de la commande avec son contenu (les bières commandées)
        $commande = Commande::with('bieres')->find($id);

        // Si la commande n'est pas trouvée, renvoyez une réponse 404
        if (!$commande) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }

        // Récupérez la quantité restante de chaque bière en stock
        $quantite_stock = [];
        foreach ($commande->bieres as $biere) {
            $stock = Stock::where('biere_id', $biere->id)->first();
            $quantite_stock[$biere->id] = $stock ? $stock->quantite_stock : 0;
        }

        // Renvoyez les détails de la commande avec le statut valide et la quantité restante de chaque bière
        return response()->json([
            'id_commande' => $commande->id,
            'valide' => $commande->valide,
            'contenu' => $commande->bieres,
            'quantite_stock' => $quantite_stock
        ]);
    }
}

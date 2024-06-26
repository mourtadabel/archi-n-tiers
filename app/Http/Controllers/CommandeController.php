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
                $commande->valide = true;
                $commande->save();
                $biere->save();
            }

            DB::commit();

            return response()->json(['message' => 'Commande créée avec succès', 'commande' => $commande], 201);
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

        $contenu = [];
        foreach ($commande->bieres as $biere) {
            $stock = Stock::where('biere_id', $biere->id)->first();
            $quantite_stock = $stock ? $stock->quantite_stock : 0;

            $contenu[] = [
                'nom_biere' => $biere->nom,
                'quantite_commandee' => $biere->pivot->quantite,
                'quantite_stock' => $quantite_stock
            ];
        }
        /*
         return response()->json([
            'id_commande' => $commande->id,
            'valide' => $commande->valide,
            'contenu' => $contenu
        ]); */

        return [
            'id_commande' => $commande->id,
            'valide' => $commande->valide,
            'contenu' => $contenu
        ];
    }

    public function indexAll()
    {
        $commandes = Commande::where('valide', true)->with('bieres')->get();

        $result = [];

        foreach ($commandes as $commande) {
            $commandeDetails = $this->index($commande->id);
            $result[] = $commandeDetails;
        }

        return response()->json($result);
    }
}

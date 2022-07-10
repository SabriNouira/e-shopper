<?php

namespace App\Http\Controllers;

use App\Commande;
use App\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    //
    public function store(Request $request)
    {
        //dd($request);

        // verifier si une commande est en cours pour ce client
        $commande = Commande::where('client_id', Auth::user()->id)->where('etat', 'en cours')->first();

        // creation commande

        if ($commande) { // commande existe
            // check if produit existe
            $existe = false;
            foreach ($commande->lignecommandes as $lignec) {
                if ($lignec->product_id == $request->idproduct) {
                    $existe = true;
                    $lignec->qte += $request->qte;
                    $lignec->update();
                }
            }
            if (!$existe) {
                // creation ligne de commande
                $lc = new LigneCommande();
                $lc->qte = $request->qte;
                $lc->product_id = $request->idproduct;
                $lc->commande_id = $commande->id;
                $lc->save();
            }

            return redirect('/client/cart')->with('sucess', 'produit commander');
        } else { // new commande
            $commande = new Commande();
            $commande->client_id = Auth::user()->id;

            if ($commande->save()) {
                // creation ligne de commande
                $lc = new LigneCommande();
                $lc->qte = $request->qte;
                $lc->product_id = $request->idproduct;
                $lc->commande_id = $commande->id;
                $lc->save();

                return redirect('/client/cart')->with('sucess', 'impossible de commander le produit');
            } else {
                return redirect()->back()->with('error', 'produit commander');
            }
        }
    }

    public function LigneCommandeDestroy($idlc)
    {
        $lc = LigneCommande::find($idlc);
        $lc->delete();
        return redirect()->back()->with('success', 'Ligne supprimée');
    }
}

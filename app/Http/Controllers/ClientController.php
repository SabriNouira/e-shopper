<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Review;
use App\Category;
use App\Commande;

class ClientController extends Controller
{
    //

    // afficher le dashboard client
    public function dashboard()
    {
        return view('client.dashboard');
    }

    public function profile()
    {
        return view('client.profile');
    }

    public function updateProfile(Request $request)
    {

        Auth::user()->name = $request->name;
        Auth::user()->email = $request->email;
        if ($request->password) { //if il y a mot de passe
            Auth::user()->password = Hash::make($request->password);
        }


        Auth::user()->update();

        return redirect('client/profile')->with('success', 'client modifier avec succée');
    }

    public function addReview(Request $request)
    {
        $review = new Review();
        $review->rate = $request->rate;
        $review->product_id = $request->product_id;
        $review->content = $request->content;
        $review->user_id = Auth::user()->id;

        $review->save();

        return redirect()->back();
    }

    public function cart()
    {
        $categories = Category::all();
        $commande = Commande::where('client_id', Auth::user()->id)->where('etat', 'en cours')->first();

        return view('guest.cart')->with('categories', $categories)->with('commande', $commande);
    }

    public function checkout(Request $request)
    {
        $commande = Commande::find($request->commande);
        $commande->etat = "payée";
        $commande->update();
        return redirect('/client/dashboard')->with('success', 'commande payée avec succées');
        //dd($commande->getTotal());
    }

    public function mescommandes(Request $request)
    {
        return view('client.commandes');
    }

    public function afficherMeassageBloquer()
    {
        return view('client.bloquer');
    }
}

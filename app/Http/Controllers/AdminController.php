<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    // afficher le dashboard admin
    public function dashboard()
    {
        $categories = Category::all();
        $products = Product::all();
        $clients = User::where('role', 'user')->get();
        return view('admin.dashboard')->with('categories', $categories)->with('products', $products)->with('clients', $clients);
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {

        Auth::user()->name = $request->name;
        Auth::user()->email = $request->email;
        if ($request->password) { //if il y a mot de passe
            Auth::user()->password = Hash::make($request->password);
        }


        Auth::user()->update();

        return redirect('admin/profile')->with('success', 'admin modifier avec succée');
    }

    public function clients()
    {
        $clients = User::where('role', 'user')->get();
        return view('admin.clients.index')->with('clients', $clients);
    }

    public function BloquerUser($iduser)
    {
        $client = User::find($iduser);
        $client->is_active = false;
        $client->update();

        return redirect()->back()->with('success', 'client bloquer');
    }

    public function DebloquerUser($iduser)
    {
        $client = User::find($iduser);
        $client->is_active = true;
        $client->update();

        return redirect()->back()->with('success', 'client debloquer');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class ProductController extends Controller
{
    //

    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('admin.products.index')->with('products', $products)->with('categories', $categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'qte' => 'required',
            'photo' => 'required',
        ]);

        $produit = new Product();
        $produit->name = $request->name;
        $produit->category_id = $request->categorie;
        $produit->description = $request->description;
        $produit->price = $request->price;
        $produit->qte = $request->qte;

        //upload file
        $newname = uniqid();
        $image = $request->file('photo');
        $newname .= "." . $image->getClientOriginalExtension();
        $destnationPath = 'uploads';
        $image->move($destnationPath, $newname);

        $produit->photo = $newname;

        if ($produit->save()) {
            return redirect()->back();
        } else {
            echo "error";
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        $file_path = public_path() . '/uploads/' . $product->photo;
        unlink($file_path);
        if ($product->delete()) {
            return redirect()->back();
        } else {
            echo "error";
        }
    }

    public function update(Request $request)
    {


        $produit = Product::find($request->id_produit);
        $produit->name = $request->name;
        $produit->description = $request->description;
        $produit->price = $request->price;
        $produit->qte = $request->qte;

        //upload file
        if ($request->file('photo')) {
            // supprimer l'ancienne photo
            $file_path = public_path() . '/uploads/' . $produit->photo;
            unlink($file_path);

            $newname = uniqid();
            $image = $request->file('photo');
            $newname .= "." . $image->getClientOriginalExtension();
            $destnationPath = 'uploads';
            $image->move($destnationPath, $newname);

            $produit->photo = $newname;
        }

        if ($produit->update()) {
            return redirect()->back();
        } else {
            echo "error";
        }
    }
}

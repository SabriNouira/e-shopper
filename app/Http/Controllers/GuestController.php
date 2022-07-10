<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;


class GuestController extends Controller
{
    //
    public function home()
    {

        $produits = Product::all();
        $categories = Category::all();
        return view('guest.home')->with('produits', $produits)->with('categories', $categories);
    }

    public function shops()
    {

        $products = Product::all();
        $categories = Category::all();
        return view('guest.shop')->with('products', $products)->with('categories', $categories);
    }

    public function productDetails($id)
    {

        $product = Product::find($id);
        $products = Product::where('id', '!=', $id)->get();
        return view('guest.product-details')->with('product', $product)->with('products', $products);
    }

    public function shop($idcategory)
    {

        $category = Category::find($idcategory);
        $products = $category->products;

        $categories = Category::all();
        return view('guest.shop')->with('categories', $categories)->with('products', $products);
    }

    public function search(Request $request)
    {

        $products = Product::where('name', 'LIKE', '%' . $request->keywords . '%')->get();

        $categories = Category::all();
        return view('guest.shop')->with('categories', $categories)->with('products', $products);
    }
}

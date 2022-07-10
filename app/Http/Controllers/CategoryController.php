<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    //
    //affiche la liste de categories
    public function index(){
        $categories = Category::all();
        return view('admin.categories.index')->with('categories', $categories);
    }

    //ajout d'un categorie
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        if($category->save()){
            return redirect()->back();
        }else{
            echo "error";
        }
        
    }

    public function destroy($id){
        $categorie = Category::find($id);
        if($categorie -> delete()){
            return redirect()->back();
        }else{
            echo "error";
        }
    }

    public function update(Request $request){

            $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $id = $request->id_category;
        $category = Category::find($id);

        $category->name = $request->name;
        $category->description = $request->description;

        if($category->update()){
            return redirect()->back();
        }else{
            echo "error";
        }
    }
}

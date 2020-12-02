<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryCollectionResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): CategoryCollectionResource{
        $category = Category::with('product')->get();
        return new CategoryCollectionResource($category);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return response([
            'message' => 'Category added'
        ]);
    }

    public function show($id){
        $category = Category::where('id', $id)
            ->with('product')->first();

        if ($category) {
            return new CategoryResource($category);
        } else {
            return response([
                'message' => 'Category not found'
            ]);
        }
    }

    public function update($id, Request $request){
//        $request->validate([
//            'name' => 'required|string|max:255'
//        ]);

        $data = [
            'name' => $request->name
        ];

        $category = Category::where('id', $id)->with('product')->first();

        $category->update($data);

        return new CategoryResource($category);
    }

    public function destroy($id) {
        $category = Category::where('id', $id)->first();
        if ($category) {
            $category->delete();
            return response([
                'message' => 'Category deleted'
            ]);
        } else {
            return response([
                'error!' => 'Category not found'
            ]);
        }
    }
}

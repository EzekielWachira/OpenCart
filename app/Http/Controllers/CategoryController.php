<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories(){
        $category = Category::with('product')->get();
        return CategoryResource::collection($category);
    }

    public function addCategory(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

//        $category = new Category();
//        $category->name = $request->name;
        if (auth()->user()->tokenCan('ADD_CATEGORY')) {
            $category = Category::create($request->all());
//            $category->save();
            return new CategoryResource($category);
//            return response([
//                'message' => 'Category added'
//            ]);
        } else {
            abort(403, 'You are not allowed to do this operation');
        }

    }

    public function show(string $name){
        $category = Category::where('name', $name)
            ->with('product')->first();

            return new CategoryResource($category);
//        if ($category) {
//        } else {
//            return response([
//                'message' => 'Category not found'
//            ]);
//        }
    }

    public function updateCategory($name, Request $request){
//        $request->validate([
//            'name' => 'required|string|max:255'
//        ]);

        $data = [
            'name' => $request->name
        ];

        $category = Category::where('name', $name)->with('product')->first();
        if (auth()->user()->tokenCan('UPDATE_CATEGORY')) {
            $category->update($data);

            return new CategoryResource($category);
        } else {
            abort(403, 'You are not allowed to do this operation');
        }

    }

    public function deleteCategory($name) {
        $category = Category::where('name', $name)->first();
        if ($category) {
            if (auth()->user()->tokenCan('DELETE_CATEGORY')) {
                $category->delete();
                return response([
                    'message' => 'Category deleted'
                ]);
            } else {
                abort(403, 'You are not allowed to do this operation');
            }
        } else {
            return response([
                'error!' => 'Category not found'
            ]);
        }
    }
}

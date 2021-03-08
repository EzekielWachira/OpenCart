<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function getAll() {
        $product = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return ProductResource::collection($product);
    }

    public function addProduct(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'description' => 'required|string',
            'price' => 'required',
            'image' => 'required',
        ]);

//        $category = Category::where('name', $categoryName)->first();

//        dd($category);

        $product = new Product();
        $product->category_id = $request->category_id;
//        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
//        $product->image = $request->file('image');
        $product->image = 'http://127.0.0.1:8000/storage/images/'.time().'_'.$request->file('image')
            ->getClientOriginalName();

        $request->file('image')->storeAs(
            'images', time().'_'.$request->file('image')
            ->getClientOriginalName(), 'public'
        );

        if (auth()->user()->tokenCan('ADD_PRODUCT')) {
            $product->save();

            return response([
                'message' => 'Product added'
            ]);
        } else {
            abort(403, 'You are not allowed to do this operation');
        }

    }

    public function showProduct($id) {
        $product = Product::where('id', $id)->with('category')
            ->first();
        if ($product) {
            return new ProductResource($product);
        } else {
            return response([
                'message' => 'Product not found'
            ]);
        }
    }

    public function updateProduct($id, Request $request){
        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ];

        if ($request->hasFile('image')) {
            $data = [ 'image' => time().'_'.$request->file('product_image')->getClientOriginalName()];
            $request->file('product_image')->storeAs(
                'images', time().'_'.$request->file('product_image')
                ->getClientOriginalName(), 'public'
            );
        }

        $product = Product::where('id', $id)->with('category')->first();

        if (auth()->user()->tokenCan('UPDATE_PRODUCT')) {
            $product->update($data);

            return new ProductResource($product);
        } else {
            abort(403, 'You are not allowed to do this operation');
        }


    }

    public function deleteProduct(Product $product){
        $product->delete();
        if (auth()->user()->tokenCan('DELETE_PRODUCT')) {
            return response([
                'message' => 'Product deleted'
            ]);
        } else {
            abort(403, 'You are not allowed to do this operation');
        }
//        return new ProductResource($product);
    }
}

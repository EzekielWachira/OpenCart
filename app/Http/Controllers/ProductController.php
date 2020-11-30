<?php

namespace App\Http\Controllers;

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
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
            'image' => 'required',
        ]);

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = time().'_'.$request->file('image')
            ->getClientOriginalName();

        $request->file('image')->storeAs(
            'images', time().'_'.$request->file('image')
            ->getClientOriginalName(), 'public'
        );

        $product->save();

        return response([
            'message' => 'Product added'
        ]);

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

        $product->update($data);

        return new ProductResource($product);
    }

    public function deleteProduct(Product $product){
        $product->delete();
        return response([
            'message' => 'Product deleted'
        ]);
//        return new ProductResource($product);
    }
}

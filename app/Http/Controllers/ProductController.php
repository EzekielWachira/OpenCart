<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index() : ProductResourceCollection {
        return new ProductResourceCollection(Product::paginate()); 
    }
    public function show(Product $product): ProductResource {
        return new ProductResource($product);
    }
    
    public function store(Request $request): ProductResource {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
            'category_id' => 'required'
        ]);
        $product = Product::create($request->all());
        return new ProductResource($product);
    }
    public function update(Product $product, Request $request): ProductResource {
        $product->update($request->all());
        return new ProductResource($product);
    }
}

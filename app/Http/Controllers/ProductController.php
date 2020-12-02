<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * @return ProductResourceCollection
     */
    public function index() : ProductResourceCollection {
        return new ProductResourceCollection(Product::paginate()); 
    }
    /**
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource {
        return new ProductResource($product);
    }
    /**
     * @param Request $request
     * @return ProductResource
     */
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
    /**
     * @param Product $product
     * @param Request $request
     * @return ProductResource
     */
    public function update(Product $product, Request $request): ProductResource {
        $product->update($request->all());
        return new ProductResource($product);
    }
    /**
     * @param Note $note
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Product $product){
        $product->delete();
        return response()->json(
            ['message' => 'Item deleted successfully', 200]
        )->header('Content-Type', 'application/json');
    }
}

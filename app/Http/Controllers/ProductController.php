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
}

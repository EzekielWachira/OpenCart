<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Resources\CartResource;
use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getAllCart(){
        $cart = Cart::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return CartResource::collection($cart);
    }

    public function addToCart(Product $product){
//        $request->validate([
//            'product_id' => 'required'
//        ]);

//        $product = Product::where('id', $id)->first();

        $cart = new Cart();
        $cart->product_id = $product->id;

        $cart->save();

        return new CartResource($cart);
    }

    public function removeProductFromCart(Cart $cart){
        $cart->delete();
        return response([
            'message' => 'Item removed from cart'
        ]);
    }

    public function clearCart(){
        $cart = Cart::all();
    }
}

<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Resources\CartResource;
use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getAllCart(){
        $cart = Cart::with('product', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if (!auth()->user()->tokenCan('VIEW_CART')) {
            abort(403, 'You are not allowed to view the cart');
        }

        return CartResource::collection($cart);
    }

    public function addToCart(Request $request, $id){
        $product = Product::where('id', $id)->first();

        if (!auth()->user()->tokenCan('ADD_CART')) {
            abort(403, 'You are not allowed to add to cart');
        }
        $cart = new Cart();
        $cart->product_id = $product->id;
        $cart->user_id = $request->user()->id;

        $cart->save();
//        response()->download(public_path('file_name'), 'name you intend to name it');

        return new CartResource($cart);
    }

    public function removeProductFromCart($id){
        $cart = Cart::where('id', $id)->first();
        if (!auth()->user()->tokenCan('DELETE_CART')) {
            abort(403, 'You are not allowed to conduct such an operation');
        }
        $cart->delete();
        return response([
            'message' => 'Item removed from cart'
        ]);
    }

    public function clearCart(Cart $cart){
//        $cart = Cart::all();
        $cart->delete();
    }
}

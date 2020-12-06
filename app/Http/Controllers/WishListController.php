<?php

namespace App\Http\Controllers;

use App\Http\Resources\WishListResource;
use App\Product;
use App\WishList;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function getAllWishList(){
        $wishList = WishList::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return WishListResource::collection($wishList);
    }

    public function addToWishList(Request $request,$id) {
//        $request->validate([
//            'product_id' => 'required'
//        ]);
        $product = Product::where('id', $id)->first();

        $wishList = new WishList();
        $wishList->product_id = $product->id;
        $wishList->user_id = $request->user()->id;

        $wishList->save();

        return new WishListResource($wishList);
    }

    public function removeProductFromWishList(WishList $wishList){
        if ($wishList) {
            $wishList->delete();
            return response([
                'message' => 'Product removed from wishlist'
            ]);
        } else {
            return response([
                'error!' => 'Product to remove not found'
            ]);
        }
    }

    public function clearWishList(){

    }
}

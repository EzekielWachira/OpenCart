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

        if (!auth()->user()->tokeCan('VIEW_WISHLIST')) {
            abort(403, 'You are not allowed to view wishlist');
        }

        return WishListResource::collection($wishList);
    }

    public function addToWishList(Request $request,$id) {
        $product = Product::where('id', $id)->first();

        if (!auth()->user()->tokenCan('ADD_WISHLIST')) {
            abort(403, 'You are not allowed to add to wishlist');
        }

        $wishList = new WishList();
        $wishList->product_id = $product->id;
        $wishList->user_id = $request->user()->id;

        $wishList->save();

        return new WishListResource($wishList);
    }

    public function removeProductFromWishList($wishList_id){

        $wishList = WishList::where('id', $wishList_id)->first();

        if ($wishList) {
            if (!auth()->user()->tokenCan('REMOVE_WISHLIST')) {
                abort(403, 'You are not allowed to remove item from wishlist');
            }
            $wishList->delete();
            return response([
                'message' => 'Product removed from wishlist'
            ]);
        } else {
            return response([
                'error' => 'Product to remove not found'
            ]);
        }
    }

    public function clearWishList(){

    }
}

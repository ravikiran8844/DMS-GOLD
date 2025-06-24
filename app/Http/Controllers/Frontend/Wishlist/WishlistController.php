<?php

namespace App\Http\Controllers\Frontend\Wishlist;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    private $paginate = 10;
    use Common;

    function wishlist()
    {
        $wishlist = Wishlist::where('wishlists.user_id', Auth::user()->id)
            ->paginate($this->paginate);
        return view('dealer.wishlist.wishlist', compact('wishlist'));
    }

    function getWishlistProducts()
    {
        $wishlist = Wishlist::join('products', 'products.id', 'wishlists.product_id')
            ->where('wishlists.user_id', Auth::user()->id)
            ->select('wishlists.*', 'products.qty as stock', 'products.product_image', 'products.product_unique_id', 'products.product_name', 'products.moq', 'products.size_id', 'products.color_id', 'products.plating_id', 'products.weight')
            ->get();

        return response()->json(array(
            'wishlist' => $wishlist
        ));
    }

    function addToWishlist(Request $request)
    {
        $existingWishlist = Wishlist::where('user_id', Auth::user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingWishlist) {
            $existingWishlist->delete();

            $notification = array(
                'message' => 'Removed from Wishlist',
                'alert' => 'error'
            );

            return response()->json([
                'response' => $notification
            ]);
        } else {
            Wishlist::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id
            ]);

            $notification = array(
                'message' => 'Added to Wishlist',
                'alert' => 'success'
            );

            return response()->json([
                'response' => $notification
            ]);
        }
    }

    public function deleteWishlist($id)
    {
        $wishlist = Wishlist::where('id', $id);
        $wishlist->delete();

        $notification = array(
            'message' => 'Wishlist Product Deleted Successfully',
            'alert' => 'success'
        );

        return response()->json([
            'responseData' => $notification
        ]);
    }
}

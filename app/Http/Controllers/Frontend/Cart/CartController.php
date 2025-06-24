<?php

namespace App\Http\Controllers\Frontend\Cart;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Dealer;
use App\Models\Finish;
use App\Models\Size;
use App\Models\User;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    use Common;

    function cart()
    {
        $cart = Cart::select('carts.*', 'products.moq', 'products.qty')
            ->join('products', 'products.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();

        $dealer = User::where('role_id', Roles::Dealer)->where('is_active', 1)->orderby('name', 'ASC')->get();
        $cartQty = Cart::where('user_id', Auth::user()->id)->sum('qty');
        $cartWeight = Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->value('totalWeight');
        $previousUrl = url()->previous();
        return view('dealer.cart.cart', compact('cart', 'cartQty', 'cartWeight', 'previousUrl', 'dealer'));
    }

    function getCartProducts()
    {
        $carts = Cart::join('products', 'products.id', 'carts.product_id')
            ->leftjoin('sizes', 'sizes.id', 'carts.size_id')
            ->join('styles', 'styles.id', 'products.style_id')
            ->where('carts.user_id', Auth::user()->id)
            ->select('carts.*', 'products.qty as stock', 'products.product_image', 'products.product_unique_id', 'sizes.size', 'products.weight', 'products.moq', 'styles.style_name', 'products.height', 'products.width', 'products.project_id')
            ->get();

        $cartQty = Cart::join('products', 'products.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            // ->where('products.qty', '>', 0)
            ->select('carts.*', 'products.qty as stock')
            ->count('carts.id');

        $sizes = Size::where('is_active', 1)->whereNull('deleted_at')->get();
        // Prepare an array to hold finishes by project_id
        $finishesByProject = [];

        // Iterate through carts to retrieve finishes based on project_id
        foreach ($carts as $item) {
            // Check if finishes for this project_id are already retrieved
            if (!isset($finishesByProject[$item->project_id])) {
                // Fetch finishes for this project_id
                $finishesByProject[$item->project_id] = Finish::where('project_id', $item->project_id)
                    ->where('is_active', 1)
                    ->whereNull('deleted_at')
                    ->get();
            }
        }

        // Attach finishes to each cart item
        foreach ($carts as $item) {
            $item->finishes = $finishesByProject[$item->project_id];
        }
        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'sizes' => $sizes,
            'finishes' => $finishesByProject
        ));
    }

    public function removeCartProduct($id)
    {
        $Cart = Cart::findOrFail($id);
        $Cart->delete();
        $cartQty = Cart::join('products', 'products.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->select('carts.*', 'products.qty as stock')
            ->count('carts.id');
        $cartqtycount = Cart::where('user_id', Auth::user()->id)->sum('qty');
        $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->value('totalWeight');
        $notification = [
            'message' => 'Successfully Removed From Cart',
            'alert' => 'success'
        ];
        return response()->json([
            'notification' => $notification,
            'cartQty' => $cartQty,
            'cartqtycount' => $cartqtycount,
            'cartweightcount' => $cartweightcount
        ]);
    }

    public function removeAllCartProduct()
    {
        $Cart = Cart::where('user_id', Auth::user()->id);
        $Cart->delete();
        $cartQty = 0;
        $notification = [
            'message' => 'Successfully Removed All From Cart',
            'alert' => 'success'
        ];
        return response()->json([
            'notification' => $notification,
            'cartQty' => $cartQty
        ]);
    }

    public function cartQuantity(Request $request)
    {
        try {
            Cart::where('product_id', $request->product_id)->update([
                'qty' => $request->qty,
            ]);

            $totalQty = Cart::select('carts.*', 'products.weight')
                ->join('products', 'products.id', 'carts.product_id')
                ->where('carts.user_id', Auth::user()->id)
                ->get();
            return response()->json([
                'response' => $totalQty
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    function addRemark(Request $request)
    {
        cart::where('id', $request->cart_id)->update([
            'remarks' => $request->remarks,
            'others' => $request->others,
            'box_details' => $request->box
        ]);

        $notification = array(
            'message' => 'Remarks Added Successfully!',
            'alert' => 'success'
        );

        return response()->json([
            'response' => $notification
        ]);
    }

    function addFinish(Request $request)
    {
        cart::where('id', $request->cartId)->update([
            'finish_id' => $request->finish_id,
        ]);

        $notification = array(
            'message' => 'Finish Updated Successfully!',
            'alert' => 'success'
        );

        return response()->json([
            'response' => $notification
        ]);
    }
}

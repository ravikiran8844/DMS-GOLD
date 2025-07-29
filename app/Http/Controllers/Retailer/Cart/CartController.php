<?php

namespace App\Http\Controllers\Retailer\Cart;

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
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    use Common;

    function cart()
    {
        $cart = Cart::select(
            'carts.*',
            'product_variants.qty',
            'products.product_image'
        )
            ->join('product_variants', 'product_variants.id', '=', 'carts.product_id')
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->where('carts.user_id', Auth::id())
            ->get();
        
        $dealer = User::where('role_id', Roles::Dealer)->where('is_active', 1)->orderby('name', 'ASC')->get();
        $cartQty = Cart::where('user_id', Auth::user()->id)->sum('qty');
        $cartWeight = Cart::select(DB::raw('SUM(carts.qty * product_variants.weight) as totalWeight'))
            ->join('product_variants', 'product_variants.id', '=', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->value('totalWeight');
        $previousUrl = url()->previous();
        return view('retailer.cart.cart', compact('cart', 'cartQty', 'cartWeight', 'previousUrl', 'dealer'));
    }

    private function cryptoJsAesEncrypt($passphrase, $plaintext)
    {
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';

        while (strlen($salted) < 48) {
            $dx = md5($dx . $passphrase . $salt, true);
            $salted .= $dx;
        }

        $key = substr($salted, 0, 32);
        $iv = substr($salted, 32, 16);

        $encrypted = openssl_encrypt($plaintext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $ciphertext = 'Salted__' . $salt . $encrypted;

        return urlencode(base64_encode($ciphertext));
    }

    function getCartProducts()
    {
        $secret = 'EmeraldAdmin';
        $carts = Cart::join('product_variants', 'product_variants.id', 'carts.product_id')
            ->join('products', 'products.id', 'product_variants.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->select('carts.*', 'product_variants.qty as stock', 'products.product_image', 'products.DesignNo', 'product_variants.weight')
            ->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $cartQty = Cart::join('product_variants', 'product_variants.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->select('carts.*', 'product_variants.qty as stock')
            ->count('carts.id');
        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty
        ));
    }

    public function removeCartProduct($id)
    {
        $Cart = Cart::findOrFail($id);
        $Cart->delete();
        $cartQty = Cart::join('product_variants', 'product_variants.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->select('carts.*', 'product_variants.qty as stock')
            ->count('carts.id');
        $cartqtycount = Cart::where('user_id', Auth::user()->id)->sum('qty');
        $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * product_variants.weight) as totalWeight'))
            ->join('product_variants', 'product_variants.id', '=', 'carts.product_id')
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

            $totalQty = Cart::select('carts.*', 'product_variants.weight')
                ->join('product_variants', 'product_variants.id', 'carts.product_id')
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

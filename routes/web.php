<?php

use App\Models\Banner;
use App\Models\Settings;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    $banner = Banner::where('banner_position_id', 1)->where('project', 'RMS')->first();
    $mobilebanner = Banner::where('banner_position_id', 4)->where('project', 'RMS')->first();
    return view('retailer.landing.landing', compact('banner', 'mobilebanner'));
});

// Include the admin routes using the group method
require base_path('routes/admin.php');
require base_path('routes/retailer.php');

Route::group(['middleware' => ['auth']], function () {
    Route::get('maintanance', function () {
        return view('frontend.maintanance.maintanance');
    })->name('maintanance');
    $maintanance = Settings::first();

    if ($maintanance->is_maintanance_mode == 0) {
        Route::get('home', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'landing'])->name('landing');

        //Electro forming
        Route::get('electroforming/ganesha', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'ganesha'])->name('ganesha');
        Route::get('electroforming/hanuman', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'hanuman'])->name('hanuman');
        Route::get('electroforming/krishna', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'krishna'])->name('krishna');
        Route::get('electroforming/lakshmi', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'lakshmi'])->name('lakshmi');
        Route::get('electroforming/buddha', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'buddha'])->name('buddha');
        Route::get('electroforming/category', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'category'])->name('category');

        //Solid Idol
        Route::get('solid-idol/siganesha', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'siGanesh'])->name('ganesha');
        Route::get('solid-idol/sihanuman', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'siHanuman'])->name('hanuman');
        Route::get('solid-idol/sikrishna', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'sikrishna'])->name('krishna');
        Route::get('solid-idol/silakshmi', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'siLakshmi'])->name('lakshmi');
        Route::get('solid-idol/sivishnu', [\App\Http\Controllers\Frontend\Landing\LandingController::class, 'siVishnu'])->name('vishnu');

        //Logout

        //Readystock
        Route::get('efreadystock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'efReadyStock'])->name('efreadystock');
        Route::get('sireadystock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'siReadyStock'])->name('sireadystock');
        Route::get('jewelleryreadystock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'jewelleryReadyStock'])->name('jewelleryreadystock');
        Route::get('indianiareadystock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'indianiaReadyStock'])->name('indianiareadystock');
        Route::get('utensilreadystock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'utensilReadyStock'])->name('utensilreadystock');

        //Stock 
        Route::get('efstock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'efStock'])->name('efstock');
        Route::get('sistock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'siStock'])->name('sistock');
        Route::get('jewellerystock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'jewelleryStock'])->name('jewellerystock');
        Route::get('indianiastock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'indianiaStock'])->name('indianiastock');
        Route::get('utensilstock', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'utensilStock'])->name('utensilstock');

        Route::get('productdetail/{id}', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'productDetail'])->name('productdetail');
        Route::post('addtocart', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'addToCart'])->name('addtocart');
        Route::post('addforcart', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'addForCart'])->name('addforcart');
        Route::post('addalltocart', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'addAllToCart'])->name('addalltocart');
        Route::post('repeatorder', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'repeatOrder']);
        Route::post('repeatorderByid', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'repeatorderByid']);

        //search
        Route::get('search', [\App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'search'])->name('search');

        //collectionfilter
        Route::get('collectionwiseproduct/{id}', [App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'collectionWiseProduct'])->name('collectionwiseproduct');

        //weightrangefilter
        Route::get('weightrange/{id}', [App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'weightrange'])->name('weightrange');

        //subcollectionwiseproductfilter
        Route::get('subcollectionwiseproduct/{id}', [App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'subcollectionwiseproduct'])->name('subcollectionwiseproduct');

        //classificatiowiseproduct
        Route::get('classificationwiseproduct/{id}', [App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'classificationwiseproduct'])->name('classificationwiseproduct');

        //jewelcategorywiseproduct
        Route::get('categorywiseproduct/{id}', [App\Http\Controllers\Frontend\EF\ReadyStockController::class, 'categorywiseproduct'])->name('categorywiseproduct');

        // cart
        Route::get('cart', [\App\Http\Controllers\Frontend\Cart\CartController::class, 'cart'])->name('cart');
        Route::get('getcartproducts', [\App\Http\Controllers\Frontend\Cart\CartController::class, 'getCartProducts'])->name('getcartproducts');
        Route::get('removecart/{id}', [\App\Http\Controllers\Frontend\Cart\CartController::class, 'removeCartProduct'])->name('removecart');
        Route::get('removeallcart', [\App\Http\Controllers\Frontend\Cart\CartController::class, 'removeAllCartProduct'])->name('removeallcart');
        Route::get('cartqty', [\App\Http\Controllers\Frontend\Cart\CartController::class, 'cartQuantity'])->name('cartqty');
        Route::get('addremark', [\App\Http\Controllers\Frontend\Cart\CartController::class, 'addRemark'])->name('addremark');
        Route::get('addfinish', [\App\Http\Controllers\Frontend\Cart\CartController::class, 'addFinish'])->name('addfinish');

        //Profile
        Route::get('myprofile', [\App\Http\Controllers\Frontend\Profile\ProfileController::class, 'myProfile'])->name('myprofile');
        Route::post('profileupdate', [\App\Http\Controllers\Frontend\Profile\ProfileController::class, 'profileupdate'])->name('profileupdate');

        //wishlist
        Route::get('wishlist', [\App\Http\Controllers\Frontend\Wishlist\WishlistController::class, 'wishlist'])->name('wishlist');
        Route::get('wishlistproducts', [\App\Http\Controllers\Frontend\Wishlist\WishlistController::class, 'getWishlistProducts'])->name('wishlistproducts');
        Route::get('addtowishlist', [\App\Http\Controllers\Frontend\Wishlist\WishlistController::class, 'addToWishlist'])->name('addtowishlist');
        Route::get('deletewishlist/{id}', [\App\Http\Controllers\Frontend\Wishlist\WishlistController::class, 'deleteWishlist'])->name('deletewishlist');

        //Order
        Route::post('placeorder', [\App\Http\Controllers\Frontend\Order\OrderController::class, 'placeOrder'])->name('placeorder');
        Route::get('orders', [\App\Http\Controllers\Frontend\Order\OrderController::class, 'orders'])->name('orders');
        Route::get('orderdata', [\App\Http\Controllers\Frontend\Order\OrderController::class, 'orderData'])->name('orderdatas');
        Route::get('orderdetail/{order_id}', [\App\Http\Controllers\Frontend\Order\OrderController::class, 'getOrderDetail'])->name('orderdetail');
    } else {
        return view('dealer.maintanance.maintanance');
    }
});

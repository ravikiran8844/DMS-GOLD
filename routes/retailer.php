<?php

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

Route::fallback(function () {
    return view('backend.admin.error.error');
});
// Route::post('/save-internet-speed', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'store']);
Route::prefix('retailer')->group(function () {
    //Register
    Route::get('register', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'register'])->name('retailerregister');
    Route::post('registerstore', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'registerStore'])->name('retailerregisterstore');

    //Login
    // Route::get('login', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'login'])->name('retailerlogin');

    // //Login Verify
    // Route::get('loginverify', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'loginVerify'])->name('retailerloginverify');

    //Generate OTP 
    Route::get('generateotp', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'generateOTP'])->name('retailergenerateotp');

    //Login Verification
    Route::get('loginverfication', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'loginVerification'])->name('retailerloginverfication');
    Route::get('proxy/pincode/{pincode}', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'getPincodeData'])->name('retailerpincode');

    //Sitemap
    Route::get('sitemap', [\App\Http\Controllers\Retailer\SitemapController::class, 'index']);

    //Get Dealer
    Route::get('getdealer', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'getDealers'])->name('getdealer');

    Route::group(['middleware' => ['retailer']], function () {
        Route::get('home', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'landing'])->name('retailerlanding');

        //Electro forming
        Route::get('electroforming/ganesha', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'ganesha'])->name('efganesha');
        Route::get('electroforming/hanuman', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'hanuman'])->name('efhanuman');
        Route::get('electroforming/krishna', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'krishna'])->name('efkrishna');
        Route::get('electroforming/lakshmi', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'lakshmi'])->name('eflakshmi');
        Route::get('electroforming/buddha', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'buddha'])->name('efbuddha');
        Route::get('electroforming/category', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'category'])->name('retailercategory');

        //Solid Idol
        Route::get('solid-idol/ganesha', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'siGanesh'])->name('siganesha');
        Route::get('solid-idol/hanuman', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'siHanuman'])->name('sihanuman');
        Route::get('solid-idol/krishna', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'sikrishna'])->name('sikrishna');
        Route::get('solid-idol/lakshmi', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'siLakshmi'])->name('silakshmi');
        Route::get('solid-idol/vishnu', [\App\Http\Controllers\Retailer\Landing\LandingController::class, 'siVishnu'])->name('sivishnu');

        //Logout
        Route::get('logout', [\App\Http\Controllers\Retailer\Login\LoginController::class, 'logout'])->name('retailerlogout');

        Route::get('efreadystock', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'efReadyStock'])->name('retailerefreadystock');
        Route::get('sireadystock', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'siReadyStock'])->name('retailersireadystock');
        Route::get('jewelleryreadystock', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'jewelleryReadyStock'])->name('retailerjewelleryreadystock');
        Route::get('indianiareadystock', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'indianiaReadyStock'])->name('retailerindianiareadystock');
        Route::get('utensilreadystock', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'utensilReadyStock'])->name('retailerutensilreadystock');
        Route::get('productdetail/{id}', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'productDetail'])->name('retailerproductdetail');
        Route::post('addtocart', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'addToCart'])->name('retaileraddtocart');
        Route::post('addforcart', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'addForCart'])->name('retaileraddforcart');
        Route::post('addalltocart', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'addAllToCart'])->name('retaileraddalltocart');
        Route::post('repeatorder', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'repeatOrder']);
        Route::post('repeatorderByid', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'repeatorderByid']);

        //search
        Route::get('search', [\App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'search'])->name('retailersearch');

        //collectionfilter
        Route::get('collectionwiseproduct/{id}', [App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'collectionWiseProduct'])->name('retailercollectionwiseproduct');

        //weightrangefilter
        Route::get('weightrange/{id}', [App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'weightrange'])->name('retailerweightrange');

        //subcollectionwiseproductfilter
        Route::get('subcollectionwiseproduct/{id}', [App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'subcollectionwiseproduct'])->name('retailersubcollectionwiseproduct');

        //classificatiowiseproduct
        Route::get('classificationwiseproduct/{id}', [App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'classificationwiseproduct'])->name('retailerclassificationwiseproduct');

        //jewelcategorywiseproduct
        Route::get('categorywiseproduct/{id}', [App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'categorywiseproduct'])->name('retailercategorywiseproduct');

        //boxwiseproduct
        Route::get('boxwiseproduct/{id}', [App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'getBoxwiseProduct'])->name('retailerboxwiseproduct');
       
        //puritywiseproduct
        Route::get('puritywiseproduct/{id}', [App\Http\Controllers\Retailer\EF\ReadyStockController::class, 'getPuritywiseProduct'])->name('retailerpuritywiseproduct');

        // cart
        Route::get('cart', [\App\Http\Controllers\Retailer\Cart\CartController::class, 'cart'])->name('retailercart');
        Route::get('getcartproducts', [\App\Http\Controllers\Retailer\Cart\CartController::class, 'getCartProducts'])->name('retailergetcartproducts');
        Route::get('removecart/{id}', [\App\Http\Controllers\Retailer\Cart\CartController::class, 'removeCartProduct'])->name('retailerremovecart');
        Route::get('removeallcart', [\App\Http\Controllers\Retailer\Cart\CartController::class, 'removeAllCartProduct'])->name('retailerremoveallcart');
        Route::get('cartqty', [\App\Http\Controllers\Retailer\Cart\CartController::class, 'cartQuantity'])->name('retailercartqty');
        Route::get('addremark', [\App\Http\Controllers\Retailer\Cart\CartController::class, 'addRemark'])->name('retaileraddremark');
        Route::get('addfinish', [\App\Http\Controllers\Retailer\Cart\CartController::class, 'addFinish'])->name('retaileraddfinish');

        //Profile
        Route::get('myprofile', [\App\Http\Controllers\Retailer\Profile\ProfileController::class, 'myProfile'])->name('retailermyprofile');
        Route::post('profileupdate', [\App\Http\Controllers\Retailer\Profile\ProfileController::class, 'profileupdate'])->name('retailerprofileupdate');

        //wishlist
        Route::get('wishlist', [\App\Http\Controllers\Retailer\Wishlist\WishlistController::class, 'wishlist'])->name('retailerwishlist');
        Route::get('wishlistproducts', [\App\Http\Controllers\Retailer\Wishlist\WishlistController::class, 'getWishlistProducts'])->name('retailerwishlistproducts');
        Route::get('addtowishlist', [\App\Http\Controllers\Retailer\Wishlist\WishlistController::class, 'addToWishlist'])->name('retaileraddtowishlist');
        Route::get('deletewishlist/{id}', [\App\Http\Controllers\Retailer\Wishlist\WishlistController::class, 'deleteWishlist'])->name('retailerdeletewishlist');

        //Order
        Route::post('placeorder', [\App\Http\Controllers\Retailer\Order\OrderController::class, 'placeOrder'])->name('retailerplaceorder');
        Route::get('orders', [\App\Http\Controllers\Retailer\Order\OrderController::class, 'orders'])->name('retailerorders');
        Route::get('orderdata', [\App\Http\Controllers\Retailer\Order\OrderController::class, 'orderData'])->name('retailerorderdatas');
        Route::get('orderdetail/{order_id}', [\App\Http\Controllers\Retailer\Order\OrderController::class, 'getOrderDetail'])->name('retailerorderdetail');
    });
});

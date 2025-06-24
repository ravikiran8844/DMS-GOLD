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
//Login
Route::get('adminlogin', [\App\Http\Controllers\Backend\Login\LoginController::class, 'login'])->name('adminlogin');

//Login Verify
Route::get('adminloginverify', [\App\Http\Controllers\Backend\Login\LoginController::class, 'loginVerify'])->name('adminloginverify');

//Generate OTP 
Route::get('admin/generateotp', [\App\Http\Controllers\Backend\Login\LoginController::class, 'generateOTP'])->name('admingenerateotp');

//Login Verification
Route::get('adminloginverfication', [\App\Http\Controllers\Backend\Login\LoginController::class, 'loginVerification'])->name('adminloginverfication');

Route::group(['middleware' => ['auth']], function () {

    //Logout
    Route::get('logout', [\App\Http\Controllers\Backend\Login\LoginController::class, 'logout'])->name('logout');

    //Dashboard
    Route::get('dashboard', [\App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('filters', [\App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'filters'])->name('filters');

    //Dealer Dashboard
    Route::get('dealer_dashboard', [\App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'dealer_dashboard'])->name('dealer_dashboard');
    Route::get('order_details', [\App\Http\Controllers\Backend\Dashboard\DashboardController::class, 'order_details'])->name('order_details');

    //Dealer List
    Route::get('dealerlist', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'dealerList'])->name('dealerlist');
    Route::get('dearlerdownload', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'dearlerdownload'])->name('dearlerdownload');
    Route::get('dealerdetails', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'dealerDetails'])->name('dealerdetails');
    Route::post('dealercreate', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'dealerCreate'])->name('dealercreate');
    Route::post('dealerupdate', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'dealerUpdate'])->name('dealerupdate');
    Route::post('importdealer', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'importDealer'])->name('importdealer');
    Route::get('dealerdata', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'dealerData'])->name('dealerdata');
    Route::get('getdealer/{id}', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'getDealerById'])->name('getdealerbyid');
    Route::get('deletedealer/{id}', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'deleteDealer'])->name('deletedealer');
    Route::post('dealerstatus/{id}/{status}', [\App\Http\Controllers\Backend\Dealer\DealersController::class, 'dealerStatus'])->name('dealerstatus');


    //notification
    Route::post('markAllAsRead', [\App\Http\Controllers\Backend\Order\OrderController::class, 'markAllAsRead'])->name('markAllAsRead');
    //Shipment
    Route::get('shipment', [\App\Http\Controllers\Backend\Shipment\ShipmentController::class, 'shipment'])->name('shipment');

    //Team
    Route::get('team', [\App\Http\Controllers\Backend\Team\TeamController::class, 'team'])->name('team');

    //Costing
    Route::get('costing', [\App\Http\Controllers\Backend\Costing\CostingController::class, 'costing'])->name('costing');

    //Project & Timeline
    Route::get('projecttimeline', [\App\Http\Controllers\Backend\ProjectTimeline\ProjectTimelineController::class, 'projectTimeline'])->name('projecttimeline');

    //Project Detail
    Route::get('projectdetail', [\App\Http\Controllers\Backend\ProjectTimeline\ProjectTimelineController::class, 'projectDetail'])->name('projectdetail');

    //Invoice
    Route::get('invoice', [\App\Http\Controllers\Backend\Invoice\InvoiceController::class, 'invoice'])->name('invoice');

    //Notification
    Route::get('notification', [\App\Http\Controllers\Backend\Notification\NotificationController::class, 'notification'])->name('notification');

    //Profile
    Route::get('profile', [\App\Http\Controllers\Backend\Profile\ProfileController::class, 'profile'])->name('profile');
    Route::post('profileupdate', [\App\Http\Controllers\Backend\Profile\ProfileController::class, 'profileUpdate'])->name('profileupdate');

    //Activity
    Route::get('activity', [\App\Http\Controllers\Backend\Activity\ActivityController::class, 'activity'])->name('activity');


    /*<-------------------  MASTERS  --------------------->*/
    //Category
    Route::get('category', [\App\Http\Controllers\Backend\Master\CategoryController::class, 'category'])->name('category');
    Route::get('downloadcategory', [\App\Http\Controllers\Backend\Master\CategoryController::class, 'downloadcategory'])->name('downloadcategory');
    Route::post('categorycreate', [\App\Http\Controllers\Backend\Master\CategoryController::class, 'categoryCreate'])->name('categorycreate');
    Route::get('getcategorydata', [\App\Http\Controllers\Backend\Master\CategoryController::class, 'getCategoryData'])->name('getcategorydata');
    Route::get('getcategory/{id}', [\App\Http\Controllers\Backend\Master\CategoryController::class, 'getCategoryById'])->name('getcategorybyid');
    Route::get('deletecategory/{id}', [\App\Http\Controllers\Backend\Master\CategoryController::class, 'deleteCategory'])->name('deletecategory');
    Route::post('categorystatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\CategoryController::class, 'categoryStatus'])->name('categorystatus');
    Route::post('importcategory', [\App\Http\Controllers\Backend\Master\CategoryController::class, 'importCategory'])->name('importcategory');

    //Sub Category
    Route::get('subcategory', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'subCategory'])->name('subcategory');
    Route::get('getcategory', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'getCategory'])->name('getcategory');
    Route::get('downloadsubcategory', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'downloadsubcategory'])->name('downloadsubcategory');
    Route::post('subcategorycreate', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'subCategoryCreate'])->name('subcategorycreate');
    Route::get('getsubcategorydata', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'getSubCategoryData'])->name('getsubcategorydata');
    Route::get('getsubcategory/{id}', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'getSubCategoryById'])->name('getsubcategorybyid');
    Route::get('deletesubcategory/{id}', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'deleteSubCategory'])->name('deletesubcategory');
    Route::post('subcategorystatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'subCategoryStatus'])->name('subcategorystatus');
    Route::post('importsubcategory', [\App\Http\Controllers\Backend\Master\SubCategoryController::class, 'importSubCategory'])->name('importsubcategory');

    //zone
    Route::get('zone', [\App\Http\Controllers\Backend\Master\ZoneController::class, 'zone'])->name('zone');
    Route::post('zonecreate', [\App\Http\Controllers\Backend\Master\ZoneController::class, 'zoneCreate'])->name('zonecreate');
    Route::get('getzonedata', [\App\Http\Controllers\Backend\Master\ZoneController::class, 'getZoneData'])->name('getzonedata');
    Route::get('getzone/{id}', [\App\Http\Controllers\Backend\Master\ZoneController::class, 'getZoneById'])->name('getzonebyid');
    Route::get('deletezone/{id}', [\App\Http\Controllers\Backend\Master\ZoneController::class, 'deleteZone'])->name('deletezone');
    Route::post('zonestatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\ZoneController::class, 'zoneStatus'])->name('zonestatus');

    //Finish
    Route::get('finish', [\App\Http\Controllers\Backend\Master\FinishController::class, 'finish'])->name('finish');
    Route::post('finishcreate', [\App\Http\Controllers\Backend\Master\FinishController::class, 'finishCreate'])->name('finishcreate');
    Route::get('getfinishdata', [\App\Http\Controllers\Backend\Master\FinishController::class, 'getFinishData'])->name('getfinishdata');
    Route::get('getfinish/{id}', [\App\Http\Controllers\Backend\Master\FinishController::class, 'getFinishById'])->name('getfinishbyid');
    Route::get('deletefinish/{id}', [\App\Http\Controllers\Backend\Master\FinishController::class, 'deleteFinish'])->name('deletefinish');
    Route::post('finishstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\FinishController::class, 'finishStatus'])->name('finishstatus');

    //collection
    Route::get('collections', [\App\Http\Controllers\Backend\Master\CollectionController::class, 'collection'])->name('collection');
    Route::get('getcollectionsize', [\App\Http\Controllers\Backend\Master\CollectionController::class, 'getSize'])->name('getcollectionsize');
    Route::post('collectioncreate', [\App\Http\Controllers\Backend\Master\CollectionController::class, 'collectionCreate'])->name('collectioncreate');
    Route::get('getcollectiondata', [\App\Http\Controllers\Backend\Master\CollectionController::class, 'getCollectionData'])->name('getcollectiondata');
    Route::get('getcollection/{id}', [\App\Http\Controllers\Backend\Master\CollectionController::class, 'getCollectionById'])->name('getcollectionbyid');
    Route::get('deletecollection/{id}', [\App\Http\Controllers\Backend\Master\CollectionController::class, 'deleteCollection'])->name('deletecollection');
    Route::post('collectionstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\CollectionController::class, 'collectionStatus'])->name('collectionstatus');

    //subcollection
    Route::get('subcollections', [\App\Http\Controllers\Backend\Master\SubCollectionController::class, 'subCollection'])->name('subcollection');
    Route::post('subcollectioncreate', [\App\Http\Controllers\Backend\Master\SubCollectionController::class, 'subCollectionCreate'])->name('subcollectioncreate');
    Route::get('getsubcollectiondata', [\App\Http\Controllers\Backend\Master\SubCollectionController::class, 'getSubCollectionData'])->name('getsubcollectiondata');
    Route::get('getsubcollection/{id}', [\App\Http\Controllers\Backend\Master\SubCollectionController::class, 'getSubCollectionById'])->name('getsubcollectionbyid');
    Route::get('deletesubcollection/{id}', [\App\Http\Controllers\Backend\Master\SubCollectionController::class, 'deleteSubCollection'])->name('deletesubcollection');
    Route::post('subcollectionstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\SubCollectionController::class, 'subCollectionStatus'])->name('subcollectionstatus');

    //banner
    Route::get('banner', [\App\Http\Controllers\Backend\Master\BannerController::class, 'banner'])->name('banner');
    Route::get('getbannersize', [\App\Http\Controllers\Backend\Master\BannerController::class, 'getSize'])->name('getbannersize');
    Route::post('bannercreate', [\App\Http\Controllers\Backend\Master\BannerController::class, 'bannerCreate'])->name('bannercreate');
    Route::get('getbannerdata', [\App\Http\Controllers\Backend\Master\BannerController::class, 'getBannerData'])->name('getbannerdata');
    Route::get('getbanner/{id}', [\App\Http\Controllers\Backend\Master\BannerController::class, 'getBannerById'])->name('getbannerbyid');
    Route::get('deletebanner/{id}', [\App\Http\Controllers\Backend\Master\BannerController::class, 'deleteBanner'])->name('deletebanner');
    Route::post('bannerstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\BannerController::class, 'bannerStatus'])->name('bannerstatus');

    //Metal
    Route::get('metaltype', [\App\Http\Controllers\Backend\Master\MetalController::class, 'metal'])->name('metal');
    Route::get('getmetal', [\App\Http\Controllers\Backend\Master\MetalController::class, 'getMetal'])->name('getmetal');
    Route::post('metalcreate', [\App\Http\Controllers\Backend\Master\MetalController::class, 'metalCreate'])->name('metalcreate');
    Route::get('getmetaldata', [\App\Http\Controllers\Backend\Master\MetalController::class, 'getMetalData'])->name('getmetaldata');
    Route::get('getmetal/{id}', [\App\Http\Controllers\Backend\Master\MetalController::class, 'getMetalById'])->name('getmetalbyid');
    Route::get('deletemetal/{id}', [\App\Http\Controllers\Backend\Master\MetalController::class, 'deleteMetal'])->name('deletemetal');
    Route::post('metalstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\MetalController::class, 'metalStatus'])->name('metalstatus');

    //Brand
    Route::get('brand', [\App\Http\Controllers\Backend\Master\BrandController::class, 'brand'])->name('brand');
    Route::get('getbrand', [\App\Http\Controllers\Backend\Master\BrandController::class, 'getbrand'])->name('getbrand');
    Route::post('brandcreate', [\App\Http\Controllers\Backend\Master\BrandController::class, 'brandCreate'])->name('brandcreate');
    Route::get('getbranddata', [\App\Http\Controllers\Backend\Master\BrandController::class, 'getBrandData'])->name('getbranddata');
    Route::get('getbrand/{id}', [\App\Http\Controllers\Backend\Master\BrandController::class, 'getBrandById'])->name('getbrandbyid');
    Route::get('deletebrand/{id}', [\App\Http\Controllers\Backend\Master\BrandController::class, 'deleteBrand'])->name('deletebrand');
    Route::post('brandstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\BrandController::class, 'brandStatus'])->name('brandstatus');

    //Brand
    Route::get('weight', [\App\Http\Controllers\Backend\Master\WeightController::class, 'weight'])->name('weight');
    Route::get('getweight', [\App\Http\Controllers\Backend\Master\WeightController::class, 'getweight'])->name('getweight');
    Route::post('weightcreate', [\App\Http\Controllers\Backend\Master\WeightController::class, 'weightCreate'])->name('weightcreate');
    Route::get('getweightdata', [\App\Http\Controllers\Backend\Master\WeightController::class, 'getWeightData'])->name('getweightdata');
    Route::get('getweight/{id}', [\App\Http\Controllers\Backend\Master\WeightController::class, 'getWeightById'])->name('getweightbyid');
    Route::get('deleteweight/{id}', [\App\Http\Controllers\Backend\Master\WeightController::class, 'deleteWeight'])->name('deleteweight');
    Route::post('weightstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\WeightController::class, 'weightStatus'])->name('weightstatus');

    // Plating
    Route::get('plating', [\App\Http\Controllers\Backend\Master\PlatingController::class, 'plating'])->name('plating');
    Route::get('getplating', [\App\Http\Controllers\Backend\Master\PlatingController::class, 'getPlating'])->name('getplating');
    Route::post('platingcreate', [\App\Http\Controllers\Backend\Master\PlatingController::class, 'platingCreate'])->name('platingcreate');
    Route::get('getplatingdata', [\App\Http\Controllers\Backend\Master\PlatingController::class, 'getPlatingData'])->name('getplatingdata');
    Route::get('getplating/{id}', [\App\Http\Controllers\Backend\Master\PlatingController::class, 'getPlatingById'])->name('getplatingbyid');
    Route::get('deleteplating/{id}', [\App\Http\Controllers\Backend\Master\PlatingController::class, 'deletePlating'])->name('deleteplating');
    Route::post('platingstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\PlatingController::class, 'platingStatus'])->name('platingstatus');

    // Shape
    Route::get('shape', [\App\Http\Controllers\Backend\Master\ShapeController::class, 'shape'])->name('shape');
    Route::get('getshape', [\App\Http\Controllers\Backend\Master\ShapeController::class, 'getShape'])->name('getshape');
    Route::post('shapecreate', [\App\Http\Controllers\Backend\Master\ShapeController::class, 'shapeCreate'])->name('shapecreate');
    Route::get('getshapedata', [\App\Http\Controllers\Backend\Master\ShapeController::class, 'getShapeData'])->name('getshapedata');
    Route::get('getshape/{id}', [\App\Http\Controllers\Backend\Master\ShapeController::class, 'getShapeById'])->name('getshapebyid');
    Route::get('deleteshape/{id}', [\App\Http\Controllers\Backend\Master\ShapeController::class, 'deleteShape'])->name('deleteshape');
    Route::post('shapestatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\ShapeController::class, 'shapeStatus'])->name('shapestatus');

    // Size
    Route::get('size', [\App\Http\Controllers\Backend\Master\SizeController::class, 'size'])->name('size');
    Route::get('getsize', [\App\Http\Controllers\Backend\Master\SizeController::class, 'getSize'])->name('getsize');
    Route::post('sizecreate', [\App\Http\Controllers\Backend\Master\SizeController::class, 'sizeCreate'])->name('sizecreate');
    Route::get('getsizedata', [\App\Http\Controllers\Backend\Master\SizeController::class, 'getSizeData'])->name('getsizedata');
    Route::get('getsize/{id}', [\App\Http\Controllers\Backend\Master\SizeController::class, 'getSizeById'])->name('getsizebyid');
    Route::get('deletesize/{id}', [\App\Http\Controllers\Backend\Master\SizeController::class, 'deleteSize'])->name('deletesize');
    Route::post('sizestatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\SizeController::class, 'sizeStatus'])->name('sizestatus');

    // Style
    Route::get('style', [\App\Http\Controllers\Backend\Master\StyleController::class, 'style'])->name('style');
    Route::get('getstyle', [\App\Http\Controllers\Backend\Master\StyleController::class, 'getStyle'])->name('getstyle');
    Route::post('stylecreate', [\App\Http\Controllers\Backend\Master\StyleController::class, 'styleCreate'])->name('stylecreate');
    Route::get('getstyledata', [\App\Http\Controllers\Backend\Master\StyleController::class, 'getStyleData'])->name('getstyledata');
    Route::get('getstyle/{id}', [\App\Http\Controllers\Backend\Master\StyleController::class, 'getStyleById'])->name('getstylebyid');
    Route::get('deletestyle/{id}', [\App\Http\Controllers\Backend\Master\StyleController::class, 'deleteStyle'])->name('deletestyle');
    Route::post('stylestatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\StyleController::class, 'styleStatus'])->name('stylestatus');

    // Color
    Route::get('color', [\App\Http\Controllers\Backend\Master\ColorController::class, 'color'])->name('color');
    Route::get('getcolor', [\App\Http\Controllers\Backend\Master\ColorController::class, 'getColor'])->name('getcolor');
    Route::post('colorcreate', [\App\Http\Controllers\Backend\Master\ColorController::class, 'colorCreate'])->name('colorcreate');
    Route::get('getcolordata', [\App\Http\Controllers\Backend\Master\ColorController::class, 'getColorData'])->name('getcolordata');
    Route::get('getcolor/{id}', [\App\Http\Controllers\Backend\Master\ColorController::class, 'getColorById'])->name('getcolorbyid');
    Route::get('deletecolor/{id}', [\App\Http\Controllers\Backend\Master\ColorController::class, 'deleteColor'])->name('deletecolor');
    Route::post('colorstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\ColorController::class, 'colorStatus'])->name('colorstatus');

    //Project
    Route::get('project', [\App\Http\Controllers\Backend\Master\ProjectController::class, 'project'])->name('project');
    Route::get('getproject', [\App\Http\Controllers\Backend\Master\ProjectController::class, 'getProject'])->name('getproject');
    Route::post('projectcreate', [\App\Http\Controllers\Backend\Master\ProjectController::class, 'projectCreate'])->name('projectcreate');
    Route::get('getprojectdata', [\App\Http\Controllers\Backend\Master\ProjectController::class, 'getProjectData'])->name('getprojectdata');
    Route::get('getproject/{id}', [\App\Http\Controllers\Backend\Master\ProjectController::class, 'getProjectById'])->name('getProjectbyid');
    Route::get('deleteproject/{id}', [\App\Http\Controllers\Backend\Master\ProjectController::class, 'deleteProject'])->name('deleteproject');
    Route::post('projectstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\ProjectController::class, 'projectStatus'])->name('projectstatus');

    //Jewel Type
    Route::get('jeweltype', [\App\Http\Controllers\Backend\Master\JewelTypeController::class, 'jewel'])->name('jeweltype');
    Route::get('getjewel', [\App\Http\Controllers\Backend\Master\JewelTypeController::class, 'getJewel'])->name('getjewel');
    Route::post('jewelcreate', [\App\Http\Controllers\Backend\Master\JewelTypeController::class, 'jewelCreate'])->name('jewelcreate');
    Route::get('getjeweldata', [\App\Http\Controllers\Backend\Master\JewelTypeController::class, 'getJewelData'])->name('getjeweldata');
    Route::get('getjewel/{id}', [\App\Http\Controllers\Backend\Master\JewelTypeController::class, 'getJewelById'])->name('getjewelbyid');
    Route::get('deletejewel/{id}', [\App\Http\Controllers\Backend\Master\JewelTypeController::class, 'deleteJewel'])->name('deletejewel');
    Route::post('jewelstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\JewelTypeController::class, 'jewelStatus'])->name('jewelstatus');

    //popup
    Route::get('popup', [\App\Http\Controllers\Backend\Master\PopupController::class, 'popup'])->name('popup');
    Route::post('popupcreate', [\App\Http\Controllers\Backend\Master\PopupController::class, 'popupCreate'])->name('popupcreate');
    Route::get('getpopupdata', [\App\Http\Controllers\Backend\Master\PopupController::class, 'getPopupData'])->name('getpopupdata');
    Route::get('getpopup/{id}', [\App\Http\Controllers\Backend\Master\PopupController::class, 'getPopupById'])->name('getpopupbyid');
    Route::get('deletepopup/{id}', [\App\Http\Controllers\Backend\Master\PopupController::class, 'deletePopup'])->name('deletepopup');

    // Product
    Route::get('product', [\App\Http\Controllers\Backend\Master\ProductController::class, 'product'])->name('product');
    Route::get('downloadproduct', [\App\Http\Controllers\Backend\Master\ProductController::class, 'downloadproduct'])->name('downloadproduct');
    Route::get('getsubcategory', [\App\Http\Controllers\Backend\Master\ProductController::class, 'getSubCategory'])->name('getsubcategory');
    Route::get('productlist', [\App\Http\Controllers\Backend\Master\ProductController::class, 'productList'])->name('productlist');
    Route::post('productcreate', [\App\Http\Controllers\Backend\Master\ProductController::class, 'productCreate'])->name('productcreate');
    Route::get('getproductsdata/{type?}', [\App\Http\Controllers\Backend\Master\ProductController::class, 'productData'])->name('getproductsdata');
    Route::get('getproduct/{id}', [\App\Http\Controllers\Backend\Master\ProductController::class, 'getProductById'])->name('getproductbyid');
    Route::post('productupdate', [\App\Http\Controllers\Backend\Master\ProductController::class, 'productUpdate'])->name('productupdate');
    Route::post('productstatus/{id}/{status}', [\App\Http\Controllers\Backend\Master\ProductController::class, 'productStatus'])->name('productstatus');
    Route::get('deleteproduct/{id}', [\App\Http\Controllers\Backend\Master\ProductController::class, 'deleteProduct'])->name('deleteproduct');
    Route::post('importproduct', [\App\Http\Controllers\Backend\Master\ProductController::class, 'importProduct'])->name('importproduct');
    Route::get('deletemultipleimage/{id}', [\App\Http\Controllers\Backend\Master\ProductController::class, 'productMultiImageDelete'])->name('deletemultipleimage');

    //Roles
    Route::get('role', [\App\Http\Controllers\Backend\Permission\RoleController::class, 'roles'])->name('role');
    Route::post('rolecreate', [\App\Http\Controllers\Backend\Permission\RoleController::class, 'roleCreate'])->name('rolecreate');
    Route::get('getroledata', [\App\Http\Controllers\Backend\Permission\RoleController::class, 'getRoleData'])->name('getroledata');
    Route::get('getrole/{id}', [\App\Http\Controllers\Backend\Permission\RoleController::class, 'getRoleById'])->name('getrolebyid');
    Route::get('deleterole/{id}', [\App\Http\Controllers\Backend\Permission\RoleController::class, 'deleteRole'])->name('deleterole');
    Route::post('rolestatus/{id}/{status}', [\App\Http\Controllers\Backend\Permission\RoleController::class, 'roleStatus'])->name('rolestatus');
    Route::post('importrole', [\App\Http\Controllers\Backend\Permission\RoleController::class, 'importRole'])->name('importrole');

    //Role permission
    Route::get('rolepermission', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'rolePermission'])->name('rolepermission');
    Route::post('rolepermissioncreate', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'rolePermissionCreate'])->name('rolepermissioncreate');
    Route::get('rolepermissiondata', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'getRolePermissionData'])->name('rolepermissiondata');
    Route::get('getrolepermission/{id}', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'getRolePermissionById'])->name('getrolepermissionbyid');
    Route::get('userphone', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'addUserPhone'])->name('adduserphone');
    Route::post('userphonecreate', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'userPhoneCreate'])->name('userphonecreate');
    Route::get('getuserphonedata', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'getUserPhoneData'])->name('getuserphonedata');
    Route::get('getuserphone/{id}', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'getUserPhoneById'])->name('getuserphonebyid');
    Route::get('deleteuserphone/{id}', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'deleteUserPhone'])->name('deleteuserphone');


    //users
    Route::get('users', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'users'])->name('users');
    Route::post('createuser', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'createUser'])->name('createuser');
    Route::get('listmenus/{id}', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'listMenus'])->name('listmenus');
    Route::get('userpermissiondata', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'getUserPermissionData'])->name('userpermissiondata');
    Route::get('getuserpermission/{id}', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'getUserPermissionById'])->name('getUserPermission');
    Route::post('userpermission/{id}/{status}', [\App\Http\Controllers\Backend\Permission\RolePermissionController::class, 'rolePermissionStatus'])->name('UserPermissionstatus');

    //Order
    Route::get('order', [\App\Http\Controllers\Backend\Order\OrderController::class, 'order'])->name('order');
    Route::get('dealerorderdata', [\App\Http\Controllers\Backend\Order\OrderController::class, 'orderData'])->name('dealerorderdata');
    Route::get('/download/{invoice}', [\App\Http\Controllers\Backend\Order\OrderController::class, 'invoiceDownload'])->name('invoicedownload');
    Route::get('invoice/{invoice}', [\App\Http\Controllers\Backend\Order\OrderController::class, 'orderInvoiceDownload'])->name('orderinvoicedownload');
    Route::post('approve', [\App\Http\Controllers\Backend\Order\OrderController::class, 'approved'])->name('approve');
    Route::post('/cancel', [\App\Http\Controllers\Backend\Order\OrderController::class, 'cancel'])->name('cancel');
    Route::post('exportstock', [\App\Http\Controllers\Backend\Order\OrderController::class, 'exportStock'])->name('exportstock');
    Route::get('orderqty', [\App\Http\Controllers\Backend\Order\OrderController::class, 'orderQuantity'])->name('orderqty');

    //Approved Order
    Route::get('approvedorder', [\App\Http\Controllers\Backend\Order\OrderController::class, 'approvedOrder'])->name('approvedorder');
    Route::get('disapprovedorder', [\App\Http\Controllers\Backend\Order\OrderController::class, 'disApprovedOrder'])->name('disapprovedorder');
    Route::get('approvedorderdata', [\App\Http\Controllers\Backend\Order\OrderController::class, 'approvedOrderData'])->name('approvedorderdata');
    Route::get('disapprovedorderdata', [\App\Http\Controllers\Backend\Order\OrderController::class, 'disApprovedOrderData'])->name('disapprovedorderdata');

    //Settings
    Route::get('settings', [\App\Http\Controllers\Backend\Settings\SettingsController::class, 'setting'])->name('settings');
    Route::post('settingsstore', [\App\Http\Controllers\Backend\Settings\SettingsController::class, 'settingStore'])->name('settingstore');
    Route::post('ordersettingsstore', [\App\Http\Controllers\Backend\Settings\SettingsController::class, 'orderSettingStore'])->name('ordersettingstore');

    //Stock
    Route::get('stockmaintenance', [\App\Http\Controllers\Backend\Stock\StockController::class, 'stock'])->name('stock');
    Route::get('stockdata', [\App\Http\Controllers\Backend\Stock\StockController::class, 'getStockData'])->name('stockdata');
    Route::get('stockupdate', [\App\Http\Controllers\Backend\Stock\StockController::class, 'stockUpdate'])->name('stockupdate');
    Route::get('downloadstock', [\App\Http\Controllers\Backend\Stock\StockController::class, 'downloadStock'])->name('downloadstock');
    Route::post('importstock', [\App\Http\Controllers\Backend\Stock\StockController::class, 'importStock'])->name('importstock');
    Route::get('/import-status', [\App\Http\Controllers\Backend\Stock\StockController::class, 'checkImportStatus'])->name('importstatus');

    //Retailer
    Route::get('retailerlist', [\App\Http\Controllers\Backend\Retailer\RetailerController::class, 'retailer'])->name('retailer');
    Route::get('retailerdata', [\App\Http\Controllers\Backend\Retailer\RetailerController::class, 'retailerData'])->name('retailerdata');
    Route::get('getretailer/{id}', [\App\Http\Controllers\Backend\Retailer\RetailerController::class, 'getRetailerById'])->name('getretailer');
    Route::post('retailerupdate', [\App\Http\Controllers\Backend\Retailer\RetailerController::class, 'retailerUpdate'])->name('retailerupdate');
    Route::post('retailerstatus/{id}/{status}', [\App\Http\Controllers\Backend\Retailer\RetailerController::class, 'retailerStatus'])->name('retailerstatus');
    Route::get('/proxy-pincode/{pincode}', [\App\Http\Controllers\Backend\Retailer\RetailerController::class, 'pincode'])->name('retailerpincode');
});

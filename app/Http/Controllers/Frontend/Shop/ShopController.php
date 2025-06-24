<?php

namespace App\Http\Controllers\Frontend\Shop;

use App\Enums\Projects;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Finish;
use App\Models\MakingCharge;
use App\Models\Plating;
use App\Models\Product;
use App\Models\ProductMultipleImage;
use App\Models\Project;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\SubCollection;
use App\Models\Weight;
use App\Traits\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Models\OrderDetail;

class ShopController extends Controller
{
    private $paginate = 42;
    use Common;

    function search(Request $request)
    {
        ini_set('max_execution_time', 180); //3 minutes
        $products = $this->getproducts(Auth::user()->id)
            ->where('products.product_unique_id', 'like', '%' . $request->search . '%')
            ->orwhere('products.product_name', 'like', '%' . $request->search . '%')
            ->orwhere('products.keywordtags', 'like', '%' . $request->search . '%')
            ->where('products.is_active', 1)
            ->orderBy('product_unique_id', "ASC")
            ->paginate($this->paginate);


        // Check if no results were found
        if ($products->count() == 0) {
            // Take the first four characters from the search term
            $searchSubstring = substr($request->search, 0, 4);
            // Perform a new query with the modified search term
            $product = $this->getproducts(Auth::user()->id)
                ->where('products.product_unique_id', 'like', '%' . $searchSubstring . '%')
                ->orWhere('products.product_name', 'like', '%' . $searchSubstring . '%')
                ->orWhere('products.keywordtags', 'like', '%' . $searchSubstring . '%')
                ->where('products.is_active', 1)
                ->orderBy('product_unique_id', 'ASC')
                ->paginate($this->paginate);
        } else {
            $product = $this->getproducts(Auth::user()->id)
                ->where('products.product_unique_id', 'like', '%' . $request->search . '%')
                ->orwhere('products.product_name', 'like', '%' . $request->search . '%')
                ->orwhere('products.keywordtags', 'like', '%' . $request->search . '%')
                ->where('products.is_active', 1)
                ->orderBy('product_unique_id', "ASC")
                ->paginate($this->paginate);
        }

        $allProduct = Product::select('id')->get();
        $stock = 0;
        $breadcrum = null;
        $breadcrumUrl = null;
        $search = $request->search;
        return view('frontend.shop.shop', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum'));
    }

    public function suggestions(Request $request)
    {
        $term = $request->input('search');
        $suggestions = Product::where('products.product_unique_id', 'like', '%' . $term . '%')
            ->orWhere('products.product_name', 'like', '%' . $term . '%')
            ->orWhere('products.keywordtags', 'like', '%' . $term . '%')
            ->limit(10)
            ->get();

        return response()->json($suggestions);
    }

    function shop($id = null)
    {
        ini_set('max_execution_time', 180); //3 minutes
        $productQuery = $this->getproducts(Auth::user()->id);
        $decryptedCategoryId = null;
        if ($id) {
            $decryptedCategoryId = decrypt($id);
            $productQuery->where('products.category_id', $decryptedCategoryId);
        }
        $product = $productQuery->orderBy('product_unique_id', "ASC")->paginate($this->paginate);
        $allProduct = Product::select('id')->get();
        $stock = 0;
        $breadcrum = $id != null ? Category::where('id', $decryptedCategoryId)->value('category_name') : 'shop';
        $breadcrumUrl = $id != null ? route('shop', $id) : route('shop');
        return view('frontend.shop.shop', compact('product', 'allProduct', 'decryptedCategoryId', 'stock', 'breadcrum', 'breadcrumUrl'));
    }

    function newArrivals()
    {
        ini_set('max_execution_time', 180); //3 minutes
        $startDate = Carbon::now()->subDays(45);
        $productQuery = $this->getproducts(Auth::user()->id)->where('products.created_at', '>=', $startDate);
        $product = $productQuery->orderBy('product_unique_id', "ASC")->paginate($this->paginate);
        $allProduct = Product::select('id')->get();
        $stock = 0;
        $breadcrum = 'New Arrivals';
        $breadcrumUrl = route('newarrivals');
        return view('frontend.shop.shop', compact('product', 'allProduct', 'stock', 'breadcrumUrl', 'breadcrum'));
    }

    function project($id = null)
    {
        ini_set('max_execution_time', 180); //3 minutes
        $productQuery = $this->getproducts(Auth::user()->id);
        if ($id) {
            $decryptedProjectId = decrypt($id);
            $productQuery->where('products.project_id', $decryptedProjectId);
        }

        $product = $productQuery->orderBy('product_unique_id', "ASC")->paginate($this->paginate);
        $allProduct = Product::select('id')->get();
        $stock = 0;
        $breadcrum = Project::where('id', $decryptedProjectId)->value('project_name');
        $breadcrumUrl = url('projects', $id);
        return view('frontend.shop.shop', compact('product', 'allProduct', 'decryptedProjectId', 'stock', 'breadcrum', 'breadcrumUrl'));
    }

    function stock()
    {
        ini_set('max_execution_time', 180); //3 minutes
        $user_id = Auth::user()->id;
        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            // ->where('product_unique_id', 'not like', '%A%')
            // ->where('product_unique_id', 'not like', '%GP%')
            // ->where('product_unique_id', 'not like', '%G%')
            ->join('projects', 'projects.id', 'products.project_id')
            ->where('products.qty', '>', 0);
        // if ($id) {
        //     $decryptedProjectId = decrypt($id);
        //     $productQuery->where('products.project_id', $decryptedProjectId);
        // }
        // $sql = $productQuery->toSql();
        $product = $productQuery->orderBy('product_unique_id', "ASC")->paginate($this->paginate);
        $allProduct = Product::select('id')->get();
        $stock = 1;
        $breadcrum = 'Ready Stock';
        $breadcrumUrl = route('readystock');
        return view('frontend.shop.shop', compact('product', 'allProduct', 'stock', 'breadcrum', 'breadcrumUrl'));
    }

    function subcategory($id = null)
    {
        ini_set('max_execution_time', 180); //3 minutes
        $productQuery = $this->getproducts(Auth::user()->id)
            ->join('sub_categories', 'sub_categories.id', 'products.sub_category_id');
        if ($id) {
            $decryptedSubCategoryId = decrypt($id);
            $productQuery->where('products.sub_category_id', $decryptedSubCategoryId);
        }
        $product = $productQuery->orderBy('product_unique_id', "ASC")->paginate($this->paginate);
        $allProduct = Product::select('id')->get();
        $stock = 0;
        return view('frontend.shop.shop', compact('product', 'allProduct', 'decryptedSubCategoryId', 'stock'));
    }

    // function collection($id = null)
    // {
    //     $productQuery = $this->getproducts()
    //         ->join('collections', 'collections.id', 'products.collection_id');
    //     if ($id) {
    //         $decryptedId = decrypt($id);
    //         $productQuery->where('products.collection_id',  $decryptedId);
    //     }
    //     $product = $productQuery->orderBy('id', "ASC")->paginate($this->paginate);
    //     return view('frontend.shop.shop', compact('product'));
    // }

    function productDetail($id)
    {
        $decryptedId = decrypt($id);
        $product = Product::select(
            'products.*',
            // 'collections.collection_name',
            // 'brands.brand_name',
            'metal_types.metal_name',
            // 'silver_purities.silver_purity_percentage',
            'platings.plating_name',
            'categories.category_name',
            'projects.project_name'
        )
            // ->join('brands', 'brands.id', 'products.brand_id')
            ->join('metal_types', 'metal_types.id', 'products.metal_type_id')
            // ->join('collections', 'collections.id', 'products.collection_id')
            // ->join('silver_purities', 'silver_purities.id', 'products.purity_id')
            ->join('platings', 'platings.id', 'products.plating_id')
            ->join('finishes', 'finishes.id', 'products.finish_id')
            ->join('projects', 'projects.id', 'products.project_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->where('products.id', $decryptedId)
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->first();

        // Get the Previous URL
        $previousUrl = URL::previous();
        $stock = Str::contains($previousUrl, 'readystock') ? 1 : 0;

        if ($stock == 1) {
            $relatedProducts = $this->getproducts(Auth::user()->id)->where('products.id', '!=', $decryptedId)->where('sub_collection_id', $product->sub_collection_id)->where('project_id', $product->project_id)->where('qty', '>', 0)->limit(20)->get();
        } else {
            $relatedProducts = $this->getproducts(Auth::user()->id)->where('products.id', '!=', $decryptedId)->where('sub_collection_id', $product->sub_collection_id)->where('project_id', $product->project_id)->limit(20)->get();
        }

        // dd($relatedProducts);
        //         $productImages = ProductMultipleImage::select(
        //             DB::raw('CONCAT(products.product_image, ",", GROUP_CONCAT(product_multiple_images.product_images)) as all_images')
        //         )
        //             ->leftJoin('products', 'product_multiple_images.product_id', '=', 'products.id')
        //             ->where('product_multiple_images.product_id', $decryptedId)
        //             ->groupBy('products.product_image')
        //             ->get();
        // dd($productImages);
        //         // Extracting the concatenated images into an array
        //         $allImagesArray = [];

        //         // Check if there is at least one result
        //         if ($productImages->isNotEmpty()) {
        //             $allImagesArray = explode(',', $productImages->first()->all_images);
        //         }
        $sizes = Size::where('is_active', 1)->get();
        $weights = Weight::where('is_active', 1)->get();
        // $platings = Plating::where('is_active', 1)->get();
        $colors = Color::where('is_active', 1)->whereNull('deleted_at')->get();
        $finishes = Finish::where('is_active', 1)->where('project_id', $product->project_id)->whereNull('deleted_at')->get();

        return view('frontend.shop.product_detail', compact('product', 'sizes', 'weights', 'colors', 'finishes', 'stock', 'relatedProducts'));
    }

    public function addToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingCartlist = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->first();

            $moq = Product::where('id', $request->product_id)->value('moq');
            $stock = Product::where('id', $request->product_id)->value('qty');
            if ($moq > $request->qty) {
                $notification = array(
                    'message' => 'Please Check the MINIMUM QUANTITY ORDER (moq)',
                    'alert' => 'error'
                );
                return response()->json([
                    'notification_response' => $notification
                ]);
            }
            if ($request->readyStock == 1) {
                if ($request->qty > $stock) {
                    $notification = array(
                        'message' => 'Please order within available stock limit',
                        'alert' => 'error'
                    );
                    return response()->json([
                        'notification_response' => $notification
                    ]);
                }
            }

            if ($existingCartlist) {
                if ($existingCartlist->qty >= $stock) {
                    $notification = array(
                        'message' => 'The ' . $request->qty . ' quantity already so you cant add more than ' . $stock . ' stock ',
                        'alert' => 'error'
                    );
                    return response()->json([
                        'notification_response' => $notification
                    ]);
                } else {
                    $existingCartlist->update([
                        'qty' => $existingCartlist->qty + $request->qty,
                        'is_ready_stock' => $request->readyStock
                    ]);
                    $cartcount = Cart::where('user_id', Auth::user()->id)->count();
                    $cartqtycount = Cart::where('user_id', Auth::user()->id)->sum('qty');
                    $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
                        ->join('products', 'products.id', '=', 'carts.product_id')
                        ->where('carts.user_id', Auth::user()->id)
                        ->value('totalWeight');

                    $count = array(
                        'count' => $cartcount
                    );
                    $notification = array(
                        'message' => 'Added to cart',
                        'alert' => 'success'
                    );
                }
            } else {
                Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $request->product_id,
                    'qty' => $request->qty,
                    // 'size_id' => $request->size_id,
                    'color_id' => $request->color_id,
                    'weight' => $request->weight_id,
                    'plating_id' => $request->plating_id,
                    'finish_id' => $request->finish_id,
                    'box_id' => $request->box_id,
                    'is_ready_stock' => $request->readyStock
                ]);

                $cartcount = Cart::where('user_id', Auth::user()->id)->count();
                $cartqtycount = Cart::where('user_id', Auth::user()->id)->sum('qty');
                $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->where('carts.user_id', Auth::user()->id)
                    ->value('totalWeight');

                $count = array(
                    'count' => $cartcount
                );
                $notification = array(
                    'message' => 'Added to cart',
                    'alert' => 'success'
                );
            }

            DB::commit(); // Move this above the return statement

            return response()->json([
                'count_response' => $count,
                'count_qty' => $cartqtycount,
                'count_weight' => $cartweightcount,
                'notification_response' => $notification
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function addForCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingCartlist = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->first();

            $moq = Product::where('id', $request->product_id)->value('moq');
            $stock = Product::where('id', $request->product_id)->value('qty');
            if ($moq > $request->qty) {
                $notification = array(
                    'message' => 'Please Check the MINIMUM QUANTITY ORDER (moq)',
                    'alert' => 'error'
                );
                return response()->json([
                    'notification_response' => $notification
                ]);
            }

            if ($request->stock == 1) {
                if ($request->qty > $stock) {
                    $notification = array(
                        'message' => 'Please order within available stock limit',
                        'alert' => 'error'
                    );
                    return response()->json([
                        'notification_response' => $notification
                    ]);
                }
            }
            if ($existingCartlist) {
                if ($existingCartlist->qty >= $stock && $request->stock == 1) {
                    $notification = array(
                        'message' => 'The ' . $request->qty . ' quantity already so you cant add more than ' . $stock . ' stock ',
                        'alert' => 'error'
                    );
                    return response()->json([
                        'notification_response' => $notification
                    ]);
                } else {
                    $existingCartlist->update([
                        'qty' => $existingCartlist->qty + $request->qty,
                        'is_ready_stock' => $request->stock
                    ]);
                    $cartcount = Cart::where('user_id', Auth::user()->id)->count();
                    $cartqtycount = Cart::where('user_id', Auth::user()->id)->sum('qty');
                    $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
                        ->join('products', 'products.id', '=', 'carts.product_id')
                        ->where('carts.user_id', Auth::user()->id)
                        ->value('totalWeight');

                    $count = array(
                        'count' => $cartcount
                    );
                    $notification = array(
                        'message' => 'Added to cart',
                        'alert' => 'success'
                    );
                }
            } else {
                Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $request->product_id,
                    'qty' => $request->qty,
                    'weight' => $request->weight_id,
                    // 'size_id' => $request->size_id,
                    'color_id' => $request->color_id,
                    'plating_id' => $request->plating_id,
                    'finish_id' => $request->finish_id,
                    'box_id' => $request->box,
                    'is_ready_stock' => $request->stock
                ]);

                $cartcount = Cart::where('user_id', Auth::user()->id)->count();
                $cartqtycount = Cart::where('user_id', Auth::user()->id)->sum('qty');
                $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->where('carts.user_id', Auth::user()->id)
                    ->value('totalWeight');

                $count = array(
                    'count' => $cartcount
                );
                $notification = array(
                    'message' => 'Added to cart',
                    'alert' => 'success'
                );
            }

            DB::commit(); // Move this outside of the else block

            return response()->json([
                'count_response' => $count,
                'count_qty' => $cartqtycount,
                'count_weight' => $cartweightcount,
                'notification_response' => $notification
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function addAllToCart(Request $request)
    {
        try {
            DB::beginTransaction();

            $checkedIds = $request->product_ids;
            $colorIds = $request->color_ids;
            $sizeIds = $request->size_ids;
            $weightIds = $request->weight_ids;
            $platingIds = $request->plating_ids;
            $finishIds = $request->finish_ids;
            $qtys = $request->qtys; // Corrected variable name
            $stocks = $request->stocks;
            $boxes = $request->box_ids;

            foreach ($checkedIds as $key => $productId) {
                // Check if the product is already in the cart
                $existingCartlist = Cart::where('user_id', Auth::user()->id)
                    ->where('product_id', $productId)
                    ->first();
                $productName = Product::where('id', $productId)->value('product_unique_id');
                $moq = Product::where('id', $productId)->value('moq');
                $stock = Product::where('id', $productId)->value('qty');
                if ($moq > $qtys[$key]) { // Corrected variable name
                    $notification = array(
                        'message' => 'Please Check the MINIMUM QUANTITY ORDER (moq)',
                        'alert' => 'error'
                    );
                    return response()->json([
                        'notification_response' => $notification
                    ]);
                }
                if ($stocks[$key] == 1 && $qtys[$key] > $stock) {
                    if ($request->qtys > $stock) {
                        $notification = array(
                            'message' => 'Please order within available stock limit',
                            'alert' => 'error'
                        );
                        return response()->json([
                            'notification_response' => $notification
                        ]);
                    }
                }
                if ($existingCartlist) {
                    if ($existingCartlist->qty + $qtys[$key] > $stock && $stocks[$key] == 1) {
                        $notification = array(
                            'message' => 'One of the products selected is exceeding stock limit',
                            'alert' => 'error'
                        );
                        return response()->json([
                            'notification_response' => $notification
                        ]);
                    } else {
                        $existingCartlist->update([
                            'qty' => $existingCartlist->qty + $qtys[$key], // Corrected variable name
                            'is_ready_stock' => $stocks[$key]
                        ]);
                        $cartcount = Cart::where('user_id', Auth::user()->id)->count();
                        $cartqtycount = Cart::where('user_id', Auth::user()->id)->sum('qty');
                        $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
                            ->join('products', 'products.id', '=', 'carts.product_id')
                            ->where('carts.user_id', Auth::user()->id)
                            ->value('totalWeight');

                        $count = array(
                            'count' => $cartcount
                        );
                        $notification = array(
                            'message' => 'Added to cart',
                            'alert' => 'success'
                        );
                    }
                } else {
                    // Add the product to the cart
                    Cart::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $productId,
                        'qty' => $qtys[$key], // Corrected variable name
                        // 'size_id' => $sizeIds[$key],
                        'color_id' => $colorIds[$key],
                        'plating_id' => $platingIds[$key],
                        'finish_id' => $finishIds[$key],
                        'box_id' => $boxes[$key],
                        'weight' => $weightIds[$key],
                        'is_ready_stock' => $stocks[$key]
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Get the updated cart count
            $cartCount = Cart::where('user_id', Auth::user()->id)->count();
            $cartqtycount = Cart::where('user_id', Auth::user()->id)->sum('qty');
            $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
                ->join('products', 'products.id', '=', 'carts.product_id')
                ->where('carts.user_id', Auth::user()->id)
                ->value('totalWeight');

            // Prepare the response
            $count = [
                'count' => $cartCount,
            ];

            $notification = [
                'message' => 'All products added to your cart',
                'alert' => 'success',
            ];

            return response()->json([
                'count_response' => $count,
                'count_qty' => $cartqtycount,
                'count_weight' => $cartweightcount,
                'notification_response' => $notification,
            ]);
        } catch (Exception $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function repeatOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $checkedIds = $request->product_ids;
            $finishIds = $request->finish_ids;
            $qtys = $request->qtys; // Corrected variable name
            foreach ($checkedIds as $key => $productId) {
                // Check if the product is already in the cart
                $existingCartlist = Cart::where('user_id', Auth::user()->id)
                    ->where('product_id', $productId)
                    ->first();
                $moq = Product::where('id', $productId)->value('moq');
                if ($moq > $qtys[$key]) { // Corrected variable name
                    $notification = array(
                        'message' => 'Please Check the MINIMUM QUANTITY ORDER (moq)',
                        'alert' => 'error'
                    );
                    return response()->json([
                        'notification_response' => $notification
                    ]);
                }

                if ($existingCartlist) {
                    $existingCartlist->update([
                        'qty' => $existingCartlist->qty + $qtys[$key], // Corrected variable name
                    ]);
                    $cartcount = Cart::where('user_id', Auth::user()->id)->count();

                    $count = array(
                        'count' => $cartcount
                    );
                    $notification = array(
                        'message' => 'Added to cart',
                        'alert' => 'success'
                    );
                } else {
                    // Add the product to the cart
                    Cart::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $productId,
                        'qty' => $qtys[$key],
                        'finish_id' => $finishIds[$key],
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Get the updated cart count
            $cartCount = Cart::where('user_id', Auth::user()->id)->count();

            // Prepare the response
            $count = [
                'count' => $cartCount,
            ];

            $notification = [
                'message' => 'All products added to your cart',
                'alert' => 'success',
            ];

            return response()->json([
                'count_response' => $count,
                'notification_response' => $notification,
            ]);
        } catch (Exception $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function repeatorderByid(Request $request)
    {
        $order_id = $request->order_id;
        $orderdetails = OrderDetail::select('product_id', 'qty', 'finish')->where('order_id', decrypt($order_id))->get();
        try {
            DB::beginTransaction();
            $orderdetails = OrderDetail::select('product_id', 'qty', 'finish')->where('order_id', decrypt($order_id))->get();
            foreach ($orderdetails as $key => $val) {
                $productId = $val['product_id'];
                $qty = $val['qty'];
                $finish_id = $val['finish'];
                // Check if the product is already in the cart
                $existingCartlist = Cart::where('user_id', Auth::user()->id)->where('product_id', $productId)->first();
                $moq = Product::where('id', $productId)->value('moq');
                if ($moq > $qty) { // Corrected variable name
                    $notification = array('message' => 'Please Check the MINIMUM QUANTITY ORDER (moq)', 'alert' => 'error');
                    return response()->json(['notification_response' => $notification]);
                }
                if ($existingCartlist) {
                    $existingCartlist->update(['qty' => $existingCartlist->qty + $qty,]);
                    $cartcount = Cart::where('user_id', Auth::user()->id)->count();
                    $count = array('count' => $cartcount);
                    $notification = array('message' => 'Added to cart', 'alert' => 'success');
                } else {
                    // Add the product to the cart
                    Cart::create(['user_id' => Auth::user()->id, 'product_id' => $productId, 'qty' => $qty, 'finish_id' => $finish_id,]);
                }
            }

            // Commit the transaction
            DB::commit();
            // Get the updated cart count
            $cartCount = Cart::where('user_id', Auth::user()->id)->count();
            // Prepare the response
            $count = ['count' => $cartCount,];

            $notification = ['message' => 'All products added to your cart', 'alert' => 'success',];

            return response()->json(['count_response' => $count, 'notification_response' => $notification,]);
        } catch (Exception $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array('message' => 'Something Went Wrong!', 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
    }

    // function getFilters(Request $request)
    // {
    //     $subcategory = SubCategory::where('category_id', $request->category_id)
    //         ->where('is_active', 1)
    //         ->WhereNull('deleted_at')
    //         ->get();

    //     $subcollection = SubCollection::where('collection_id', $request->collection_id)
    //         ->where('is_active', 1)
    //         ->WhereNull('deleted_at')
    //         ->get();
    //     return response()->json([
    //         'subcategory' => $subcategory,
    //         'subcollection' => $subcollection,
    //     ]);
    // }

    public function categoywiseproduct(Request $request, $id)
    {
        if (!empty($id)) {
            $categoywiseproduct = $this->getproducts(Auth::user()->id)->where('products.category_id', $id);
            if ($request->sub_category_id) {
                $categoywiseproduct = $categoywiseproduct->Where('products.sub_category_id', $request->sub_category_id);
            }
            $categoywiseproduct = $categoywiseproduct->orderBy('products.id', "ASC")
                ->paginate($this->paginate);
            return response()->json([
                'categoywiseproduct' => $categoywiseproduct
            ]);
        }
    }

    public function cateloguepreview1(Request $request)
    {
        $data = $this->cateloguepreviewdata($request);
        return view('frontend.catelogue.preview1', ['products' => $data]);
    }

    public function cateloguepreview2(Request $request)
    {
        $data = $this->cateloguepreviewdata($request);
        return view('frontend.catelogue.preview2', ['products' => $data]);
    }

    public function cateloguepreview3(Request $request)
    {
        $data = $this->cateloguepreviewdata($request);
        return view('frontend.catelogue.preview3', ['products' => $data]);
    }

    public function cateloguepreview4(Request $request)
    {
        $data = $this->cateloguepreviewdata($request);
        return view('frontend.catelogue.preview4', ['products' => $data]);
    }

    public function catelogueupload(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        // Get the file from the request
        $file = $request->file('file');

        // Open the file for reading
        $handle = fopen($file->getRealPath(), 'r');
        $dadas = [];
        // Iterate over each row in the CSV file
        $title = "";
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Process the data (e.g., save to the database)
            // $data is an array containing the values in each row
            // For example, to save to the database:
            // YourModel::create(['column1' => $data[0], 'column2' => $data[1]]);
            // $title = "";
            if ($data[0] == "Title") {
                $title = $data[1];
            } else if ($data[0] != "Title") {
                $dadas[] = $data;
            }
        }

        // Close the file
        fclose($handle);
        return view('frontend.catelogue.catelogue_upload', ['products' => $dadas, 'title' => $title]);
    }


    public function classificationwiseproduct(Request $request)
    {
        if (!empty($request->input('selectedclassification'))) {
            $selectedClassifications = $request->input('selectedclassification');
            $classificationwiseproduct = $this->getproducts(Auth::user()->id);
            $classificationIdsQuery = Product::where('project_id', $request->project_id);

            if ($selectedClassifications == "3D") {
                $classificationIdsQuery->where('product_unique_id', 'not like', '%2D%')
                    ->where('product_unique_id', 'not like', '%SC%')
                    ->where('product_unique_id', 'not like', '%SE%');
            } else {
                $classificationIdsQuery->where('product_unique_id', 'like', '%' . $selectedClassifications . '%');
            }

            $classificationIds = $classificationIdsQuery->pluck('id')->toArray();

            if (!empty($classificationIds)) {
                $classificationwiseproduct = $classificationwiseproduct->where(function ($query) use ($classificationIds) {
                    foreach ($classificationIds as $classificationId) {
                        $query->orWhere('products.id', $classificationId);
                    }
                });
            }

            $classificationwiseproduct = $classificationwiseproduct->where('project_id', Projects::SOLIDIDOL)
                ->orderBy('products.id', 'ASC')
                ->paginate($this->paginate);

            $mcChargeArray = [];
            foreach ($classificationwiseproduct as $item) {
                $weight = $item->weight; // Assuming each item in $weightrange has a 'weight' property

                // Retrieve the 'mc_charge' for the current item's weight
                $mcCharge = Weight::where('is_active', 1)
                    ->where('weight_range_from', '<=', $weight)
                    ->where('weight_range_to', '>=', $weight)
                    ->value('mc_charge');

                // Convert the 'mcCharge' to a string and extract variables
                $weightString = (string) $mcCharge;
                $variable1 = isset($weightString[0]) ? (int) $weightString[0] : null;
                $variable2 = isset($weightString[1]) ? (int) $weightString[1] : null;

                // Retrieve 'mc_code' for each variable
                $mc1 = $variable1 ? MakingCharge::where('mc_charge', $variable1)->value('mc_code') : null;
                $mc2 = $variable2 ? MakingCharge::where('mc_charge', $variable2)->value('mc_code') : '*';

                // Add the combined 'mc_code' to the array
                $mcChargeArray[] = $mc1 . $mc2;
            }

            $previousUrl = URL::previous();
            $stock = Str::contains($previousUrl, 'readystock') ? 1 : 0;
            return response()->json([
                'classificationwiseproduct' => $classificationwiseproduct,
                'mc_charge' => $mcChargeArray,
                'stock' => $stock
            ]);
        }
    }

    public function weightrange(Request $request, $id)
    {
        // dd($request->all());
        $selectedWeightRangesFrom = (array) $request->input('selectedWeightRanges');
        $selectedWeightRangesTo = (array) $request->input('weightToArray');

        // Check if arrays are not empty
        if (!empty($id) && !empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
            // Filter products based on selected weight IDs
            $weightrange = $this->getproducts(Auth::user()->id);

            if (!empty($request->category_id)) {
                $weightrange = $weightrange->where('products.category_id', $request->category_id);
            }

            if (!empty($request->project_id)) {
                $weightrange = $weightrange->where('products.project_id', $request->project_id);
            }

            if (!empty($request->subcolArray) && !empty(array_filter($request->subcolArray))) {
                $sub_id = SubCollection::whereIn('sub_collection_name', $request->subcolArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.sub_collection_id', $sub_id);
            }

            if (!empty($request->colArray) && !empty(array_filter($request->colArray))) {
                $col_id = Collection::whereIn('collection_name', $request->colArray)->pluck('id')->toArray();
                $weightrange = $weightrange->where('products.collection_id', $col_id);
            }

            if ($request->stockid == 1) {
                $weightrange = $weightrange->where('products.qty', '<>', 0);
            }

            // Combine the two arrays into a single array of ranges
            $weightRanges = array_map(function ($from, $to) {
                return ['from' => $from, 'to' => $to];
            }, $selectedWeightRangesFrom, $selectedWeightRangesTo);

            Session::put('weightranges', ['from' => $selectedWeightRangesFrom, 'to' => $selectedWeightRangesTo]);


            // Build the WHERE IN clauses dynamically
            $weightrange = $weightrange->where(function ($query) use ($weightRanges) {
                foreach ($weightRanges as $range) {
                    $query->orWhere(function ($subquery) use ($range) {
                        $subquery->where('products.weight', '>=', $range['from'])
                            ->where('products.weight', '<=', $range['to']);
                    });
                }
            });
            $weightrange = $weightrange->orderBy('products.weight', 'ASC')->orderBy('products.id', 'ASC')
                ->paginate($this->paginate);

            $mcChargeArray = [];
            foreach ($weightrange as $item) {
                $weight = $item->weight; // Assuming each item in $weightrange has a 'weight' property

                // Retrieve the 'mc_charge' for the current item's weight
                $mcCharge = Weight::where('is_active', 1)
                    ->where('weight_range_from', '<=', $weight)
                    ->where('weight_range_to', '>=', $weight)
                    ->value('mc_charge');

                // Convert the 'mcCharge' to a string and extract variables
                $weightString = (string) $mcCharge;
                $variable1 = isset($weightString[0]) ? (int) $weightString[0] : null;
                $variable2 = isset($weightString[1]) ? (int) $weightString[1] : null;

                // Retrieve 'mc_code' for each variable
                $mc1 = $variable1 ? MakingCharge::where('mc_charge', $variable1)->value('mc_code') : null;
                $mc2 = $variable2 ? MakingCharge::where('mc_charge', $variable2)->value('mc_code') : '*';

                // Add the combined 'mc_code' to the array
                $mcChargeArray[] = $mc1 . $mc2;
            }
            $previousUrl = URL::previous();
            $stock = Str::contains($previousUrl, 'readystock') ? 1 : 0;
            return response()->json([
                'weightrange' => $weightrange,
                'mc_charge' => $mcChargeArray,
                'stock' => $stock
            ]);
        } else {
            $weightrange = $this->getproducts(Auth::user()->id);
            if (!empty($request->category_id)) {
                $weightrange = $weightrange->where('products.category_id', $request->category_id);
            }
            // if (!empty($request->subcategory_id)) {
            //     $weightrange = $weightrange->where('products.sub_category_id', $request->subcategory_id);
            // }
            if (!empty($request->project_id)) {
                $weightrange = $weightrange->where('products.project_id', $request->project_id);
            }
            if (!empty($request->subcolArray) && !empty(array_filter($request->subcolArray))) {
                $sub_id = SubCollection::whereIn('sub_collection_name', $request->subcolArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.sub_collection_id', $sub_id);
            }
            if (!empty($request->colArray) && !empty(array_filter($request->colArray))) {
                $col_id = Collection::whereIn('collection_name', $request->colArray)->pluck('id')->toArray();
                $weightrange = $weightrange->where('products.collection_id', $col_id);
            }
            if ($request->stockid == 1) {
                $weightrange = $weightrange->where('products.qty', '<>', 0);
            }
            $weightrange = $weightrange->orderBy('products.id', 'ASC')
                ->paginate($this->paginate);
            $mcChargeArray = [];
            foreach ($weightrange as $item) {
                $weight = $item->weight; // Assuming each item in $weightrange has a 'weight' property

                // Retrieve the 'mc_charge' for the current item's weight
                $mcCharge = Weight::where('is_active', 1)
                    ->where('weight_range_from', '<=', $weight)
                    ->where('weight_range_to', '>=', $weight)
                    ->value('mc_charge');

                // Convert the 'mcCharge' to a string and extract variables
                $weightString = (string) $mcCharge;
                $variable1 = isset($weightString[0]) ? (int) $weightString[0] : null;
                $variable2 = isset($weightString[1]) ? (int) $weightString[1] : null;

                // Retrieve 'mc_code' for each variable
                $mc1 = $variable1 ? MakingCharge::where('mc_charge', $variable1)->value('mc_code') : null;
                $mc2 = $variable2 ? MakingCharge::where('mc_charge', $variable2)->value('mc_code') : '*';

                // Add the combined 'mc_code' to the array
                $mcChargeArray[] = $mc1 . $mc2;
            }

            $previousUrl = URL::previous();
            $stock = Str::contains($previousUrl, 'readystock') ? 1 : 0;
            return response()->json([
                'weightrange' => $weightrange,
                'mc_charge' => $mcChargeArray,
                'stock' => $stock
            ]);
        }
    }

    public function collectionwiseproduct(Request $request, $id)
    {
        $selectedCollection = $request->input('selectedcollection', []);
        $getcollectionid = Collection::whereIn('collection_name', $selectedCollection)
            ->pluck('id');

        $collectionwiseproduct = $this->getproducts(Auth::user()->id);
        Session::put('collectionwiseproduct', $getcollectionid);
        if ($getcollectionid->isNotEmpty()) {
            $collectionwiseproduct->whereIn('products.collection_id', $getcollectionid);
        }

        if ($request->stockid == 1) {
            $collectionwiseproduct = $collectionwiseproduct->where('products.qty', '<>', 0);
        }

        if (!empty($request->category_id)) {
            $collectionwiseproduct = $collectionwiseproduct->where('products.category_id', $request->category_id);
        }

        if (!empty($request->project_id)) {
            $collectionwiseproduct = $collectionwiseproduct->where('products.project_id', $request->project_id);
        }

        if (count(array_filter($request->weightfrom)) == 0 && count(array_filter($request->weightto)) == 1) {
            $selectedWeightRangesFrom = $request->input('weightfrom');
            $selectedWeightRangesTo = $request->input('weightto');

            // Ensure both arrays have elements
            if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
                $collectionwiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
                    foreach ($selectedWeightRangesFrom as $index => $from) {
                        $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
                    }
                });
            }
        }

        $collectionwiseproduct = $collectionwiseproduct->orderBy('products.id', 'ASC')->paginate($this->paginate);

        $mcChargeArray = [];
        foreach ($collectionwiseproduct as $item) {
            $weight = $item->weight; // Assuming each item in $weightrange has a 'weight' property

            // Retrieve the 'mc_charge' for the current item's weight
            $mcCharge = Weight::where('is_active', 1)
                ->where('weight_range_from', '<=', $weight)
                ->where('weight_range_to', '>=', $weight)
                ->value('mc_charge');

            // Convert the 'mcCharge' to a string and extract variables
            $weightString = (string) $mcCharge;
            $variable1 = isset($weightString[0]) ? (int) $weightString[0] : null;
            $variable2 = isset($weightString[1]) ? (int) $weightString[1] : null;

            // Retrieve 'mc_code' for each variable
            $mc1 = $variable1 ? MakingCharge::where('mc_charge', $variable1)->value('mc_code') : null;
            $mc2 = $variable2 ? MakingCharge::where('mc_charge', $variable2)->value('mc_code') : '*';

            // Add the combined 'mc_code' to the array
            $mcChargeArray[] = $mc1 . $mc2;
        }
        $previousUrl = URL::previous();
        $stock = Str::contains($previousUrl, 'readystock') ? 1 : 0;
        return response()->json([
            'collectionwiseproduct' => $collectionwiseproduct,
            'mc_charge' => $mcChargeArray,
            'stock' => $stock
        ]);
    }

    public function subcollectionwiseproduct(Request $request, $id)
    {
        $selectedSubCollection = $request->input('selectedsubcollection', []);
        $getsubcollectionid = SubCollection::whereIn('sub_collection_name', $selectedSubCollection)
            ->pluck('id');

        $subcollectionwiseproduct = $this->getproducts(Auth::user()->id);

        Session::put('selectedSubCollection', $selectedSubCollection);

        if ($getsubcollectionid->isNotEmpty()) {
            $subcollectionwiseproduct->whereIn('products.sub_collection_id', $getsubcollectionid);
        }

        if ($request->stockid == 1) {
            $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.qty', '<>', 0);
        }

        if (!empty($request->category_id)) {
            $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.category_id', $request->category_id);
        }

        if (!empty($request->project_id)) {
            $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.project_id', $request->project_id);
        }
        // dd(empty(array_filter($request->weightfrom)), count($request->weightto));
        if (count(array_filter($request->weightfrom)) == 0 && count(array_filter($request->weightto)) == 1) {
            $selectedWeightRangesFrom = $request->input('weightfrom');
            $selectedWeightRangesTo = $request->input('weightto');
            // Ensure both arrays have elements
            if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
                $subcollectionwiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
                    foreach ($selectedWeightRangesFrom as $index => $from) {
                        $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
                    }
                });
            }
        }

        $subcollectionwiseproduct = $subcollectionwiseproduct->orderBy('products.weight', 'ASC')->orderBy('products.id', 'ASC')->paginate($this->paginate);

        $mcChargeArray = [];
        foreach ($subcollectionwiseproduct as $item) {
            $weight = $item->weight; // Assuming each item in $weightrange has a 'weight' property

            // Retrieve the 'mc_charge' for the current item's weight
            $mcCharge = Weight::where('is_active', 1)
                ->where('weight_range_from', '<=', $weight)
                ->where('weight_range_to', '>=', $weight)
                ->value('mc_charge');

            // Convert the 'mcCharge' to a string and extract variables
            $weightString = (string) $mcCharge;
            $variable1 = isset($weightString[0]) ? (int) $weightString[0] : null;
            $variable2 = isset($weightString[1]) ? (int) $weightString[1] : null;

            // Retrieve 'mc_code' for each variable
            $mc1 = $variable1 ? MakingCharge::where('mc_charge', $variable1)->value('mc_code') : null;
            $mc2 = $variable2 ? MakingCharge::where('mc_charge', $variable2)->value('mc_code') : '*';

            // Add the combined 'mc_code' to the array
            $mcChargeArray[] = $mc1 . $mc2;
        }
        $previousUrl = URL::previous();
        $stock = Str::contains($previousUrl, 'readystock') ? 1 : 0;
        return response()->json([
            'subcollectionwiseproduct' => $subcollectionwiseproduct,
            'mc_charge' => $mcChargeArray,
            'stock' => $stock
        ]);
    }

    // public function cateloguepreviewdata($request)
    // {
    //     if (Session::get('collectionwiseproduct')) {

    //         $collectionwiseproduct = $this->getproducts(Auth::user()->id);

    //         $getcollectionid = Session::get('collectionwiseproduct');
    //         Session::put('collectionwiseproduct', $getcollectionid);
    //         if ($getcollectionid->isNotEmpty()) {
    //             $collectionwiseproduct->whereIn('products.collection_id', $getcollectionid);
    //         }

    //         if ($request->stockid == 1) {
    //             $collectionwiseproduct = $collectionwiseproduct->where('products.qty', '<>', 0);
    //         }

    //         if (!empty($request->category_id)) {
    //             $collectionwiseproduct = $collectionwiseproduct->where('products.category_id', $request->category_id);
    //         }

    //         if (!empty($request->project_id)) {
    //             $collectionwiseproduct = $collectionwiseproduct->where('products.project_id', $request->project_id);
    //         }


    //         if (Session::get('weightranges')) {
    //             $weightranges_ses = Session::get('weightranges');
    //             $selectedWeightRangesFrom = $weightranges_ses['from'];
    //             $selectedWeightRangesTo = $weightranges_ses['to'];
    //             if (count(array_filter($selectedWeightRangesFrom)) != 0 && count(array_filter($selectedWeightRangesTo)) != 0) {
    //                 $selectedWeightRangesFrom = $weightranges_ses['from'];
    //                 $selectedWeightRangesTo = $weightranges_ses['to'];
    //                 // Ensure both arrays have elements
    //                 if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
    //                     $collectionwiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
    //                         foreach ($selectedWeightRangesFrom as $index => $from) {
    //                             $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
    //                         }
    //                     });
    //                 }
    //             }
    //         }

    //         $collectionwiseproduct = $collectionwiseproduct->get();
    //         return $collectionwiseproduct;
    //     } else if (Session::get('selectedSubCollection')) {
    //         $selectedSubCollection = Session::get('selectedSubCollection');
    //         $getsubcollectionid = SubCollection::whereIn('sub_collection_name', $selectedSubCollection)->pluck('id');
    //         $subcollectionwiseproduct = $this->getproducts(Auth::user()->id);
    //         if ($getsubcollectionid->isNotEmpty()) {
    //             $subcollectionwiseproduct->whereIn('products.sub_collection_id', $getsubcollectionid);
    //         }
    //         if ($request->stockid == 1) {
    //             $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.qty', '<>', 0);
    //         }

    //         if (!empty($request->category_id)) {
    //             $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.category_id', $request->category_id);
    //         }

    //         if (!empty($request->project_id)) {
    //             $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.project_id', $request->project_id);
    //         }
    //         if (Session::get('weightranges')) {
    //             $weightranges_ses = Session::get('weightranges');
    //             $selectedWeightRangesFrom = $weightranges_ses['from'];
    //             $selectedWeightRangesTo = $weightranges_ses['to'];
    //             if (count(array_filter($selectedWeightRangesFrom)) != 0 && count(array_filter($selectedWeightRangesTo)) != 0) {
    //                 $selectedWeightRangesFrom = $weightranges_ses['from'];
    //                 $selectedWeightRangesTo = $weightranges_ses['to'];
    //                 // Ensure both arrays have elements
    //                 if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
    //                     $subcollectionwiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
    //                         foreach ($selectedWeightRangesFrom as $index => $from) {
    //                             $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
    //                         }
    //                     });
    //                 }
    //             }
    //         }

    //         $subcollectionwiseproduct = $subcollectionwiseproduct->get();
    //         return $subcollectionwiseproduct;
    //     } else if (Session::get('weightranges')) {
    //         $weightranges_ses = Session::get('weightranges');
    //         $selectedWeightRangesFrom = $weightranges_ses['from'];
    //         $selectedWeightRangesTo = $weightranges_ses['to'];

    //         $weightRanges = array_map(function ($from, $to) {
    //             return ['from' => $from, 'to' => $to];
    //         }, $selectedWeightRangesFrom, $selectedWeightRangesTo);

    //         $weightrange = $weightrange->where(function ($query) use ($weightRanges) {
    //             foreach ($weightRanges as $range) {
    //                 $query->orWhere(function ($subquery) use ($range) {
    //                     $subquery->where('products.weight', '>=', $range['from'])
    //                         ->where('products.weight', '<=', $range['to']);
    //                 });
    //             }
    //         });
    //         $weightrange = $weightrange->get();
    //         return $weightrange;
    //     } else {
    //         return response()->json([
    //             'selectedSubCollections' => Session::get('selectedSubCollection'),
    //             'weightranges' => Session::get('weightranges')
    //         ]);
    //     }
    // }

    public function cateloguepreviewdata($request)
    {
        if (Session::has('collectionwiseproduct')) {
            $collectionwiseproduct = $this->getproducts(Auth::user()->id);

            $getcollectionid = Session::get('collectionwiseproduct');
            if ($getcollectionid->isNotEmpty()) {
                $collectionwiseproduct->whereIn('products.collection_id', $getcollectionid);
            }

            if ($request->stockid == 1) {
                $collectionwiseproduct->where('products.qty', '<>', 0);
            }

            if (!empty($request->category_id)) {
                $collectionwiseproduct->where('products.category_id', $request->category_id);
            }

            if (!empty($request->project_id)) {
                $collectionwiseproduct->where('products.project_id', $request->project_id);
            }

            $collectionwiseproduct = $collectionwiseproduct->get();
            return $collectionwiseproduct;
        } elseif (Session::has('selectedSubCollection')) {
            $selectedSubCollection = Session::get('selectedSubCollection');
            $getsubcollectionid = SubCollection::whereIn('sub_collection_name', $selectedSubCollection)->pluck('id');
            $subcollectionwiseproduct = $this->getproducts(Auth::user()->id);
            if ($getsubcollectionid->isNotEmpty()) {
                $subcollectionwiseproduct->whereIn('products.sub_collection_id', $getsubcollectionid);
            }
            if ($request->stockid == 1) {
                $subcollectionwiseproduct->where('products.qty', '<>', 0);
            }

            if (!empty($request->category_id)) {
                $subcollectionwiseproduct->where('products.category_id', $request->category_id);
            }

            if (!empty($request->project_id)) {
                $subcollectionwiseproduct->where('products.project_id', $request->project_id);
            }

            $subcollectionwiseproduct = $subcollectionwiseproduct->get();
            return $subcollectionwiseproduct;
        } elseif (Session::has('weightranges')) {
            $weightranges_ses = Session::get('weightranges');
            $selectedWeightRangesFrom = $weightranges_ses['from'];
            $selectedWeightRangesTo = $weightranges_ses['to'];

            $weightRanges = array_map(function ($from, $to) {
                return ['from' => $from, 'to' => $to];
            }, $selectedWeightRangesFrom, $selectedWeightRangesTo);

            $weightrange = $this->getproducts(Auth::user()->id);
            $weightrange = $weightrange->where(function ($query) use ($weightRanges) {
                foreach ($weightRanges as $range) {
                    $query->orWhereBetween('products.weight', [$range['from'], $range['to']]);
                }
            })->get();
            return $weightrange;
        } else {
            return response()->json([
                'selectedSubCollections' => Session::get('selectedSubCollection'),
                'weightranges' => Session::get('weightranges')
            ]);
        }
    }
}

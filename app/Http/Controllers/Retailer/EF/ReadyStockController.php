<?php

namespace App\Http\Controllers\Retailer\EF;

use App\Enums\Projects;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Classification;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Finish;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\SilverPurity;
use App\Models\Size;
use App\Models\Style;
use App\Models\SubCollection;
use App\Models\Weight;
use App\Traits\Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;

class ReadyStockController extends Controller
{
    private $paginate = 50;
    use Common;

    function search(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180); //3 minutes
        $search = $request->search;
        $searchSubstring = substr($search, 0, 4);

        $products = $this->getproducts(Auth::user()->id)
            ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL, Projects::CASTING])
            ->where('products.qty', '>', 0)
            ->where(function ($query) use ($search) {
                $query->where('products.product_unique_id', 'like', '%' . $search . '%')
                    ->orWhere('products.product_name', 'like', '%' . $search . '%')
                    ->orWhere('products.keywordtags', 'like', '%' . $search . '%');
            })
            ->where('products.is_active', 1)
            ->orderBy('products.qty', 'DESC')
            ->get();

        if ($products->isEmpty()) {
            $product = $this->getproducts(Auth::user()->id)
                ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL, Projects::CASTING])
                ->where('products.qty', '>', 0)
                ->where(function ($query) use ($searchSubstring) {
                    $query->where('products.product_unique_id', 'like', '%' . $searchSubstring . '%')
                        ->orWhere('products.product_name', 'like', '%' . $searchSubstring . '%')
                        ->orWhere('products.keywordtags', 'like', '%' . $searchSubstring . '%');
                })
                ->where('products.is_active', 1)
                ->orderBy('products.qty', 'DESC');

            // Get all the results and filter out products without an image
            $filteredProducts = $product->get()->filter(function ($product) {
                return File::exists(public_path("upload/product/{$product->product_image}"));
            });

            // Manually paginate the filtered products
            $page = request()->get('page', 1);
            $perPage = $this->paginate;
            $paginatedProducts = new LengthAwarePaginator(
                $filteredProducts->forPage($page, $perPage),
                $filteredProducts->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $product = $paginatedProducts;
        } else {
            $product = $this->getproducts(Auth::user()->id)
                ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL, Projects::CASTING])
                ->where('products.qty', '>', 0)
                ->where(function ($query) use ($search) {
                    $query->where('products.product_unique_id', 'like', '%' . $search . '%')
                        ->orWhere('products.product_name', 'like', '%' . $search . '%')
                        ->orWhere('products.keywordtags', 'like', '%' . $search . '%');
                })
                ->where('products.is_active', 1)
                ->orderBy('products.qty', 'DESC');

            // Get all the results and filter out products without an image
            $filteredProducts = $product->get()->filter(function ($product) {
                return File::exists(public_path("upload/product/{$product->product_image}"));
            });

            // Manually paginate the filtered products
            $page = request()->get('page', 1);
            $perPage = $this->paginate;
            $paginatedProducts = new LengthAwarePaginator(
                $filteredProducts->forPage($page, $perPage),
                $filteredProducts->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $product = $paginatedProducts;
        }

        $allProduct = Product::whereIn('project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL, Projects::CASTING])->where('qty', '>', 0)->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $project_id = null;
        $request->session()->put('ret_ses', $search);

        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function efReadyStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;
        $subQuery = DB::table('products')
            ->select(DB::raw('MAX(id) as id'))
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->where('project_id', Projects::ELECTROFORMING)
            ->where('qty', '>', 0)
            ->groupBy('style_id', 'product_unique_id');

        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.qty', 'DESC');

        // Get all the results and filter out products without an image
        $filteredProducts = $product->get()->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginatedProducts;

        $project_id = Projects::ELECTROFORMING;
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->where('qty', '>', 0)->get();
        $stock = 1;
        $breadcrum = 'EF Idol Ready Stock';
        $breadcrumUrl = route('retailerefreadystock');
        $decryptedProjectId = Projects::ELECTROFORMING;
        $request->session()->forget('ret_ses');
        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function siReadyStock(Request $request)
    {
        $user_id = Auth::user()->id;
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->where('products.project_id', Projects::SOLIDIDOL)
            ->where('products.qty', '>', 0)
            ->orderBy('products.qty', 'DESC');

        // Get all the results and filter out products without an image
        $filteredProducts = $product->get()->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginatedProducts;

        $project_id = Projects::SOLIDIDOL;
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->where('qty', '>', 0)->get();
        $stock = 1;
        $breadcrum = 'Solid Idol Ready Stock';
        $breadcrumUrl = route('retailersireadystock');
        $decryptedProjectId = Projects::SOLIDIDOL;
        $request->session()->forget('ret_ses');
        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function jewelleryReadyStock(Request $request)
    {
        $user_id = Auth::user()->id;
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->where('products.project_id', Projects::CASTING)
            ->where('products.qty', '>', 0)
            ->orderBy('products.qty', 'DESC');

        // Get all the results and filter out products without an image
        $filteredProducts = $product->get()->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginatedProducts;

        $project_id = Projects::CASTING;
        $allProduct = Product::select('id')->where('project_id', Projects::CASTING)->where('qty', '>', 0)->get();
        $stock = 1;
        $breadcrum = 'Jewellery Ready Stock';
        $breadcrumUrl = route('retailerjewelleryreadystock');
        $decryptedProjectId = Projects::CASTING;
        $request->session()->forget('ret_ses');
        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function indianiaReadyStock(Request $request)
    {
        $user_id = Auth::user()->id;
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->where('products.project_id', Projects::INIDIANIA)
            ->where('products.qty', '>', 0)
            ->orderBy('products.qty', 'DESC');

        // Get all the results and filter out products without an image
        $filteredProducts = $product->get()->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginatedProducts;

        $project_id = Projects::INIDIANIA;
        $allProduct = Product::select('id')->where('project_id', Projects::INIDIANIA)->where('qty', '>', 0)->get();
        $stock = 1;
        $breadcrum = 'Indiania Ready Stock';
        $breadcrumUrl = route('retailerindianiareadystock');
        $decryptedProjectId = Projects::INIDIANIA;
        $request->session()->forget('ret_ses');
        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function utensilReadyStock(Request $request)
    {
        $user_id = Auth::user()->id;
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->where('products.project_id', Projects::UTENSIL)
            ->where('products.qty', '>', 0)
            ->orderBy('products.qty', 'DESC');

        // Get all the results and filter out products without an image
        $filteredProducts = $product->get()->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginatedProducts;

        $project_id = Projects::UTENSIL;
        $allProduct = Product::select('id')->where('project_id', Projects::UTENSIL)->where('qty', '>', 0)->get();
        $stock = 1;
        $breadcrum = 'Utensil Ready Stock';
        $breadcrumUrl = route('retailerutensilreadystock');
        $decryptedProjectId = Projects::UTENSIL;
        $request->session()->forget('ret_ses');
        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function productDetail($id)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        $decryptedId = decrypt($id);
        $product = Product::select(
            'products.*',
            'metal_types.metal_name',
            'platings.plating_name',
            'categories.category_name',
            'projects.project_name',
            'silver_purities.silver_purity_percentage'
        )
            ->join('metal_types', 'metal_types.id', 'products.metal_type_id')
            ->join('platings', 'platings.id', 'products.plating_id')
            // ->join('finishes', 'finishes.id', 'products.finish_id')
            ->join('projects', 'projects.id', 'products.project_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->join('silver_purities', 'silver_purities.id', 'products.purity_id')
            ->where('products.id', $decryptedId)
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->first();
        // dd($product);
        $stock = 1;
        $relatedProducts = $this->getproducts(Auth::user()->id)
            ->where('products.id', '!=', $decryptedId)
            ->where('category_id', $product->category_id)
            ->where('project_id', $product->project_id)
            ->where('qty', '>', 0)
            ->limit(20)
            ->get()
            ->filter(function ($product) {
                // Check if the image exists in the public/upload/product directory
                $imagePath = public_path('upload/product/' . $product->product_image);
                return file_exists($imagePath) && !empty($product->product_image);
            });
        $sizes = Size::where('is_active', 1)->get();
        $weights = Weight::where('is_active', 1)->get();
        $colors = Color::where('is_active', 1)->whereNull('deleted_at')->get();
        $finishes = Finish::where('is_active', 1)->where('project_id', $product->project_id)->whereNull('deleted_at')->get();
        $currentcartcount = Cart::where('user_id', Auth::user()->id)->where('product_id', $product->id)->value('qty');
        return view('retailer.readystock.productdetail', compact('product', 'sizes', 'weights', 'colors', 'finishes', 'stock', 'relatedProducts', 'currentcartcount'));
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
                        'message' => 'Please order within available stock limit',
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
            $currentcartcount = Cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->value('qty');
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
                if ($existingCartlist->qty + $request->qty >= $stock && $request->stock == 1) {
                    $notification = array(
                        'message' => 'Please order within available stock limit',
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
                        'count' => $cartcount,
                        'currentcartcount' => $currentcartcount
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
                if ($request->stocks[$key] == 1) {
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
                            'message' => 'Please order within available stock limit',
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

    public function weightrange(Request $request, $id)
    {
        ini_set('max_execution_time', 1800); //3 minutes
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

            if (!empty($request->classArray) && !empty(array_filter($request->classArray))) {
                $class_id = Classification::whereIn('classification_name', $request->classArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.classification_id', $class_id);
            }

            if (!empty($request->jewArray) && !empty(array_filter($request->jewArray))) {
                $cat_id = Category::whereIn('category_name', $request->jewArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.category_id', $cat_id);
            }

            if (!empty($request->colArray) && !empty(array_filter($request->colArray))) {
                $col_id = Collection::whereIn('collection_name', $request->colArray)->pluck('id')->toArray();
                $weightrange = $weightrange->where('products.collection_id', $col_id);
            }

            if (!empty($request->boxArray) && !empty(array_filter($request->boxArray))) {
                $box_id = Style::whereIn('style_name', $request->boxArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.style_id', $box_id);
            }

            if (!empty($request->purityArray) && !empty(array_filter($request->purityArray))) {
                $purity_id = SilverPurity::whereIn('silver_purity_percentage', $request->purityArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.purity_id', $purity_id);
            }

            if ($request->session()->has('ret_ses')) {
                $weightrange = $weightrange->where('products.crwsubcolcode',  'like', '%' . $request->session()->get('ret_ses') . '%');
            }

            if ($request->stockid == 1) {
                $weightrange = $weightrange->where('products.qty', '<>', 0);
            }

            // Combine the two arrays into a single array of ranges
            $weightRanges = array_map(function ($from, $to) {
                return ['from' => $from, 'to' => $to];
            }, $selectedWeightRangesFrom, $selectedWeightRangesTo);

            // Build the WHERE IN clauses dynamically
            $weightrange = $weightrange->where(function ($query) use ($weightRanges) {
                foreach ($weightRanges as $range) {
                    $query->orWhere(function ($subquery) use ($range) {
                        $subquery->where('products.weight', '>=', $range['from'])
                            ->where('products.weight', '<=', $range['to']);
                    });
                }
            });
            $weightrange = $weightrange->orderBy('products.qty', 'DESC')->get();

            // Filter out products without an image in the public/upload/product directory
            $filteredProducts = $weightrange->filter(function ($product) {
                return File::exists(public_path("upload/product/{$product->product_image}"));
            });

            // Manually paginate the filtered products
            $page = request()->get('page', 1);
            $perPage = $this->paginate;
            $paginatedProducts = new LengthAwarePaginator(
                $filteredProducts->forPage($page, $perPage),
                $filteredProducts->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $weightrange = $paginatedProducts;

            // Calculate the starting counter based on the current page
            $counter = 50 * ($page - 1);

            $box = [];
            $purity = [];
            $cart = [];
            $cartcount = [];

            // Loop through products and add values to arrays
            foreach ($weightrange as $item) {
                // Fetch the box name using the item
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                // Add the box name to the array, with the counter as the key
                $box[$counter] = $boxName;

                // Fetch the product purity
                $productPurity = SilverPurity::where('id', $item->purity_id)->value('silver_purity_percentage');

                // Add the purity value to the array, with the counter as the key
                $purity[$counter] = $productPurity;

                // Fetch the cart status for the item
                $iscart = Cart::where('user_id', Auth::user()->id)
                    ->where('product_id', $item->id)->get();

                // Add the cart status to the cart array, with the counter as the key
                $cart[$counter] = $iscart;

                // Fetch the cart count for the item
                $currentcart = Cart::where('user_id', Auth::user()->id)
                    ->where('product_id', $item->id)->value('qty');

                // Add the cart count to the cartcount array, with the counter as the key
                $cartcount[$counter] = $currentcart;

                // Increment the counter for the next iteration
                $counter++;
            }

            // Extract sub_collection_id into another variable
            $subCollectionIds = $weightrange->pluck('sub_collection_id')->toArray();

            $subCollectionData = SubCollection::whereIn('id', $subCollectionIds)->get();
            $subcollectionsjson = $subCollectionData->toJson();

            $subCollectionDefaultData = SubCollection::where('project_id', $request->project_id)->get();
            $subcollectionsDefaultjson = $subCollectionDefaultData->toJson();

            $collectionIds = $weightrange->pluck('classification_id')->toArray();

            $classificationData = Classification::whereIn('id', $collectionIds)->get();
            $classificationsjson = $classificationData->toJson();

            $classificationDefaultData = Classification::get();
            $classificationsDefaultjson = $classificationDefaultData->toJson();

            $categoryIds = $weightrange->pluck('category_id')->toArray();

            $categoryData = Category::whereIn('id', $categoryIds)->get();
            $categoryjson = $categoryData->toJson();

            $categoryDefaultData = Category::where('project_id', $request->project_id)->get();
            $categoryDefaultjson = $categoryDefaultData->toJson();

            $boxIds = $weightrange->pluck('style_id')->toArray();
            $boxData = Style::whereIn('id', $boxIds)->get();
            $boxjson = $boxData->toJson();
            $validProjects = [
                Projects::SOLIDIDOL,
                Projects::ELECTROFORMING,
                Projects::CASTING,
                Projects::UTENSIL,
                Projects::INIDIANIA,
            ];

            if (in_array($request->project_id, $validProjects)) {
                $boxDefaultData = Style::where('is_active', 1)
                    ->where('project_id', $request->project_id)
                    ->whereNull('deleted_at')
                    ->whereHas('products', function ($query) {
                        $query->where('qty', '>', 0);
                    })
                    ->get();
            }
            // $boxDefaultData = Style::where('project_id', $request->project_id)->get();
            $boxDefaultjson = $boxDefaultData->toJson();

            $ourityIds = $weightrange->pluck('purity_id')->toArray();
            $purityData = SilverPurity::whereIn('id', $ourityIds)->get();
            $purityjson = $purityData->toJson();
            $purityDefaultData = SilverPurity::get();
            $purityDefaultjson = $purityDefaultData->toJson();
            $stock = 1;
            return response()->json([
                'weightrange' => $weightrange,
                'box' => $box,
                'cart' => $cart,
                'purity' => $purity,
                'cartcount' => $cartcount,
                'stock' => $stock,
                'subcollectionsjson' => $subcollectionsjson,
                'subcollectionsDefaultjson' => $subcollectionsDefaultjson,
                'classificationsjson' => $classificationsjson,
                'classificationsDefaultjson' => $classificationsDefaultjson,
                'categoryjson' => $categoryjson,
                'categoryDefaultjson' => $categoryDefaultjson,
                'boxjson' => $boxjson,
                'boxDefaultjson' => $boxDefaultjson,
                'purityjson' => $purityjson,
                'purityDefaultjson' => $purityDefaultjson
            ]);
        } else {
            $weightrange = $this->getproducts(Auth::user()->id);
            // if (!empty($request->category_id)) {
            //     $weightrange = $weightrange->where('products.category_id', $request->category_id);
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
            if (!empty($request->jewArray) && !empty(array_filter($request->jewArray))) {
                $cat_id = Category::whereIn('category_name', $request->jewArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.category_id', $cat_id);
            }
            if ($request->stockid == 1) {
                $weightrange = $weightrange->where('products.qty', '>', 0);
            }

            if (!empty($request->classArray) && !empty(array_filter($request->classArray))) {
                $class_id = Classification::whereIn('classification_name', $request->classArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.classification_id', $class_id);
            }

            if (!empty($request->boxArray) && !empty(array_filter($request->boxArray))) {
                $box_id = Style::whereIn('style_name', $request->boxArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.style_id', $box_id);
            }

            if (!empty($request->purityArray) && !empty(array_filter($request->purityArray))) {
                $purity_id = SilverPurity::whereIn('silver_purity_percentage', $request->purityArray)->pluck('id')->toArray();
                $weightrange = $weightrange->whereIn('products.purity_id', $purity_id);
            }

            if ($request->session()->has('ret_ses')) {
                $weightrange = $weightrange->where('products.crwsubcolcode',  'like', '%' . $request->session()->get('ret_ses') . '%');
            }

            $weightrange = $weightrange->orderBy('products.qty', 'DESC')->get();

            // Filter out products without an image in the public/upload/product directory
            $filteredProducts = $weightrange->filter(function ($product) {
                return File::exists(public_path("upload/product/{$product->product_image}"));
            });

            // Manually paginate the filtered products
            $page = request()->get('page', 1);
            $perPage = $this->paginate;
            $paginatedProducts = new LengthAwarePaginator(
                $filteredProducts->forPage($page, $perPage),
                $filteredProducts->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $weightrange = $paginatedProducts;

            // Calculate the starting counter based on the current page
            $counter = 50 * ($page - 1);

            $box = [];
            $purity = [];
            $cart = [];
            $cartcount = [];

            // Loop through products and add values to arrays
            foreach ($weightrange as $item) {
                // Fetch the box name using the item
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                // Add the box name to the array, with the counter as the key
                $box[$counter] = $boxName;

                // Fetch the product purity
                $productPurity = SilverPurity::where('id', $item->purity_id)->value('silver_purity_percentage');

                // Add the purity value to the array, with the counter as the key
                $purity[$counter] = $productPurity;

                // Fetch the cart status for the item
                $iscart = Cart::where('user_id', Auth::user()->id)
                    ->where('product_id', $item->id)->get();

                // Add the cart status to the cart array, with the counter as the key
                $cart[$counter] = $iscart;

                // Fetch the cart count for the item
                $currentcart = Cart::where('user_id', Auth::user()->id)
                    ->where('product_id', $item->id)->value('qty');

                // Add the cart count to the cartcount array, with the counter as the key
                $cartcount[$counter] = $currentcart;

                // Increment the counter for the next iteration
                $counter++;
            }
            // Extract sub_collection_id into another variable
            $subCollectionIds = $weightrange->pluck('sub_collection_id')->toArray();

            $subCollectionData = SubCollection::whereIn('id', $subCollectionIds)->get();
            $subcollectionsjson = $subCollectionData->toJson();

            $subCollectionDefaultData = SubCollection::where('project_id', $request->project_id)->get();
            $subcollectionsDefaultjson = $subCollectionDefaultData->toJson();

            $collectionIds = $weightrange->pluck('classification_id')->toArray();

            $classificationData = Classification::whereIn('id', $collectionIds)->get();
            $classificationsjson = $classificationData->toJson();

            $classificationDefaultData = Classification::get();
            $classificationsDefaultjson = $classificationDefaultData->toJson();

            $categoryIds = $weightrange->pluck('category_id')->toArray();

            $categoryData = Category::whereIn('id', $categoryIds)->get();
            $categoryjson = $categoryData->toJson();

            $categoryDefaultData = Category::where('project_id', $request->project_id)->get();
            $categoryDefaultjson = $categoryDefaultData->toJson();

            $boxIds = $weightrange->pluck('style_id')->toArray();
            $boxData = Style::whereIn('id', $boxIds)->get();
            $boxjson = $boxData->toJson();
            $validProjects = [
                Projects::SOLIDIDOL,
                Projects::ELECTROFORMING,
                Projects::CASTING,
                Projects::UTENSIL,
                Projects::INIDIANIA,
            ];

            if (in_array($request->project_id, $validProjects)) {
                $boxDefaultData = Style::where('is_active', 1)
                    ->where('project_id', $request->project_id)
                    ->whereNull('deleted_at')
                    ->whereHas('products', function ($query) {
                        $query->where('qty', '>', 0);
                    })
                    ->get();
            }
            // $boxDefaultData = Style::get();
            $boxDefaultjson = $boxDefaultData->toJson();

            $ourityIds = $weightrange->pluck('purity_id')->toArray();
            $purityData = SilverPurity::whereIn('id', $ourityIds)->get();
            $purityjson = $purityData->toJson();
            $purityDefaultData = SilverPurity::get();
            $purityDefaultjson = $purityDefaultData->toJson();

            $stock = 1;
            return response()->json([
                'weightrange' => $weightrange,
                'box' => $box,
                'cart' => $cart,
                'purity' => $purity,
                'cartcount' => $cartcount,
                'stock' => $stock,
                'subcollectionsjson' => $subcollectionsjson,
                'subcollectionsDefaultjson' => $subcollectionsDefaultjson,
                'classificationsjson' => $classificationsjson,
                'classificationsDefaultjson' => $classificationsDefaultjson,
                'categoryjson' => $categoryjson,
                'categoryDefaultjson' => $categoryDefaultjson,
                'boxjson' => $boxjson,
                'boxDefaultjson' => $boxDefaultjson,
                'purityjson' => $purityjson,
                'purityDefaultjson' => $purityDefaultjson
            ]);
        }
    }

    public function classificationwiseproduct(Request $request)
    {
        ini_set('max_execution_time', 180); //3 minutes
        $selectedClassifications = $request->input('selectedclassification', []);
        $getclassificationid = Classification::whereIn('classification_name', $selectedClassifications)
            ->pluck('id');
        $classificationwiseproduct = $this->getproducts(Auth::user()->id);

        if ($getclassificationid->isNotEmpty()) {
            $classificationwiseproduct->whereIn('products.classification_id', $getclassificationid);
        }

        if (!empty($request->project_id)) {
            $classificationwiseproduct = $classificationwiseproduct->where('products.project_id', $request->project_id);
        }

        if (!empty($request->subcollection_id)) {
            $sub_id = SubCollection::whereIn('sub_collection_name', [$request->subcollection_id])->pluck('id')->toArray();
            $classificationwiseproduct = $classificationwiseproduct->whereIn('products.sub_collection_id', $sub_id);
        }

        if (!empty($request->boxArray) && !empty(array_filter($request->boxArray))) {
            $box_id = Style::whereIn('style_name', $request->boxArray)->pluck('id')->toArray();
            $classificationwiseproduct = $classificationwiseproduct->whereIn('products.style_id', $box_id);
        }

        if (!empty($request->purityArray) && !empty(array_filter($request->purityArray))) {
            $purity_id = SilverPurity::whereIn('silver_purity_percentage', $request->purityArray)->pluck('id')->toArray();
            $classificationwiseproduct = $classificationwiseproduct->whereIn('products.purity_id', $purity_id);
        }

        if ($request->stockid == 1) {
            $classificationwiseproduct = $classificationwiseproduct->where('products.qty', '>', 0);
        }

        $selectedWeightRangesFrom = $request->input('weightfrom', []);
        $selectedWeightRangesTo = $request->input('weightto', []);
        if (!empty(array_filter($selectedWeightRangesFrom)) && !empty(array_filter($selectedWeightRangesTo))) {
            // Ensure both arrays have elements
            if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
                $classificationwiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
                    foreach ($selectedWeightRangesFrom as $index => $from) {
                        $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
                    }
                });
            }
        }

        // Clone the query to calculate the min and max weight before paginating
        $weightQuery = clone $classificationwiseproduct;
        $minWeight = $weightQuery->min('products.weight');
        $maxWeight = $weightQuery->max('products.weight');

        $classificationwiseproduct = $classificationwiseproduct
            ->orderBy('products.qty', 'DESC')->get();

        // Filter out products without an image in the public/upload/product directory
        $filteredProducts = $classificationwiseproduct->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $classificationwiseproduct = $paginatedProducts;


        // Assuming $minWeight and $maxWeight are already defined
        if ($maxWeight < 5) {
            // Get only the record with id=1
            $matchingWeights = Weight::where('id', 1)
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->pluck('id')
                ->toArray();
        } else {
            // Get weights that match minWeight and maxWeight
            $matchingWeights = Weight::where('is_active', 1)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($minWeight, $maxWeight) {
                    $query->whereBetween('weight_range_from', [$minWeight, $maxWeight])
                        ->orWhereBetween('weight_range_to', [$minWeight, $maxWeight]);
                })
                ->pluck('id')
                ->toArray();
        }

        $weights = Weight::whereIn('id', $matchingWeights)->where('is_active', 1)->whereNull('deleted_at')->get();
        $weightJson = $weights->toJson();

        $defaultweights = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        $defaultweightJson = $defaultweights->toJson();


        // Extract sub_collection_id into another variable
        $subCollectionIds = $classificationwiseproduct->pluck('sub_collection_id')->toArray();

        $subCollectionData = SubCollection::whereIn('id', $subCollectionIds)->get();
        $subcollectionsjson = $subCollectionData->toJson();

        $subCollectionDefaultData = SubCollection::where('project_id', $request->project_id)->get();
        $subcollectionsDefaultjson = $subCollectionDefaultData->toJson();

        $boxIds = $classificationwiseproduct->pluck('style_id')->toArray();
        $boxData = Style::whereIn('id', $boxIds)->get();
        $boxjson = $boxData->toJson();
        $validProjects = [
            Projects::SOLIDIDOL,
            Projects::ELECTROFORMING,
            Projects::CASTING,
            Projects::UTENSIL,
            Projects::INIDIANIA,
        ];
        if (in_array($request->project_id, $validProjects)) {
            $boxDefaultData = Style::where('is_active', 1)
                ->where('project_id', $request->project_id)
                ->whereNull('deleted_at')
                ->whereHas('products', function ($query) {
                    $query->where('qty', '>', 0);
                })
                ->get();
        }
        // $boxDefaultData = Style::get();
        $boxDefaultjson = $boxDefaultData->toJson();
        $ourityIds = $classificationwiseproduct->pluck('purity_id')->toArray();
        $purityData = SilverPurity::whereIn('id', $ourityIds)->get();
        $purityjson = $purityData->toJson();
        $purityDefaultData = SilverPurity::get();
        $purityDefaultjson = $purityDefaultData->toJson();

        // Calculate the starting counter based on the current page
        $counter = 50 * ($page - 1);

        $box = [];
        $purity = [];
        $cart = [];
        $cartcount = [];

        // Loop through products and add values to arrays
        foreach ($classificationwiseproduct as $item) {
            // Fetch the box name using the item
            $boxName = Style::where('id', $item->style_id)
                ->where('is_active', 1)
                ->value('style_name');

            // Add the box name to the array, with the counter as the key
            $box[$counter] = $boxName;

            // Fetch the product purity
            $productPurity = SilverPurity::where('id', $item->purity_id)->value('silver_purity_percentage');

            // Add the purity value to the array, with the counter as the key
            $purity[$counter] = $productPurity;

            // Fetch the cart status for the item
            $iscart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->get();

            // Add the cart status to the cart array, with the counter as the key
            $cart[$counter] = $iscart;

            // Fetch the cart count for the item
            $currentcart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->value('qty');

            // Add the cart count to the cartcount array, with the counter as the key
            $cartcount[$counter] = $currentcart;

            // Increment the counter for the next iteration
            $counter++;
        }

        $stock = 1;
        return response()->json([
            'classificationwiseproduct' => $classificationwiseproduct,
            'box' => $box,
            'cart' => $cart,
            'purity' => $purity,
            'boxjson' => $boxjson,
            'boxDefaultjson' => $boxDefaultjson,
            'purityjson' => $purityjson,
            'purityDefaultjson' => $purityDefaultjson,
            'cartcount' => $cartcount,
            'stock' => $stock,
            'subcollectionsjson' => $subcollectionsjson,
            'subcollectionsDefaultjson' => $subcollectionsDefaultjson,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson
        ]);
    }

    public function collectionwiseproduct(Request $request, $id)
    {
        $selectedCollection = $request->input('selectedcollection', []);
        $getcollectionid = Collection::whereIn('collection_name', $selectedCollection)
            ->pluck('id');

        $collectionwiseproduct = $this->getproducts(Auth::user()->id);
        Session::put('collectionwiseproduct', $getcollectionid);
        if ($getcollectionid->isNotEmpty()) {
            $collectionwiseproduct = $collectionwiseproduct->whereIn('products.collection_id', $getcollectionid);
        }

        if ($request->stockid == 1) {
            $collectionwiseproduct = $collectionwiseproduct->where('products.qty', '>', 0);
        }

        // if (!empty($request->category_id)) {
        //     $collectionwiseproduct = $collectionwiseproduct->where('products.category_id', $request->category_id);
        // }
        if (!empty($request->boxArray) && !empty(array_filter($request->boxArray))) {
            $box_id = Style::whereIn('style_name', $request->boxArray)->pluck('id')->toArray();
            $collectionwiseproduct = $collectionwiseproduct->whereIn('products.style_id', $box_id);
        }

        if (!empty($request->purityArray) && !empty(array_filter($request->purityArray))) {
            $purity_id = SilverPurity::whereIn('silver_purity_percentage', $request->purityArray)->pluck('id')->toArray();
            $collectionwiseproduct = $collectionwiseproduct->whereIn('products.purity_id', $purity_id);
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

        // Clone the query to calculate the min and max weight before paginating
        $weightQuery = clone $collectionwiseproduct;
        $minWeight = $weightQuery->min('products.weight');
        $maxWeight = $weightQuery->max('products.weight');

        $collectionwiseproduct = $collectionwiseproduct
            ->orderBy('products.qty', 'DESC')->get();

        // Filter out products without an image in the public/upload/product directory
        $filteredProducts = $collectionwiseproduct->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $collectionwiseproduct = $paginatedProducts;

        // Assuming $minWeight and $maxWeight are already defined
        if ($maxWeight < 5) {
            // Get only the record with id=1
            $matchingWeights = Weight::where('id', 1)
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->pluck('id')
                ->toArray();
        } else {
            // Get weights that match minWeight and maxWeight
            $matchingWeights = Weight::where('is_active', 1)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($minWeight, $maxWeight) {
                    $query->whereBetween('weight_range_from', [$minWeight, $maxWeight])
                        ->orWhereBetween('weight_range_to', [$minWeight, $maxWeight]);
                })
                ->pluck('id')
                ->toArray();
        }

        $weights = Weight::whereIn('id', $matchingWeights)->where('is_active', 1)->whereNull('deleted_at')->get();
        $weightJson = $weights->toJson();

        $defaultweights = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        $defaultweightJson = $defaultweights->toJson();
        $boxIds = $collectionwiseproduct->pluck('style_id')->toArray();
        $boxData = Style::whereIn('id', $boxIds)->get();
        $boxjson = $boxData->toJson();
        $validProjects = [
            Projects::SOLIDIDOL,
            Projects::ELECTROFORMING,
            Projects::CASTING,
            Projects::UTENSIL,
            Projects::INIDIANIA,
        ];
        if (in_array($request->project_id, $validProjects)) {
            $boxDefaultData = Style::where('is_active', 1)
                ->where('project_id', $request->project_id)
                ->whereNull('deleted_at')
                ->whereHas('products', function ($query) {
                    $query->where('qty', '>', 0);
                })
                ->get();
        }
        // $boxDefaultData = Style::get();
        $boxDefaultjson = $boxDefaultData->toJson();
        $ourityIds = $collectionwiseproduct->pluck('purity_id')->toArray();
        $purityData = SilverPurity::whereIn('id', $ourityIds)->get();
        $purityjson = $purityData->toJson();
        $purityDefaultData = SilverPurity::get();
        $purityDefaultjson = $purityDefaultData->toJson();

        // Calculate the starting counter based on the current page
        $counter = 50 * ($page - 1);

        $box = [];
        $purity = [];
        $cart = [];
        $cartcount = [];

        // Loop through products and add values to arrays
        foreach ($collectionwiseproduct as $item) {
            // Fetch the box name using the item
            $boxName = Style::where('id', $item->style_id)
                ->where('is_active', 1)
                ->value('style_name');

            // Add the box name to the array, with the counter as the key
            $box[$counter] = $boxName;

            // Fetch the product purity
            $productPurity = SilverPurity::where('id', $item->purity_id)->value('silver_purity_percentage');

            // Add the purity value to the array, with the counter as the key
            $purity[$counter] = $productPurity;

            // Fetch the cart status for the item
            $iscart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->get();

            // Add the cart status to the cart array, with the counter as the key
            $cart[$counter] = $iscart;

            // Fetch the cart count for the item
            $currentcart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->value('qty');

            // Add the cart count to the cartcount array, with the counter as the key
            $cartcount[$counter] = $currentcart;

            // Increment the counter for the next iteration
            $counter++;
        }

        $stock = 1;
        return response()->json([
            'collectionwiseproduct' => $collectionwiseproduct,
            'box' => $box,
            'cart' => $cart,
            'purity' => $purity,
            'boxjson' => $boxjson,
            'boxDefaultjson' => $boxDefaultjson,
            'purityjson' => $purityjson,
            'purityDefaultjson' => $purityDefaultjson,
            'cartcount' => $cartcount,
            'stock' => $stock,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson
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
            $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.qty', '>', 0);
        }

        if (!empty($request->boxArray) && !empty(array_filter($request->boxArray))) {
            $box_id = Style::whereIn('style_name', $request->boxArray)->pluck('id')->toArray();
            $subcollectionwiseproduct = $subcollectionwiseproduct->whereIn('products.style_id', $box_id);
        }

        if (!empty($request->purityArray) && !empty(array_filter($request->purityArray))) {
            $purity_id = SilverPurity::whereIn('silver_purity_percentage', $request->purityArray)->pluck('id')->toArray();
            $subcollectionwiseproduct = $subcollectionwiseproduct->whereIn('products.purity_id', $purity_id);
        }

        // Ensure classification_id is treated as an array
        $classifications = (array) $request->input('classification_id', []);
        if (!empty($classifications) && !empty(array_filter($classifications))) {
            $class_id = Classification::whereIn('classification_name', $classifications)->pluck('id')->toArray();
            $subcollectionwiseproduct = $subcollectionwiseproduct->whereIn('products.classification_id', $class_id);
        }

        if (!empty($request->project_id)) {
            $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.project_id', $request->project_id);
        }
        // dd(empty(array_filter($request->weightfrom)), count($request->weightto));
        if (count(array_filter($request->weightfrom)) > 0 && count(array_filter($request->weightto)) > 0) {
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

        // Clone the query to calculate the min and max weight before paginating
        $weightQuery = clone $subcollectionwiseproduct;
        $minWeight = $weightQuery->min('products.weight');
        $maxWeight = $weightQuery->max('products.weight');

        $subcollectionwiseproduct = $subcollectionwiseproduct
            ->orderBy('products.qty', 'DESC')->get();

        // Filter out products without an image in the public/upload/product directory
        $filteredProducts = $subcollectionwiseproduct->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $subcollectionwiseproduct = $paginatedProducts;

        // Assuming $minWeight and $maxWeight are already defined
        if ($maxWeight < 5) {
            // Get only the record with id=1
            $matchingWeights = Weight::where('id', 1)
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->pluck('id')
                ->toArray();
        } else {
            // Get weights that match minWeight and maxWeight
            $matchingWeights = Weight::where('is_active', 1)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($minWeight, $maxWeight) {
                    $query->whereBetween('weight_range_from', [$minWeight, $maxWeight])
                        ->orWhereBetween('weight_range_to', [$minWeight, $maxWeight]);
                })
                ->pluck('id')
                ->toArray();
        }
        // Check if matchingWeights is empty
        if (empty($matchingWeights)) {
            // Use minWeight for comparison
            $weights = Weight::where('is_active', 1)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($minWeight) {
                    $query->where('weight_range_from', '<=', $minWeight)
                        ->where('weight_range_to', '>=', $minWeight);
                })
                ->get();
        } else {
            $weights = Weight::whereIn('id', $matchingWeights)->where('is_active', 1)->whereNull('deleted_at')->get();
        }

        $weightJson = $weights->toJson();

        $defaultweights = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        $defaultweightJson = $defaultweights->toJson();

        $collectionIds = $subcollectionwiseproduct->pluck('classification_id')->toArray();

        $classificationData = Classification::whereIn('id', $collectionIds)->get();
        $classificationsjson = $classificationData->toJson();

        $classificationDefaultData = Classification::get();
        $classificationsDefaultjson = $classificationDefaultData->toJson();
        $boxIds = $subcollectionwiseproduct->pluck('style_id')->toArray();
        $boxData = Style::whereIn('id', $boxIds)->get();
        $boxjson = $boxData->toJson();
        $validProjects = [
            Projects::SOLIDIDOL,
            Projects::ELECTROFORMING,
            Projects::CASTING,
            Projects::UTENSIL,
            Projects::INIDIANIA,
        ];
        if (in_array($request->project_id, $validProjects)) {
            $boxDefaultData = Style::where('is_active', 1)
                ->where('project_id', $request->project_id)
                ->whereNull('deleted_at')
                ->whereHas('products', function ($query) {
                    $query->where('qty', '>', 0);
                })
                ->get();
        }
        // $boxDefaultData = Style::get();
        $boxDefaultjson = $boxDefaultData->toJson();
        $ourityIds = $subcollectionwiseproduct->pluck('purity_id')->toArray();
        $purityData = SilverPurity::whereIn('id', $ourityIds)->get();
        $purityjson = $purityData->toJson();
        $purityDefaultData = SilverPurity::get();
        $purityDefaultjson = $purityDefaultData->toJson();

        // Calculate the starting counter based on the current page
        $counter = 50 * ($page - 1);

        $box = [];
        $purity = [];
        $cart = [];
        $cartcount = [];

        // Loop through products and add values to arrays
        foreach ($subcollectionwiseproduct as $item) {
            // Fetch the box name using the item
            $boxName = Style::where('id', $item->style_id)
                ->where('is_active', 1)
                ->value('style_name');

            // Add the box name to the array, with the counter as the key
            $box[$counter] = $boxName;

            // Fetch the product purity
            $productPurity = SilverPurity::where('id', $item->purity_id)->value('silver_purity_percentage');

            // Add the purity value to the array, with the counter as the key
            $purity[$counter] = $productPurity;

            // Fetch the cart status for the item
            $iscart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->get();

            // Add the cart status to the cart array, with the counter as the key
            $cart[$counter] = $iscart;

            // Fetch the cart count for the item
            $currentcart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->value('qty');

            // Add the cart count to the cartcount array, with the counter as the key
            $cartcount[$counter] = $currentcart;

            // Increment the counter for the next iteration
            $counter++;
        }

        $stock = 1;
        return response()->json([
            'subcollectionwiseproduct' => $subcollectionwiseproduct,
            'box' => $box,
            'cart' => $cart,
            'purity' => $purity,
            'cartcount' => $cartcount,
            'stock' => $stock,
            'boxjson' => $boxjson,
            'boxDefaultjson' => $boxDefaultjson,
            'purityjson' => $purityjson,
            'purityDefaultjson' => $purityDefaultjson,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson,
            'classificationsjson' => $classificationsjson,
            'classificationsDefaultjson' => $classificationsDefaultjson
        ]);
    }

    public function categorywiseproduct(Request $request, $id)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        $selectedCategory = $request->input('selectedcategory', []);
        $getcategoryid = Category::whereIn('category_name', $selectedCategory)
            ->pluck('id');

        $categorywiseproduct = $this->getproducts(Auth::user()->id);
        Session::put('collectionwiseproduct', $getcategoryid);
        if ($getcategoryid->isNotEmpty()) {
            $categorywiseproduct = $categorywiseproduct->whereIn('products.category_id', $getcategoryid);
        }

        if ($request->stockid == 1) {
            $categorywiseproduct = $categorywiseproduct->where('products.qty', '>', 0);
        }

        // if (!empty($request->category_id)) {
        //     $collectionwiseproduct = $collectionwiseproduct->where('products.category_id', $request->category_id);
        // }

        if (!empty($request->project_id)) {
            $categorywiseproduct = $categorywiseproduct->where('products.project_id', $request->project_id);
        }

        if (!empty($request->boxArray) && !empty(array_filter($request->boxArray))) {
            $box_id = Style::whereIn('style_name', $request->boxArray)->pluck('id')->toArray();
            $categorywiseproduct = $categorywiseproduct->whereIn('products.style_id', $box_id);
        }

        if (!empty($request->purityArray) && !empty(array_filter($request->purityArray))) {
            $purity_id = SilverPurity::whereIn('silver_purity_percentage', $request->purityArray)->pluck('id')->toArray();
            $categorywiseproduct = $categorywiseproduct->whereIn('products.purity_id', $purity_id);
        }

        if (count(array_filter($request->weightfrom)) > 0 && count(array_filter($request->weightto)) > 0) {
            $selectedWeightRangesFrom = $request->input('weightfrom');
            $selectedWeightRangesTo = $request->input('weightto');

            // Ensure both arrays have elements
            if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
                $categorywiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
                    foreach ($selectedWeightRangesFrom as $index => $from) {
                        $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
                    }
                });
            }
        }

        // // Clone the query to calculate the min and max weight before paginating
        // $weightQuery = clone $categorywiseproduct;
        // $minWeight = $weightQuery->min('products.weight');
        // $maxWeight = $weightQuery->max('products.weight');

        $categorywiseproduct = $categorywiseproduct
            ->orderBy('products.qty', 'DESC')->get();

        // Filter out products without an image in the public/upload/product directory
        $filteredProducts = $categorywiseproduct->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $categorywiseproduct = $paginatedProducts;

        // // Assuming $minWeight and $maxWeight are already defined
        // if ($maxWeight < 5) {
        //     // Get only the record with id=1
        //     $matchingWeights = Weight::where('id', 1)
        //         ->where('is_active', 1)
        //         ->whereNull('deleted_at')
        //         ->pluck('id')
        //         ->toArray();
        // } else {
        //     // Get weights that match minWeight and maxWeight
        //     $matchingWeights = Weight::where('is_active', 1)
        //         ->whereNull('deleted_at')
        //         ->where(function ($query) use ($minWeight, $maxWeight) {
        //             $query->whereBetween('weight_range_from', [$minWeight, $maxWeight])
        //                 ->orWhereBetween('weight_range_to', [$minWeight, $maxWeight]);
        //         })
        //         ->pluck('id')
        //         ->toArray();
        // }

        // $weights = Weight::whereIn('id', $matchingWeights)->where('is_active', 1)->whereNull('deleted_at')->get();
        // $weightJson = $weights->toJson();

        // $defaultweights = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        // $defaultweightJson = $defaultweights->toJson();

        $boxIds = $categorywiseproduct->pluck('style_id')->toArray();
        $boxData = Style::whereIn('id', $boxIds)->get();
        $boxjson = $boxData->toJson();
        $validProjects = [
            Projects::SOLIDIDOL,
            Projects::ELECTROFORMING,
            Projects::CASTING,
            Projects::UTENSIL,
            Projects::INIDIANIA,
        ];
        if (in_array($request->project_id, $validProjects)) {
            $boxDefaultData = Style::where('is_active', 1)
                ->where('project_id', $request->project_id)
                ->whereNull('deleted_at')
                ->whereHas('products', function ($query) {
                    $query->where('qty', '>', 0);
                })
                ->get();
        }
        // $boxDefaultData = Style::get();
        $boxDefaultjson = $boxDefaultData->toJson();
        $ourityIds = $categorywiseproduct->pluck('purity_id')->toArray();
        $purityData = SilverPurity::whereIn('id', $ourityIds)->get();
        $purityjson = $purityData->toJson();
        $purityDefaultData = SilverPurity::get();
        $purityDefaultjson = $purityDefaultData->toJson();
        // Calculate the starting counter based on the current page
        $counter = 50 * ($page - 1);

        $box = [];
        $purity = [];
        $cart = [];
        $cartcount = [];

        // Loop through products and add values to arrays
        foreach ($categorywiseproduct as $item) {
            // Fetch the box name using the item
            $boxName = Style::where('id', $item->style_id)
                ->where('is_active', 1)
                ->value('style_name');

            // Add the box name to the array, with the counter as the key
            $box[$counter] = $boxName;

            // Fetch the product purity
            $productPurity = SilverPurity::where('id', $item->purity_id)->value('silver_purity_percentage');

            // Add the purity value to the array, with the counter as the key
            $purity[$counter] = $productPurity;

            // Fetch the cart status for the item
            $iscart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->get();

            // Add the cart status to the cart array, with the counter as the key
            $cart[$counter] = $iscart;

            // Fetch the cart count for the item
            $currentcart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->value('qty');

            // Add the cart count to the cartcount array, with the counter as the key
            $cartcount[$counter] = $currentcart;

            // Increment the counter for the next iteration
            $counter++;
        }

        $stock = 1;
        return response()->json([
            'categorywiseproduct' => $categorywiseproduct,
            'box' => $box,
            'cart' => $cart,
            'purity' => $purity,
            'cartcount' => $cartcount,
            'stock' => $stock,
            'boxjson' => $boxjson,
            'boxDefaultjson' => $boxDefaultjson,
            'purityjson' => $purityjson,
            'purityDefaultjson' => $purityDefaultjson,
            // 'weightJson' => $weightJson,
            // 'defaultweightJson' => $defaultweightJson
        ]);
    }

    public function getBoxwiseProduct(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        $selectedBox = $request->input('selectedbox', []);
        $getboxid = Style::whereIn('style_name', $selectedBox)
            ->pluck('id');

        $boxwiseproduct = $this->getproducts(Auth::user()->id);

        Session::put('selectedBox', $selectedBox);

        if ($getboxid->isNotEmpty()) {
            $boxwiseproduct->whereIn('products.style_id', $getboxid);
        }

        if ($request->stockid == 1) {
            $boxwiseproduct = $boxwiseproduct->where('products.qty', '>', 0);
        }

        // Ensure classification_id is treated as an array
        $classifications = (array) $request->input('classification_id', []);
        if (!empty($classifications) && !empty(array_filter($classifications))) {
            $class_id = Classification::whereIn('classification_name', $classifications)->pluck('id')->toArray();
            $boxwiseproduct = $boxwiseproduct->whereIn('products.classification_id', $class_id);
        }

        if (!empty($request->project_id)) {
            $boxwiseproduct = $boxwiseproduct->where('products.project_id', $request->project_id);
        }
        // dd(empty(array_filter($request->weightfrom)), count($request->weightto));
        if (count(array_filter($request->weightfrom)) > 0 && count(array_filter($request->weightto)) > 0) {
            $selectedWeightRangesFrom = $request->input('weightfrom');
            $selectedWeightRangesTo = $request->input('weightto');
            // Ensure both arrays have elements
            if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
                $boxwiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
                    foreach ($selectedWeightRangesFrom as $index => $from) {
                        $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
                    }
                });
            }
        }

        // Clone the query to calculate the min and max weight before paginating
        $weightQuery = clone $boxwiseproduct;
        $minWeight = $weightQuery->min('products.weight');
        $maxWeight = $weightQuery->max('products.weight');

        $boxwiseproduct = $boxwiseproduct
            ->orderBy('products.qty', 'DESC')->get();

        // Filter out products without an image in the public/upload/product directory
        $filteredProducts = $boxwiseproduct->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $boxwiseproduct = $paginatedProducts;

        // Assuming $minWeight and $maxWeight are already defined
        if ($maxWeight < 5) {
            // Get only the record with id=1
            $matchingWeights = Weight::where('id', 1)
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->pluck('id')
                ->toArray();
        } else {
            // Get weights that match minWeight and maxWeight
            $matchingWeights = Weight::where('is_active', 1)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($minWeight, $maxWeight) {
                    $query->whereBetween('weight_range_from', [$minWeight, $maxWeight])
                        ->orWhereBetween('weight_range_to', [$minWeight, $maxWeight]);
                })
                ->pluck('id')
                ->toArray();
        }
        // Check if matchingWeights is empty
        if (empty($matchingWeights)) {
            // Use minWeight for comparison
            $weights = Weight::where('is_active', 1)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($minWeight) {
                    $query->where('weight_range_from', '<=', $minWeight)
                        ->where('weight_range_to', '>=', $minWeight);
                })
                ->get();
        } else {
            $weights = Weight::whereIn('id', $matchingWeights)->where('is_active', 1)->whereNull('deleted_at')->get();
        }

        $weightJson = $weights->toJson();

        $defaultweights = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        $defaultweightJson = $defaultweights->toJson();

        $collectionIds = $boxwiseproduct->pluck('classification_id')->toArray();

        $classificationData = Classification::whereIn('id', $collectionIds)->get();
        $classificationsjson = $classificationData->toJson();

        $classificationDefaultData = Classification::get();
        $classificationsDefaultjson = $classificationDefaultData->toJson();

        // Calculate the starting counter based on the current page
        $counter = 50 * ($page - 1);

        $box = [];
        $purity = [];
        $cart = [];
        $cartcount = [];

        // Loop through products and add values to arrays
        foreach ($boxwiseproduct as $item) {
            // Fetch the box name using the item
            $boxName = Style::where('id', $item->style_id)
                ->where('is_active', 1)
                ->value('style_name');

            // Add the box name to the array, with the counter as the key
            $box[$counter] = $boxName;

            // Fetch the product purity
            $productPurity = SilverPurity::where('id', $item->purity_id)->value('silver_purity_percentage');

            // Add the purity value to the array, with the counter as the key
            $purity[$counter] = $productPurity;

            // Fetch the cart status for the item
            $iscart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->get();

            // Add the cart status to the cart array, with the counter as the key
            $cart[$counter] = $iscart;

            // Fetch the cart count for the item
            $currentcart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->value('qty');

            // Add the cart count to the cartcount array, with the counter as the key
            $cartcount[$counter] = $currentcart;

            // Increment the counter for the next iteration
            $counter++;
        }

        $stock = 1;
        return response()->json([
            'boxwiseproduct' => $boxwiseproduct,
            'box' => $box,
            'cart' => $cart,
            'purity' => $purity,
            'cartcount' => $cartcount,
            'stock' => $stock,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson,
            'classificationsjson' => $classificationsjson,
            'classificationsDefaultjson' => $classificationsDefaultjson
        ]);
    }

    public function getPuritywiseProduct(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        $selectedPurity = $request->input('selectedpurity', []);
        $getpurityid = SilverPurity::whereIn('silver_purity_percentage', $selectedPurity)
            ->pluck('id');

        $puritywiseproduct = $this->getproducts(Auth::user()->id);

        Session::put('selectedPurity', $selectedPurity);

        if ($getpurityid->isNotEmpty()) {
            $puritywiseproduct->whereIn('products.purity_id', $getpurityid);
        }

        if ($request->stockid == 1) {
            $puritywiseproduct = $puritywiseproduct->where('products.qty', '>', 0);
        }

        // Ensure classification_id is treated as an array
        $classifications = (array) $request->input('classification_id', []);
        if (!empty($classifications) && !empty(array_filter($classifications))) {
            $class_id = Classification::whereIn('classification_name', $classifications)->pluck('id')->toArray();
            $puritywiseproduct = $puritywiseproduct->whereIn('products.classification_id', $class_id);
        }

        if (!empty($request->project_id)) {
            $puritywiseproduct = $puritywiseproduct->where('products.project_id', $request->project_id);
        }
        // dd(empty(array_filter($request->weightfrom)), count($request->weightto));
        if (count(array_filter($request->weightfrom)) > 0 && count(array_filter($request->weightto)) > 0) {
            $selectedWeightRangesFrom = $request->input('weightfrom');
            $selectedWeightRangesTo = $request->input('weightto');
            // Ensure both arrays have elements
            if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
                $puritywiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
                    foreach ($selectedWeightRangesFrom as $index => $from) {
                        $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
                    }
                });
            }
        }

        // Clone the query to calculate the min and max weight before paginating
        $weightQuery = clone $puritywiseproduct;
        $minWeight = $weightQuery->min('products.weight');
        $maxWeight = $weightQuery->max('products.weight');

        $puritywiseproduct = $puritywiseproduct
            ->orderBy('products.qty', 'DESC')->get();

        // Filter out products without an image in the public/upload/product directory
        $filteredProducts = $puritywiseproduct->filter(function ($product) {
            return File::exists(public_path("upload/product/{$product->product_image}"));
        });

        // Manually paginate the filtered products
        $page = request()->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $puritywiseproduct = $paginatedProducts;

        // Assuming $minWeight and $maxWeight are already defined
        if ($maxWeight < 5) {
            // Get only the record with id=1
            $matchingWeights = Weight::where('id', 1)
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->pluck('id')
                ->toArray();
        } else {
            // Get weights that match minWeight and maxWeight
            $matchingWeights = Weight::where('is_active', 1)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($minWeight, $maxWeight) {
                    $query->whereBetween('weight_range_from', [$minWeight, $maxWeight])
                        ->orWhereBetween('weight_range_to', [$minWeight, $maxWeight]);
                })
                ->pluck('id')
                ->toArray();
        }
        // Check if matchingWeights is empty
        if (empty($matchingWeights)) {
            // Use minWeight for comparison
            $weights = Weight::where('is_active', 1)
                ->whereNull('deleted_at')
                ->where(function ($query) use ($minWeight) {
                    $query->where('weight_range_from', '<=', $minWeight)
                        ->where('weight_range_to', '>=', $minWeight);
                })
                ->get();
        } else {
            $weights = Weight::whereIn('id', $matchingWeights)->where('is_active', 1)->whereNull('deleted_at')->get();
        }

        $weightJson = $weights->toJson();

        $defaultweights = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        $defaultweightJson = $defaultweights->toJson();

        $collectionIds = $puritywiseproduct->pluck('classification_id')->toArray();

        $classificationData = Classification::whereIn('id', $collectionIds)->get();
        $classificationsjson = $classificationData->toJson();

        $classificationDefaultData = Classification::get();
        $classificationsDefaultjson = $classificationDefaultData->toJson();

        // Calculate the starting counter based on the current page
        $counter = 50 * ($page - 1);

        $box = [];
        $purity = [];
        $cart = [];
        $cartcount = [];

        // Loop through products and add values to arrays
        foreach ($puritywiseproduct as $item) {
            // Fetch the box name using the item
            $boxName = Style::where('id', $item->style_id)
                ->where('is_active', 1)
                ->value('style_name');

            // Add the box name to the array, with the counter as the key
            $box[$counter] = $boxName;

            // Fetch the product purity
            $productPurity = SilverPurity::where('id', $item->purity_id)->value('silver_purity_percentage');

            // Add the purity value to the array, with the counter as the key
            $purity[$counter] = $productPurity;

            // Fetch the cart status for the item
            $iscart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->get();

            // Add the cart status to the cart array, with the counter as the key
            $cart[$counter] = $iscart;

            // Fetch the cart count for the item
            $currentcart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)->value('qty');

            // Add the cart count to the cartcount array, with the counter as the key
            $cartcount[$counter] = $currentcart;

            // Increment the counter for the next iteration
            $counter++;
        }

        $stock = 1;
        return response()->json([
            'puritywiseproduct' => $puritywiseproduct,
            'box' => $box,
            'cart' => $cart,
            'purity' => $purity,
            'cartcount' => $cartcount,
            'stock' => $stock,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson,
            'classificationsjson' => $classificationsjson,
            'classificationsDefaultjson' => $classificationsDefaultjson
        ]);
    }
}

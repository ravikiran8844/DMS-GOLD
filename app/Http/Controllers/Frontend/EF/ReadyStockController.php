<?php

namespace App\Http\Controllers\Frontend\EF;

use App\Enums\Projects;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Classification;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Finish;
use App\Models\MakingCharge;
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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ReadyStockController extends Controller
{
    private $paginate = 42;
    use Common;

    function search(Request $request)
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 1800); //3 minutes
        $search = $request->search;
        $searchSubstring = substr($search, 0, 4);

        $products = $this->getproducts(Auth::user()->id)
            ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL, Projects::CASTING, Projects::INIDIANIA])
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
                ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL, Projects::CASTING, Projects::INIDIANIA])
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
                ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL, Projects::CASTING, Projects::INIDIANIA])
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

        $allProduct = Product::select('id')->whereIn('project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL, Projects::INIDIANIA, Projects::CASTING])->get();
        $stock = 0;
        $breadcrum = null;
        $breadcrumUrl = null;
        $project_id = null;

        return view('dealer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function efStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;
        $subQuery = DB::table('products')
            ->select(DB::raw('MAX(id) as id'))
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->where('project_id', Projects::ELECTROFORMING)
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
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->get();
        $stock = 0;
        $breadcrum = 'EF Idol';
        $breadcrumUrl = route('efstock');
        $decryptedProjectId = Projects::ELECTROFORMING;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function siStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->where('products.project_id', Projects::SOLIDIDOL)
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
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->get();
        $stock = 0;
        $breadcrum = 'Solid Idol';
        $breadcrumUrl = route('sistock');
        $decryptedProjectId = Projects::SOLIDIDOL;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function jewelleryStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->where('products.project_id', Projects::CASTING)
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
        $allProduct = Product::select('id')->where('project_id', Projects::CASTING)->get();
        $stock = 0;
        $breadcrum = 'Jewellery';
        $breadcrumUrl = route('jewellerystock');
        $decryptedProjectId = Projects::CASTING;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function indianiaStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->where('products.project_id', Projects::INIDIANIA)
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
        $allProduct = Product::select('id')->where('project_id', Projects::INIDIANIA)->get();
        $stock = 0;
        $breadcrum = 'Indiania';
        $breadcrumUrl = route('indianiastock');
        $decryptedProjectId = Projects::INIDIANIA;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function utensilStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;
        $product = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->where('products.project_id', Projects::UTENSIL)
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
        $allProduct = Product::select('id')->where('project_id', Projects::UTENSIL)->get();
        $stock = 0;
        $breadcrum = 'Utesnil';
        $breadcrumUrl = route('utensilstock');
        $decryptedProjectId = Projects::UTENSIL;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
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
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->get();
        $stock = 1;
        $breadcrum = 'EF Idol Ready Stock';
        $breadcrumUrl = route('efreadystock');
        $decryptedProjectId = Projects::ELECTROFORMING;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function siReadyStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
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
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->get();
        $stock = 1;
        $breadcrum = 'Solid Idol Ready Stock';
        $breadcrumUrl = route('sireadystock');
        $decryptedProjectId = Projects::SOLIDIDOL;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function jewelleryReadyStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
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
        $allProduct = Product::select('id')->where('project_id', Projects::CASTING)->get();
        $stock = 1;
        $breadcrum = 'Jewellery Ready Stock';
        $breadcrumUrl = route('jewelleryreadystock');
        $decryptedProjectId = Projects::CASTING;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function indianiaReadyStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
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
        $allProduct = Product::select('id')->where('project_id', Projects::INIDIANIA)->get();
        $stock = 1;
        $breadcrum = 'Jewellery Ready Stock';
        $breadcrumUrl = route('jewelleryreadystock');
        $decryptedProjectId = Projects::INIDIANIA;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }
    function utensilReadyStock(Request $request)
    {
        ini_set('memory_limit', '1024M');
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
        $allProduct = Product::select('id')->where('project_id', Projects::UTENSIL)->get();
        $stock = 1;
        $breadcrum = 'Jewellery Ready Stock';
        $breadcrumUrl = route('jewelleryreadystock');
        $decryptedProjectId = Projects::UTENSIL;
        $request->session()->forget('ret_ses');
        return view('dealer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    function productDetail($id)
    {
        $decryptedId = decrypt($id);
        $product = Product::select(
            'products.*',
            'metal_types.metal_name',
            'platings.plating_name',
            'categories.category_name',
            'projects.project_name'
        )
            ->join('metal_types', 'metal_types.id', 'products.metal_type_id')
            ->join('platings', 'platings.id', 'products.plating_id')
            ->join('finishes', 'finishes.id', 'products.finish_id')
            ->join('projects', 'projects.id', 'products.project_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->where('products.id', $decryptedId)
            ->where('products.is_active', 1)
            ->whereNull('products.deleted_at')
            ->first();

        $stock = 0;
        $relatedProducts = $this->getproducts(Auth::user()->id)->where('products.id', '!=', $decryptedId)->where('sub_collection_id', $product->sub_collection_id)->where('project_id', $product->project_id)->where('qty', '>', 0)->limit(20)->get();
        $sizes = Size::where('is_active', 1)->get();
        $weights = Weight::where('is_active', 1)->get();
        $colors = Color::where('is_active', 1)->whereNull('deleted_at')->get();
        $finishes = Finish::where('is_active', 1)->where('project_id', $product->project_id)->whereNull('deleted_at')->get();

        return view('dealer.readystock.productdetail', compact('product', 'sizes', 'weights', 'colors', 'finishes', 'stock', 'relatedProducts'));
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

            $existingCartlist = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->first();
            $actualcartcount = Cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->value('qty');
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
                        'alert' => 'error',
                        'actualcartcount' => $actualcartcount
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
                        'alert' => 'error',
                        'actualcartcount' => $actualcartcount
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
            $currentcartcount = Cart::where('product_id', $request->product_id)
                ->where('user_id', Auth::user()->id)
                ->value('qty');
            return response()->json([
                'count_response' => $count,
                'currentcartcount' => $currentcartcount,
                'actualcartcount' => $actualcartcount,
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

            if ($request->stockid == 1) {
                $weightrange = $weightrange->where('products.qty', '>', 0);
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
            $weightrange = $weightrange->orderBy('products.weight', 'ASC')->orderBy('products.id', 'ASC')
                ->paginate($this->paginate);

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
            if (request()->stockid == 1) {
                $box = [];
                foreach ($weightrange as $item) {
                    $boxName = Style::where('id', $item->style_id)
                        ->where('is_active', 1)
                        ->value('style_name');

                    $box[] = $boxName;
                }
            }
            $stock = $request->stockid;

            $responseData = [
                'weightrange' => $weightrange,
                'stock' => $stock,
                'mc_charge' => $mcChargeArray,
                'subcollectionsjson' => $subcollectionsjson,
                'subcollectionsDefaultjson' => $subcollectionsDefaultjson,
                'classificationsjson' => $classificationsjson,
                'classificationsDefaultjson' => $classificationsDefaultjson,
                'categoryjson' => $categoryjson,
                'categoryDefaultjson' => $categoryDefaultjson
            ];

            // Add 'box' to the response data if request()->stockid == 1
            if (request()->stockid == 1) {
                $responseData['box'] = $box;
            }

            return response()->json($responseData);
        } else {
            $weightrange = $this->getproducts(Auth::user()->id);
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

            $weightrange = $weightrange->orderBy('products.id', 'ASC')
                ->paginate($this->paginate);

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
            if (request()->stockid == 1) {
                $box = [];
                foreach ($weightrange as $item) {
                    $boxName = Style::where('id', $item->style_id)
                        ->where('is_active', 1)
                        ->value('style_name');

                    $box[] = $boxName;
                }
            }
            $stock = $request->stockid;
            $responseData = [
                'weightrange' => $weightrange,
                'stock' => $stock,
                'mc_charge' => $mcChargeArray,
                'subcollectionsjson' => $subcollectionsjson,
                'subcollectionsDefaultjson' => $subcollectionsDefaultjson,
                'classificationsjson' => $classificationsjson,
                'classificationsDefaultjson' => $classificationsDefaultjson,
                'categoryjson' => $categoryjson,
                'categoryDefaultjson' => $categoryDefaultjson
            ];

            // Add 'box' to the response data if request()->stockid == 1
            if (request()->stockid == 1) {
                $responseData['box'] = $box;
            }

            return response()->json($responseData);
        }
    }

    public function classificationwiseproduct(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
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
            ->orderBy('products.id', 'ASC')
            ->paginate($this->paginate);

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
        if (request()->stockid == 1) {
            $box = [];
            foreach ($classificationwiseproduct as $item) {
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                $box[] = $boxName;
            }
        }
        $stock = $request->stockid;

        $responseData = [
            'classificationwiseproduct' => $classificationwiseproduct,
            'stock' => $stock,
            'mc_charge' => $mcChargeArray,
            'subcollectionsjson' => $subcollectionsjson,
            'subcollectionsDefaultjson' => $subcollectionsDefaultjson,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson
        ];

        // Add 'box' to the response data if request()->stockid == 1
        if (request()->stockid == 1) {
            $responseData['box'] = $box;
        }

        return response()->json($responseData);
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


        $collectionwiseproduct = $collectionwiseproduct->orderBy('products.id', 'ASC')->paginate($this->paginate);

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
        if (request()->stockid == 1) {
            $box = [];
            foreach ($collectionwiseproduct as $item) {
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                $box[] = $boxName;
            }
        }
        $stock = $request->stockid;
        $responseData = [
            'collectionwiseproduct' => $collectionwiseproduct,
            'mc_charge' => $mcChargeArray,
            'stock' => $stock,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson,
        ];

        // Add 'box' to the response data if request()->stockid == 1
        if (request()->stockid == 1) {
            $responseData['box'] = $box;
        }

        return response()->json($responseData);
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

        $subcollectionwiseproduct = $subcollectionwiseproduct->orderBy('products.weight', 'ASC')->orderBy('products.id', 'ASC')->paginate($this->paginate);

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
        if (request()->stockid == 1) {
            $box = [];
            foreach ($subcollectionwiseproduct as $item) {
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                $box[] = $boxName;
            }
        }
        $stock = $request->stockid;

        $responseData = [
            'subcollectionwiseproduct' => $subcollectionwiseproduct,
            'stock' => $stock,
            'mc_charge' => $mcChargeArray,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson,
            'classificationsjson' => $classificationsjson,
            'classificationsDefaultjson' => $classificationsDefaultjson,
        ];

        // Add 'box' to the response data if request()->stockid == 1
        if (request()->stockid == 1) {
            $responseData['box'] = $box;
        }

        return response()->json($responseData);
    }

    public function categorywiseproduct(Request $request, $id)
    {

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

        if (!empty($request->project_id)) {
            $categorywiseproduct = $categorywiseproduct->where('products.project_id', $request->project_id);
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

        $categorywiseproduct = $categorywiseproduct->orderBy('products.id', 'ASC')->paginate($this->paginate);

        $mcChargeArray = [];
        foreach ($categorywiseproduct as $item) {
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

        if ($request->stockid == 1) {
            $box = [];
            foreach ($categorywiseproduct as $item) {
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                $box[] = $boxName;
            }
        }

        $stock = $request->stockid;

        $responseData = [
            'categorywiseproduct' => $categorywiseproduct,
            'stock' => $stock,
            'mc_charge' => $mcChargeArray,
        ];

        // Add 'box' to the response data if request()->stockid == 1
        if (request()->stockid == 1) {
            $responseData['box'] = $box;
        }

        return response()->json($responseData);
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

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
use App\Models\Project;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReadyStockController extends Controller
{
    private $paginate = 20;
    use Common;

    function search(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180); //3 minutes
        $search = $request->search;
        $searchSubstring = substr($search, 0, 4);
        $secret = 'EmeraldAdmin';

        $products = $this->getproducts(Auth::user()->id)
            ->whereIn('products.project', [Projects::EF, Projects::LASERCUT, Projects::CASTING, Projects::IMPREZ, Projects::INDIANIA, Projects::MMD, Projects::STAMPING, Projects::TURKISH, Projects::UNIKRAFT])
            ->where(function ($query) use ($search) {
                $query->where('products.DesignNo', 'like', '%' . $search . '%');
            })
            ->orderBy('products.DesignNo', 'ASC')
            ->get();

        if ($products->isEmpty()) {
            $product = $this->getproducts(Auth::user()->id)
                ->whereIn('products.project', [Projects::EF, Projects::LASERCUT, Projects::CASTING, Projects::IMPREZ, Projects::INDIANIA, Projects::MMD, Projects::STAMPING, Projects::TURKISH, Projects::UNIKRAFT])
                ->where(function ($query) use ($search) {
                    $query->where('products.DesignNo', 'like', '%' . $search . '%');
                })
                ->orderBy('products.DesignNo', 'ASC')
                ->get();

            $filteredProducts = $product->get()
                ->map(function ($product) use ($secret) {
                    $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                    return $product;
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
                ->whereIn('products.project', [Projects::EF, Projects::LASERCUT, Projects::CASTING, Projects::IMPREZ, Projects::INDIANIA, Projects::MMD, Projects::STAMPING, Projects::TURKISH, Projects::UNIKRAFT])
                ->where(function ($query) use ($search) {
                    $query->where('products.DesignNo', 'like', '%' . $search . '%');
                })
                ->orderBy('products.DesignNo', 'ASC')
                ->get();

            $filteredProducts = $product->get()
                ->map(function ($product) use ($secret) {
                    $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                    return $product;
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

        $allProduct = Product::get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $project_id = null;
        $request->session()->put('ret_ses', $search);

        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    public function ef(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::EF);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::EF;
        $allProduct = Product::select('id')->where('project', Projects::EF)->get();
        $stock = 1;
        $breadcrum = 'EF';
        $breadcrumUrl = route('retailerefreadystock');
        $decryptedProjectId = Projects::EF;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function casting(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::CASTING);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::CASTING;
        $allProduct = Product::select('id')->where('project', Projects::CASTING)->get();
        $stock = 1;
        $breadcrum = 'CASTING';
        $breadcrumUrl = route('retailersireadystock');
        $decryptedProjectId = Projects::CASTING;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function imprez(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::IMPREZ);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::IMPREZ;
        $allProduct = Product::select('id')->where('project', Projects::IMPREZ)->get();
        $stock = 1;
        $breadcrum = 'IMPREZ';
        $breadcrumUrl = route('retailersireadystock');
        $decryptedProjectId = Projects::IMPREZ;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function indiania(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::INDIANIA);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::INDIANIA;
        $allProduct = Product::select('id')->where('project', Projects::INDIANIA)->get();
        $stock = 1;
        $breadcrum = 'INDIANIA';
        $breadcrumUrl = route('retailerindianiareadystock');
        $decryptedProjectId = Projects::INDIANIA;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function lasercut(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::LASERCUT);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::LASERCUT;
        $allProduct = Product::select('id')->where('project', Projects::LASERCUT)->get();
        $stock = 1;
        $breadcrum = 'LASERCUT';
        $breadcrumUrl = route('retailerindianiareadystock');
        $decryptedProjectId = Projects::LASERCUT;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function mmd(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::MMD);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::MMD;
        $allProduct = Product::select('id')->where('project', Projects::MMD)->get();
        $stock = 1;
        $breadcrum = 'MMD';
        $breadcrumUrl = route('mmd');
        $decryptedProjectId = Projects::MMD;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function stamping(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::STAMPING);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::STAMPING;
        $allProduct = Product::select('id')->where('project', Projects::STAMPING)->get();
        $stock = 1;
        $breadcrum = 'STAMPING';
        $breadcrumUrl = route('stamping');
        $decryptedProjectId = Projects::STAMPING;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function turkish(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::TURKISH);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::TURKISH;
        $allProduct = Product::select('id')->where('project', Projects::TURKISH)->get();
        $stock = 1;
        $breadcrum = 'TURKISH';
        $breadcrumUrl = route('turkish');
        $decryptedProjectId = Projects::TURKISH;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function unikraft(Request $request)
    {
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        $subQuery = DB::table('products')
            ->select('id')
            ->where('qty', '>', 0)
            ->where('project', Projects::UNIKRAFT);

        $productQuery = Product::select('products.*', 'wishlists.is_favourite')
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->joinSub($subQuery, 'sub', function ($join) {
                $join->on('products.id', '=', 'sub.id');
            })
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $productQuery->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::UNIKRAFT;
        $allProduct = Product::select('id')->where('project', Projects::UNIKRAFT)->get();
        $stock = 1;
        $breadcrum = 'UNIKRAFT';
        $breadcrumUrl = route('unikraft');
        $decryptedProjectId = Projects::UNIKRAFT;
        $request->session()->forget('ret_ses');

        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
    }

    public function getToken()
    {
        $response = Http::get('http://imageurl.ejindia.com/api/token');
        return response()->json($response->json());
    }

    public function secureImage(Request $request)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Authorization token missing'], 401);
        }

        Log::info('Received token in header:', [$token]);

        $response = Http::withHeaders([
            'Authorization' => $token,
            'Accept' => 'application/json',
        ])->post('http://imageurl.ejindia.com/api/image/secure', [
            'secureFilename' => $request->input('secureFilename')
        ]);

        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type', 'application/json'));
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

    function productDetail($id)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        $decryptedId = decrypt($id);

        $product = Product::where('products.id', $decryptedId)
            ->first();


        if ($product) {
            $secret = 'EmeraldAdmin'; // make sure you define this
            $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
        }
        // dd($product);
        $stock = 1;
        $sizes = Size::where('is_active', 1)->get();
        $weights = Weight::where('is_active', 1)->get();
        $colors = Color::where('is_active', 1)->whereNull('deleted_at')->get();
        $finishes = Finish::where('is_active', 1)->where('project_id', $product->project_id)->whereNull('deleted_at')->get();
        $currentcartcount = Cart::where('user_id', Auth::user()->id)->where('product_id', $product->id)->value('qty');
        return view('retailer.readystock.productdetail', compact('product', 'sizes', 'weights', 'colors', 'finishes', 'stock', 'currentcartcount'));
    }

    public function addToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $existingCartlist = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->first();

            $stock = Product::where('id', $request->product_id)->value('qty');
            if ($request->qty > $stock) {
                $notification = array(
                    'message' => 'Please order within available stock limit',
                    'alert' => 'error'
                );
                return response()->json([
                    'notification_response' => $notification
                ]);
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
                    'size' => $request->size,
                    'weight' => $request->weight,
                    'box' => $request->box,
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
            $stock = Product::where('id', $request->product_id)->value('qty');

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
            if ($existingCartlist) {
                if ($existingCartlist->qty + $request->qty >= $stock) {
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
                        'qty' => $existingCartlist->qty + $request->qty
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
                    'weight' => $request->weight,
                    'size' => $request->size,
                    'box' => $request->box
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

            $checkedIds = $request->product_id;
            $size = $request->size;
            $weight = $request->weight;
            $qty = $request->qty;
            $box = $request->box;

            foreach ($checkedIds as $key => $productId) {
                // Check if the product is already in the cart
                $existingCartlist = Cart::where('user_id', Auth::user()->id)
                    ->where('product_id', $productId)
                    ->first();
                $stock = Product::where('id', $productId)->value('qty');
                if ($request->qty[$key] > $stock) {
                    $notification = array(
                        'message' => 'Please order within available stock limit',
                        'alert' => 'error'
                    );
                    return response()->json([
                        'notification_response' => $notification
                    ]);
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
                            'qty' => $existingCartlist->qty + $qty[$key],
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
                        'qty' => $qty[$key],
                        'size' => $size[$key],
                        'box' => $box[$key],
                        'weight' => $weight[$key],
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
                // Projects::SOLIDIDOL,
                // Projects::ELECTROFORMING,
                // Projects::CASTING,
                // Projects::UTENSIL,
                // Projects::INIDIANIA,
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
                // Projects::SOLIDIDOL,
                // Projects::ELECTROFORMING,
                // Projects::CASTING,
                // Projects::UTENSIL,
                // Projects::INIDIANIA,
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

    public function getItemwiseProduct(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        $selectedItem = $request->input('selectedItem', []);
        $getItem = Product::whereIn('Item', $selectedItem)->pluck('Item')->toArray();

        $itemwiseproduct = $this->getproducts(Auth::user()->id);

        if ($getItem) {
            $itemwiseproduct->whereIn('products.Item', $getItem)
            ->where('products.qty', '>', 0);
        }

        if (!empty($request->project_id)) {
            $itemwiseproduct = $itemwiseproduct->where('products.Project', $request->project_id);
        }

        $itemwiseproduct = $itemwiseproduct
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $itemwiseproduct->get()
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $itemwiseproduct = $paginated;
        // Calculate the starting counter based on the current page
        $counter = 50 * ($page - 1);

        $box = [];
        $purity = [];
        $cart = [];
        $cartcount = [];

        // Loop through products and add values to arrays
        foreach ($itemwiseproduct as $item) {

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

        return response()->json([
            'itemwiseproduct' => $itemwiseproduct,
            'cart' => $cart,
            'cartcount' => $cartcount,
        ]);
    }
}

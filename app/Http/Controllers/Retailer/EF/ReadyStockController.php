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
use App\Models\ProductVariant;
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
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReadyStockController extends Controller
{
    private $paginate = 20;
    use Common;

    function search(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);

        $search = $request->search;
        $secret = 'EmeraldAdmin';

        $products = $this->getproducts(Auth::user()->id)
            ->whereIn('products.project', [
                Projects::EF,
                Projects::LASERCUT,
                Projects::CASTING,
                Projects::IMPREZ,
                Projects::INDIANIA,
                Projects::MMD,
                Projects::STAMPING,
                Projects::TURKISH,
                Projects::UNIKRAFT
            ])
            ->where('products.DesignNo', 'like', '%' . $search . '%')
            ->where('products.qty', '>', 0)
            ->orderBy('products.DesignNo', 'ASC')
            ->get();

        $filteredProducts = $products
            ->map(function ($product) use ($secret) {
                $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
                return $product;
            });

        // Paginate
        $page = $request->get('page', 1);
        $perPage = $this->paginate;
        $paginatedProducts = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredProducts->forPage($page, $perPage),
            $filteredProducts->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $product = $paginatedProducts;
        $allProduct = Product::get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $project_id = null;

        $request->session()->put('ret_ses', $search);

        return view('retailer.readystock.readystock', compact(
            'product',
            'allProduct',
            'stock',
            'search',
            'breadcrumUrl',
            'breadcrum',
            'project_id'
        ));
    }

    public function ef(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::EF)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::EF;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::EF)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'EF';
        $breadcrumUrl = route('retailerefreadystock');
        $decryptedProjectId = Projects::EF;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function casting(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::CASTING)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::CASTING;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::CASTING)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'CASTING';
        $breadcrumUrl = route('retailersireadystock');
        $decryptedProjectId = Projects::CASTING;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function imprez(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::IMPREZ)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::IMPREZ;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::IMPREZ)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'IMPREZ';
        $breadcrumUrl = route('retailerjewelleryreadystock');
        $decryptedProjectId = Projects::IMPREZ;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function indiania(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::INDIANIA)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::INDIANIA;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::INDIANIA)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'INDIANIA';
        $breadcrumUrl = route('retailerindianiareadystock');
        $decryptedProjectId = Projects::INDIANIA;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function lasercut(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::LASERCUT)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::LASERCUT;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::LASERCUT)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'LASERCUT';
        $breadcrumUrl = route('retailerutensilreadystock');
        $decryptedProjectId = Projects::LASERCUT;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function mmd(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::MMD)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::MMD;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::MMD)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'MMD';
        $breadcrumUrl = route('mmd');
        $decryptedProjectId = Projects::MMD;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function stamping(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::STAMPING)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::STAMPING;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::STAMPING)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'STAMPING';
        $breadcrumUrl = route('stamping');
        $decryptedProjectId = Projects::STAMPING;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function turkish(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::TURKISH)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::TURKISH;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::TURKISH)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'TURKISH';
        $breadcrumUrl = route('turkish');
        $decryptedProjectId = Projects::TURKISH;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function unikraft(Request $request)
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $user_id = Auth::user()->id;

        // Fetch all matching products with variants
        $productQuery = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.project', Projects::UNIKRAFT)
            ->orderBy('products.DesignNo', 'ASC');

        $rawProducts = $productQuery->get();
        $secret = 'EmeraldAdmin';

        // Group variants by product ID
        $grouped = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->Purity,
                    'color' => $item->color,
                    'unit' => $item->unit,
                    'style' => $item->style,
                    'making' => $item->making,
                    'size' => $item->size,
                    'weight' => $item->weight,
                    'qty' => $item->qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = $this->paginate;

        $paginated = new LengthAwarePaginator(
            $grouped->forPage($page, $perPage),
            $grouped->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $product = $paginated;
        $project_id = Projects::UNIKRAFT;
        $allProduct = Product::select('products.id')->join('product_variants', 'product_variants.product_id', 'products.id')
            ->where('products.project', Projects::UNIKRAFT)
            ->where('product_variants.qty', '>', 0)
            ->get();
        $stock = 1;
        $breadcrum = 'UNIKRAFT';
        $breadcrumUrl = route('unikraft');
        $decryptedProjectId = Projects::UNIKRAFT;

        return view('retailer.readystock.readystock', compact(
            'allProduct',
            'product',
            'decryptedProjectId',
            'project_id',
            'breadcrum',
            'breadcrumUrl',
            'stock'
        ));
    }

    public function getToken()
    {
        return Cache::remember('external_api_token', 300, function () {
            $response = Http::timeout(5)->get('http://imageurl.ejindia.com/api/token');
            return $response->json();
        });
    }

    public function secureImage(Request $request)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Authorization token missing'], 401);
        }

        $response = Http::withHeaders([
            'Authorization' => $token,
            'Accept' => 'application/json',
        ])->post('https://imageurl.ejindia.com/api/image/secure', [
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

    public function productDetail($id)
    {
        ini_set('max_execution_time', 1800); // 3 minutes
        $decryptedId = decrypt($id);
        $user_id = Auth::user()->id;
        $secret = 'EmeraldAdmin';

        // Fetch product and variant details for a single product
        $rawProduct = Product::select(
            'products.*',
            'product_variants.id as productID',
            'product_variants.qty',
            'product_variants.weight',
            'product_variants.color',
            'product_variants.size',
            'product_variants.Purity',
            'product_variants.style',
            'product_variants.making',
            'product_variants.unit',
            'wishlists.is_favourite'
        )
            ->join('product_variants', function ($join) {
                $join->on('products.id', '=', 'product_variants.product_id')
                    ->where('product_variants.qty', '>', 0);
            })
            ->leftJoin('wishlists', function ($join) use ($user_id) {
                $join->on('wishlists.product_id', '=', 'products.id')
                    ->where('wishlists.user_id', '=', $user_id);
            })
            ->where('products.id', $decryptedId)
            ->get();

        if ($rawProduct->isEmpty()) {
            abort(404, 'Product not found');
        }

        // Prepare structure just like 'unikraft'
        $base = $rawProduct->first();
        $base->variants = $rawProduct->map(function ($item) {
            return [
                'productID' => $item->productID,
                'Purity' => $item->Purity,
                'color' => $item->color,
                'unit' => $item->unit,
                'style' => $item->style,
                'making' => $item->making,
                'size' => $item->size,
                'weight' => $item->weight,
                'qty' => $item->qty,
            ];
        });

        $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
        $base->variant_count = $rawProduct->count();

        // Get current cart qty for this product
        $currentcartcount = Cart::where('user_id', $user_id)
            ->where('product_id', $base->id)
            ->value('qty');

        return view('retailer.readystock.productdetail', [
            'product' => $base,
            'currentcartcount' => $currentcartcount
        ]);
    }

    public function addToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::user()->id;

            $existingCartlist = Cart::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();

            // Get available stock
            $stock = ProductVariant::where('id', $request->product_id)->value('qty');
            if ($stock === null) {
                $stock = ProductVariant::where('product_id', $request->product_id)->value('qty');
                $productId = ProductVariant::where('product_id', $request->product_id)->value('id');
            } else {
                $productId = $request->product_id;
            }

            // Safely determine requested quantity
            $requestedQty = $request->qty ?? $request->mqty ?? 0;

            if ($requestedQty <= 0) {
                return response()->json([
                    'notification_response' => [
                        'message' => 'Please specify a valid quantity',
                        'alert' => 'error'
                    ]
                ]);
            }

            // Check if requested qty is within stock
            if ($requestedQty > $stock) {
                return response()->json([
                    'notification_response' => [
                        'message' => 'Please order within available stock limit',
                        'alert' => 'error'
                    ]
                ]);
            }

            if ($existingCartlist) {
                if (($existingCartlist->qty + $requestedQty) > $stock) {
                    return response()->json([
                        'notification_response' => [
                            'message' => 'Please order within available stock limit',
                            'alert' => 'error'
                        ]
                    ]);
                }

                $existingCartlist->update([
                    'qty' => $existingCartlist->qty + $requestedQty
                ]);
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'qty' => $requestedQty,
                    'size' => $request->size ?? $request->msize,
                    'weight' => $request->weight ?? $request->mweight,
                    'box' => $request->box ?? $request->mbox,
                ]);
            }

            // Totals
            $cartcount = Cart::where('user_id', $userId)->count();
            $cartqtycount = Cart::where('user_id', $userId)->sum('qty');
            $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * product_variants.weight) as totalWeight'))
                ->join('product_variants', 'product_variants.id', '=', 'carts.product_id')
                ->where('carts.user_id', $userId)
                ->value('totalWeight');

            DB::commit();

            return response()->json([
                'count_response' => ['count' => $cartcount],
                'count_qty' => $cartqtycount,
                'count_weight' => $cartweightcount,
                'notification_response' => [
                    'message' => 'Added to cart',
                    'alert' => 'success'
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            return redirect()->back()->with([
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    public function addForCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::user()->id;

            $existingCartlist = Cart::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();

            // Get available stock
            $stock = ProductVariant::where('id', $request->product_id)->value('qty');
            if ($stock === null) {
                $stock = ProductVariant::where('product_id', $request->product_id)->value('qty');
                $productId = ProductVariant::where('product_id', $request->product_id)->value('id');
            } else {
                $productId = $request->product_id;
            }

            $requestedQty = $request->qty ?? $request->mqty ?? 0;
            if ($requestedQty <= 0) {
                return response()->json([
                    'notification_response' => [
                        'message' => 'Please specify a valid quantity',
                        'alert' => 'error'
                    ]
                ]);
            }

            if ($requestedQty > $stock) {
                $actualcartcount = Cart::where('product_id', $request->product_id)
                    ->where('user_id', $userId)
                    ->value('qty');

                return response()->json([
                    'notification_response' => [
                        'message' => 'Please order within available stock limit',
                        'alert' => 'error',
                        'actualcartcount' => $actualcartcount
                    ]
                ]);
            }

            if ($existingCartlist) {
                if (($existingCartlist->qty + $requestedQty) > $stock) {
                    $actualcartcount = $existingCartlist->qty;

                    return response()->json([
                        'notification_response' => [
                            'message' => 'Please order within available stock limit',
                            'alert' => 'error',
                            'actualcartcount' => $actualcartcount
                        ]
                    ]);
                }

                $existingCartlist->update([
                    'qty' => $existingCartlist->qty + $requestedQty
                ]);
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'qty' => $requestedQty,
                    'size' => $request->size ?? $request->msize,
                    'weight' => $request->weight ?? $request->mweight,
                    'box' => $request->box ?? $request->mbox,
                ]);
            }

            // Totals
            $cartcount = Cart::where('user_id', $userId)->count();
            $cartqtycount = Cart::where('user_id', $userId)->sum('qty');
            $cartweightcount = Cart::select(DB::raw('SUM(carts.qty * product_variants.weight) as totalWeight'))
                ->join('product_variants', 'product_variants.id', '=', 'carts.product_id')
                ->where('carts.user_id', $userId)
                ->value('totalWeight');

            $currentcartcount = Cart::where('product_id', $productId)
                ->where('user_id', $userId)
                ->value('qty');

            DB::commit();

            return response()->json([
                'count_response' => ['count' => $cartcount],
                'currentcartcount' => $currentcartcount,
                'actualcartcount' => $currentcartcount,
                'count_qty' => $cartqtycount,
                'count_weight' => $cartweightcount,
                'notification_response' => [
                    'message' => 'Added to cart',
                    'alert' => 'success'
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());

            return redirect()->back()->with([
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            ]);
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
        ini_set('max_execution_time', 1800); // 30 minutes

        // Validate and collect filters
        $selectedWeightRangesFrom = (array) $request->input('selectedWeightRanges');
        $selectedWeightRangesTo = (array) $request->input('weightToArray');
        $procategories = (array) $request->input('procategoryArray');
        $productItems = (array) $request->input('productArray');
        $project = $request->input('project');
        $isFilterApplied = !empty($id) && !empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo);

        // Start base product query
        $products = $this->getproducts(Auth::user()->id);

        if (!empty($project)) {
            $products = $products->where('products.Project', $project);
        }

        if (!empty(array_filter($procategories))) {
            $products = $products->whereIn('products.Procatgory', $procategories);
        }

        if (!empty(array_filter($productItems))) {
            $products = $products->whereIn('products.Item', $productItems);
        }

        if ($isFilterApplied && count($selectedWeightRangesFrom) === count($selectedWeightRangesTo)) {
            $weightRanges = array_map(function ($from, $to) {
                return ['from' => $from, 'to' => $to];
            }, $selectedWeightRangesFrom, $selectedWeightRangesTo);

            $products = $products->where(function ($query) use ($weightRanges) {
                foreach ($weightRanges as $range) {
                    $query->orWhere(function ($q) use ($range) {
                        $q->where('products.weight', '>=', $range['from'])
                            ->where('products.weight', '<=', $range['to']);
                    });
                }
            });
        }

        $products = $products->where('products.qty', '>', 0)
            ->orderBy('products.qty', 'DESC');

        // Pagination at DB level
        $perPage = $this->paginate ?? 20;
        $page = $request->get('page', 1);
        $paginated = $products->paginate($perPage, ['*'], 'page', $page);

        // Encrypt image filenames
        $secret = 'EmeraldAdmin';
        $paginated->getCollection()->transform(function ($product) use ($secret) {
            $product->secureFilename = $this->cryptoJsAesEncrypt($secret, $product->product_image);
            return $product;
        });

        // Fetch all relevant product IDs to reduce DB hits
        $productIds = $paginated->pluck('id')->toArray();

        $userId = Auth::user()->id;
        $cartItems = Cart::where('user_id', $userId)
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');

        $cart = [];
        $cartcount = [];
        $counter = $perPage * ($page - 1);

        foreach ($paginated as $product) {
            $productCartItems = $cartItems->get($product->id, collect());
            $cart[$counter] = $productCartItems;
            $cartcount[$counter] = $productCartItems->sum('qty');
            $counter++;
        }

        return response()->json([
            'weightrange' => $paginated,
            'cart' => $cart,
            'cartcount' => $cartcount,
            'stock' => $isFilterApplied ? 1 : null
        ]);
    }

    public function getItemwiseProduct(Request $request)
    {
        ini_set('max_execution_time', 1800); // 30 minutes

        $user_id = Auth::user()->id;
        $selectedItem = $request->input('selectedItem', []);
        $procategories = (array) $request->input('procategoryArray');
        $getItem = Product::whereIn('Item', $selectedItem)->pluck('Item')->toArray();

        $itemwiseproduct = $this->getproducts($user_id)
            ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->select(
                'products.*',
                'product_variants.id as productID',
                'product_variants.weight as variant_weight',
                'product_variants.purity as variant_purity',
                'product_variants.size as variant_size',
                'product_variants.style as variant_style',
                'product_variants.unit as variant_unit',
                'product_variants.color as variant_color',
                'product_variants.making as variant_making',
                'product_variants.qty as variant_qty'
            );

        if ($getItem) {
            $itemwiseproduct->whereIn('products.Item', $getItem)
                ->where('product_variants.qty', '>', 0);
        }

        if (!empty($request->project_id)) {
            $itemwiseproduct->where('products.Project', $request->project_id);
        }

        if (!empty(array_filter($procategories))) {
            $itemwiseproduct->whereIn('products.Procatgory', $procategories);
        }

        $selectedWeightRangesFrom = $request->input('weightfrom', []);
        $selectedWeightRangesTo = $request->input('weightto', []);
        if (!empty(array_filter($selectedWeightRangesFrom)) && !empty(array_filter($selectedWeightRangesTo))) {
            $itemwiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
                foreach ($selectedWeightRangesFrom as $index => $from) {
                    $to = $selectedWeightRangesTo[$index] ?? $from;
                    $query->orWhereBetween('product_variants.weight', [$from, $to]);
                }
            });
        }

        // Clone the query to calculate min and max weight
        $weightQuery = clone $itemwiseproduct;
        $minWeight = $weightQuery->min('product_variants.weight');
        $maxWeight = $weightQuery->max('product_variants.weight');

        $itemwiseproduct = $itemwiseproduct->orderBy('products.DesignNo', 'ASC');

        // Fetch all products first
        $rawProducts = $itemwiseproduct->get();
        $secret = 'EmeraldAdmin';

        // Group variants under each product
        $groupedProducts = $rawProducts->groupBy('id')->map(function ($items) use ($secret) {
            $base = $items->first();

            $base->variants = $items->map(function ($item) {
                return [
                    'productID' => $item->productID,
                    'Purity' => $item->variant_purity,
                    'color' => $item->variant_color,
                    'unit' => $item->variant_unit,
                    'style' => $item->variant_style,
                    'making' => $item->variant_making,
                    'size' => $item->variant_size,
                    'weight' => $item->variant_weight,
                    'qty' => $item->variant_qty,
                ];
            });

            $base->secureFilename = $this->cryptoJsAesEncrypt($secret, $base->product_image);
            $base->variant_count = $items->count();

            return $base;
        })->values();

        // Paginate
        $page = $request->get('page', 1);
        $perPage = $this->paginate ?? 50;

        $paginated = new LengthAwarePaginator(
            $groupedProducts->forPage($page, $perPage)->values(),
            $groupedProducts->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $itemwiseproduct = $paginated;

        // Ensure min <= max
        if ($minWeight > $maxWeight) {
            [$minWeight, $maxWeight] = [$maxWeight, $minWeight];
        }

        // Matching weights
        $matchingWeights = Weight::where('is_active', 1)
            ->whereNull('deleted_at')
            ->where(function ($query) use ($minWeight, $maxWeight) {
                $query->where('weight_range_from', '<=', $maxWeight)
                    ->where('weight_range_to', '>=', $minWeight);
            })
            ->pluck('id')
            ->toArray();

        $weights = Weight::whereIn('id', $matchingWeights)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->get();
        $weightJson = $weights->toJson();

        $defaultweights = Weight::where('is_active', 1)
            ->whereNull('deleted_at')
            ->get();
        $defaultweightJson = $defaultweights->toJson();

        // Procategory JSONs
        $procategoryIds = $itemwiseproduct->pluck('Procatgory')->filter()->unique()->toArray();

        $procategoryData = Product::join('product_variants', 'product_variants.product_id', '=', 'products.id')
            ->whereIn('products.Procatgory', $procategoryIds)
            ->whereNotNull('products.Procatgory')
            ->where('product_variants.qty', '>', 0)
            ->where('products.Procatgory', '!=', '')
            ->select('products.Procatgory', DB::raw('MIN(products.id) as id'))
            ->groupBy('products.Procatgory')
            ->get();

        $procategoryjson = $procategoryData->toJson();

        $procategoryDefaultData = Product::where('qty', '>', 0)
            ->whereNotNull('Procatgory')
            ->where('Procatgory', '!=', '')
            ->select('Procatgory', DB::raw('MIN(id) as id'))
            ->groupBy('Procatgory')
            ->get();
        $procategoryDefaultjson = $procategoryDefaultData->toJson();

        // Cart info
        $cart = [];
        $cartcount = [];
        $counter = $perPage * ($page - 1);

        foreach ($itemwiseproduct as $item) {
            $iscart = Cart::where('user_id', $user_id)
                ->where('product_id', $item->id)->get();

            $currentcart = Cart::where('user_id', $user_id)
                ->where('product_id', $item->id)->value('qty');

            $cart[$counter] = $iscart;
            $cartcount[$counter] = $currentcart;
            $counter++;
        }

        return response()->json([
            'itemwiseproduct' => $itemwiseproduct,
            'cart' => $cart,
            'cartcount' => $cartcount,
            'procategoryjson' => $procategoryjson,
            'procategoryDefaultjson' => $procategoryDefaultjson,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson
        ]);
    }


    public function getProcategorywiseProduct(Request $request)
    {
        ini_set('max_execution_time', 1800); //3 minutes
        $selectedprocategory = $request->input('selectedprocategory', []);
        $products = (array) $request->input('productArray');
        $getProcategory = Product::whereIn('Procatgory', $selectedprocategory)->pluck('Procatgory')->toArray();

        $procategorywiseproduct = $this->getproducts(Auth::user()->id);

        if ($getProcategory) {
            $procategorywiseproduct->whereIn('products.Procatgory', $getProcategory)
                ->where('products.qty', '>', 0);
        }

        if (!empty($request->project_id)) {
            $procategorywiseproduct = $procategorywiseproduct->where('products.Project', $request->project_id);
        }

        if (!empty(array_filter($products))) {
            $procategorywiseproduct = $procategorywiseproduct->whereIn('products.Item', $products);
        }

        $selectedWeightRangesFrom = $request->input('weightfrom', []);
        $selectedWeightRangesTo = $request->input('weightto', []);
        if (!empty(array_filter($selectedWeightRangesFrom)) && !empty(array_filter($selectedWeightRangesTo))) {
            // Ensure both arrays have elements
            if (!empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
                $procategorywiseproduct->where(function ($query) use ($selectedWeightRangesFrom, $selectedWeightRangesTo) {
                    foreach ($selectedWeightRangesFrom as $index => $from) {
                        $query->orWhereBetween('products.weight', [$from, $selectedWeightRangesTo[$index]]);
                    }
                });
            }
        }

        // Clone the query to calculate the min and max weight before paginating
        $weightQuery = clone $procategorywiseproduct;
        $minWeight = $weightQuery->min('products.weight');
        $maxWeight = $weightQuery->max('products.weight');

        $procategorywiseproduct = $procategorywiseproduct
            ->orderBy('products.DesignNo', 'ASC');

        $secret = 'EmeraldAdmin';

        $groupedProducts = $procategorywiseproduct->get()
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

        $procategorywiseproduct = $paginated;

        // Ensure min is always less than or equal to max
        if ($minWeight > $maxWeight) {
            [$minWeight, $maxWeight] = [$maxWeight, $minWeight];
        }

        // Get weights that match minWeight and maxWeight
        $matchingWeights = Weight::where('is_active', 1)
            ->whereNull('deleted_at')
            ->where(function ($query) use ($minWeight, $maxWeight) {
                $query->where('weight_range_from', '<=', $maxWeight)
                    ->where('weight_range_to', '>=', $minWeight);
            })
            ->pluck('id')
            ->toArray();

        $weights = Weight::whereIn('id', $matchingWeights)->where('is_active', 1)->whereNull('deleted_at')->get();
        $weightJson = $weights->toJson();

        $defaultweights = Weight::where('is_active', 1)->whereNull('deleted_at')->get();
        $defaultweightJson = $defaultweights->toJson();

        // Calculate the starting counter based on the current page
        $counter = 50 * ($page - 1);

        $cart = [];
        $cartcount = [];

        // Loop through products and add values to arrays
        foreach ($procategorywiseproduct as $item) {

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
            'procategorywiseproduct' => $procategorywiseproduct,
            'cart' => $cart,
            'cartcount' => $cartcount,
            'weightJson' => $weightJson,
            'defaultweightJson' => $defaultweightJson
        ]);
    }
}

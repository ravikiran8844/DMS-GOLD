<?php

namespace App\Http\Controllers\Retailer\EF;

use App\Enums\Projects;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Finish;
use App\Models\OrderDetail;
use App\Models\Product;
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
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ReadyStockController extends Controller
{
    private $paginate = 42;
    use Common;

    function search(Request $request)
    {
        ini_set('max_execution_time', 180); //3 minutes
        $search = $request->search;
        $searchSubstring = substr($search, 0, 4);

        $products = $this->getproducts(Auth::user()->id)
            ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL])
            ->where('products.qty', '>', 0)
            ->where(function ($query) use ($search) {
                $query->where('products.product_unique_id', 'like', '%' . $search . '%')
                    ->orWhere('products.product_name', 'like', '%' . $search . '%')
                    ->orWhere('products.keywordtags', 'like', '%' . $search . '%');
            })
            ->where('products.is_active', 1)
            ->get();

        if ($products->isEmpty()) {
            $product = $this->getproducts(Auth::user()->id)
                ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL])
                ->where('products.qty', '>', 0)
                ->where(function ($query) use ($searchSubstring) {
                    $query->where('products.product_unique_id', 'like', '%' . $searchSubstring . '%')
                        ->orWhere('products.product_name', 'like', '%' . $searchSubstring . '%')
                        ->orWhere('products.keywordtags', 'like', '%' . $searchSubstring . '%');
                })
                ->where('products.is_active', 1)
                ->orderBy('product_unique_id', 'ASC')
                ->paginate($this->paginate);
        } else {
            $product = $this->getproducts(Auth::user()->id)
                ->whereIn('products.project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL])
                ->where('products.qty', '>', 0)
                ->where(function ($query) use ($search) {
                    $query->where('products.product_unique_id', 'like', '%' . $search . '%')
                        ->orWhere('products.product_name', 'like', '%' . $search . '%')
                        ->orWhere('products.keywordtags', 'like', '%' . $search . '%');
                })
                ->where('products.is_active', 1)
                ->orderBy('product_unique_id', 'ASC')
                ->paginate($this->paginate);
        }

        $allProduct = Product::whereIn('project_id', [Projects::ELECTROFORMING, Projects::SOLIDIDOL])->get();
        $stock = 1;
        $breadcrum = null;
        $breadcrumUrl = null;
        $project_id = null;

        return view('retailer.readystock.readystock', compact('product', 'allProduct', 'stock', 'search', 'breadcrumUrl', 'breadcrum', 'project_id'));
    }

    function efReadyStock(Request $request)
    {
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
            ->orderBy('products.product_unique_id', 'ASC')
            ->paginate($this->paginate);

        $project_id = Projects::ELECTROFORMING;
        $allProduct = Product::select('id')->where('project_id', Projects::ELECTROFORMING)->get();
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
            ->orderBy('products.product_unique_id', "ASC")->paginate($this->paginate);
        $project_id = Projects::SOLIDIDOL;
        $allProduct = Product::select('id')->where('project_id', Projects::SOLIDIDOL)->get();
        $stock = 1;
        $breadcrum = 'SOLID Idol Ready Stock';
        $breadcrumUrl = route('retailersireadystock');
        $decryptedProjectId = Projects::SOLIDIDOL;
        $request->session()->forget('ret_ses');
        return view('retailer.readystock.readystock', compact('allProduct', 'product', 'decryptedProjectId', 'project_id', 'breadcrum', 'breadcrumUrl', 'stock'));
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

        $stock = 1;
        $relatedProducts = $this->getproducts(Auth::user()->id)->where('products.id', '!=', $decryptedId)->where('sub_collection_id', $product->sub_collection_id)->where('project_id', $product->project_id)->where('qty', '>', 0)->limit(20)->get();
        $sizes = Size::where('is_active', 1)->get();
        $weights = Weight::where('is_active', 1)->get();
        $colors = Color::where('is_active', 1)->whereNull('deleted_at')->get();
        $finishes = Finish::where('is_active', 1)->where('project_id', $product->project_id)->whereNull('deleted_at')->get();

        return view('retailer.readystock.productdetail', compact('product', 'sizes', 'weights', 'colors', 'finishes', 'stock', 'relatedProducts'));
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

                    $count = array(
                        'count' => $cartcount
                    );
                    $notification = array(
                        'message' => 'Added to Cart',
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

                $count = array(
                    'count' => $cartcount
                );
                $notification = array(
                    'message' => 'Added to Cart',
                    'alert' => 'success'
                );
            }

            DB::commit(); // Move this above the return statement

            return response()->json([
                'count_response' => $count,
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

                    $count = array(
                        'count' => $cartcount
                    );
                    $notification = array(
                        'message' => 'Added to Cart',
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

                $count = array(
                    'count' => $cartcount
                );
                $notification = array(
                    'message' => 'Added to Cart',
                    'alert' => 'success'
                );
            }

            DB::commit(); // Move this outside of the else block

            return response()->json([
                'count_response' => $count,
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
                            'message' => 'The ' . $request->qty . ' quantity already so you cant add more than ' . $stock . ' stock ',
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

                        $count = array(
                            'count' => $cartcount
                        );
                        $notification = array(
                            'message' => 'Added to Cart',
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
                        'message' => 'Added to Cart',
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
                'message' => 'Added all products to the cart',
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
                    $notification = array('message' => 'Added to Cart', 'alert' => 'success');
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

            $notification = ['message' => 'Added all products to the cart', 'alert' => 'success',];

            return response()->json(['count_response' => $count, 'notification_response' => $notification,]);
        } catch (Exception $e) {
            // Rollback the transaction on exception
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array('message' => 'Something Went Wrong!', 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
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

            $classificationwiseproduct = $classificationwiseproduct->where('project_id', Projects::SOLIDIDOL)->where('qty', '>', 0)
                ->orderBy('products.id', 'ASC')
                ->paginate($this->paginate);

            $box = [];
            foreach ($classificationwiseproduct as $item) {
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                $box[] = $boxName;
            }

            $stock = 1;
            return response()->json([
                'classificationwiseproduct' => $classificationwiseproduct,
                'box' => $box,
                'stock' => $stock
            ]);
        }
    }

    public function weightrange(Request $request, $id)
    {
        $selectedWeightRangesFrom = (array) $request->input('selectedWeightRanges');
        $selectedWeightRangesTo = (array) $request->input('weightToArray');

        // Check if arrays are not empty
        if (!empty($id) && !empty($selectedWeightRangesFrom) && !empty($selectedWeightRangesTo)) {
            // Filter products based on selected weight IDs
            $weightrange = $this->getproducts(Auth::user()->id ?? 0);

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
	    if($request->session()->has('ret_ses')){	
	         $weightrange = $weightrange->where('products.crwsubcolcode', $request->session()->get('ret_ses'));
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

            $box = [];
            foreach ($weightrange as $item) {
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                $box[] = $boxName;
            }

            $previousUrl = URL::previous();
            $stock = 1;
            return response()->json([
                'weightrange' => $weightrange,
                'box' => $box,
                'stock' => $stock
            ]);
        } else {
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
                $weightrange = $weightrange->where('products.qty', '>', 0);
            }
            $weightrange = $weightrange->orderBy('products.id', 'ASC')
                ->paginate($this->paginate);

            $box = [];
            foreach ($weightrange as $item) {
                $boxName = Style::where('id', $item->style_id)
                    ->where('is_active', 1)
                    ->value('style_name');

                $box[] = $boxName;
            }

            $stock = 1;
            return response()->json([
                'weightrange' => $weightrange,
                'box' => $box,
                'stock' => $stock
            ]);
        }
    }

    public function collectionwiseproduct(Request $request, $id)
    {
        $selectedCollection = $request->input('selectedcollection', []);
        $getcollectionid = Collection::whereIn('collection_name', $selectedCollection)
            ->pluck('id');

        $collectionwiseproduct = $this->getproducts(Auth::user()->id ?? 0);
        Session::put('collectionwiseproduct', $getcollectionid);
        if ($getcollectionid->isNotEmpty()) {
            $collectionwiseproduct->whereIn('products.collection_id', $getcollectionid);
        }

        if ($request->stockid == 1) {
            $collectionwiseproduct = $collectionwiseproduct->where('products.qty', '>', 0);
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

        $box = [];
        foreach ($collectionwiseproduct as $item) {
            $boxName = Style::where('id', $item->style_id)
                ->where('is_active', 1)
                ->value('style_name');

            $box[] = $boxName;
        }
        $previousUrl = URL::previous();
        $stock = 1;
        return response()->json([
            'collectionwiseproduct' => $collectionwiseproduct,
            'box' => $box,
            'stock' => $stock
        ]);
    }

    public function subcollectionwiseproduct(Request $request, $id)
    {
        $selectedSubCollection = $request->input('selectedsubcollection', []);
        $getsubcollectionid = SubCollection::whereIn('sub_collection_name', $selectedSubCollection)
            ->pluck('id');

        $subcollectionwiseproduct = $this->getproducts(Auth::user()->id ?? 0);

        Session::put('selectedSubCollection', $selectedSubCollection);

        if ($getsubcollectionid->isNotEmpty()) {
            $subcollectionwiseproduct->whereIn('products.sub_collection_id', $getsubcollectionid);
        }

        if ($request->stockid == 1) {
            $subcollectionwiseproduct = $subcollectionwiseproduct->where('products.qty', '>', 0);
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

        $box = [];
        foreach ($subcollectionwiseproduct as $item) {
            $boxName = Style::where('id', $item->style_id)
                ->where('is_active', 1)
                ->value('style_name');

            $box[] = $boxName;
        }
        $previousUrl = URL::previous();
        $stock = 1;
        return response()->json([
            'subcollectionwiseproduct' => $subcollectionwiseproduct,
            'box' => $box,
            'stock' => $stock
        ]);
    }
}

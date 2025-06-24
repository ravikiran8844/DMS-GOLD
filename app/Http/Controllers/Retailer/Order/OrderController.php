<?php

namespace App\Http\Controllers\Retailer\Order;

use App\Enums\Roles;
use App\Enums\Status;
use App\Exports\ApprovedOrderExport;
use App\Exports\RetailerOrderExport;
use App\Exports\RetailerOrderExportWithoutImage;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrder;
use App\Mail\OrderPlaced;
use App\Mail\RetailerOrderMail;
use App\Mail\RetailerOrderWithoutImageMail;
use App\Models\Cart;
use App\Models\Log;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderSetting;
use App\Models\Product;
use App\Models\Status as ModelsStatus;
use App\Models\User;
use App\Traits\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    use Common;

    public function placeOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = OrderSetting::first();
            $prefix = $data->prefix ?? 0;
            $length = $data->length ?? 0;
            $live = (int)($data->live ?? 0) + 1;

            if ($live) {
                $number = $live;
            }

            $man = sprintf("%0{$length}d", $number);
            $order_no = $prefix . $man;
            $orderno = $order_no;

            // Check for existing order with the same order_no
            if (Order::where('order_no', $order_no)->exists()) {
                $orderno = Order::where('order_no', $order_no)->value('order_no');
                $notification = [
                    'message' => 'Order Placed Successfully',
                    'alert' => 'success'
                ];

                return view('retailer.thanks.thanks', compact('orderno'))->with($notification);
            }

            // Validate cart items' quantities
            $cartItems = Cart::where('user_id', Auth::user()->id)->get();
            $insufficientProducts = [];

            foreach ($cartItems as $cart) {
                $product = Product::where('id', $cart->product_id)->first();
                if ($cart->qty > $product->qty) {
                    $insufficientProducts[] = $product->product_unique_id;
                }
            }

            if (!empty($insufficientProducts)) {
                $insufficientProductsList = '<ul>';
                foreach ($insufficientProducts as $sku) {
                    $insufficientProductsList .= "<li><strong>$sku</strong></li>";
                }
                $insufficientProductsList .= '</ul>';

                $notification = [
                    'message' => 'Below SKU has went OUT OF STOCK:' . $insufficientProductsList,
                    'alert' => 'error'
                ];
                return redirect()->back()->with('notification', $notification);
            }

            // Create the new order
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'order_no' => $order_no,
                'expected_delivery_date' => Carbon::now()->addDays(7),
                'status_id' => Status::Starting,
                'totalweight' => $request->weight,
                'remarks' => $request->remark,
                'box' => $request->box,
                'others' => $request->others,
                'reference' => $request->reference,
                'assigned_dealer_id' => $request->preferredDealer,
                'zone_id' => Auth::user()->zone_id,
            ]);

            // Increment live order number in settings
            $data->live += 1;
            $data->save();

            foreach ($cartItems as $cart) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'box_id' => $cart->box_id,
                    'box_details' => $cart->box_details,
                    'others' => $cart->others,
                    'product_id' => $cart->product_id,
                    'qty' => $cart->qty,
                    'weight' => $cart->weight,
                    'size_id' => $request->input('size' . $cart->id),
                    'finish' => $request->input('finish' . $cart->id),
                    'remarks' => $cart->remarks,
                    'is_ready_stock' => $cart->is_ready_stock,
                ]);

                if (Auth::user()->role_id == Roles::CRM) {
                    // Decrement product stock if user is CRM
                    $product = Product::where('id', $cart->product_id)->first();
                    Product::where('id', $cart->product_id)->where('style_id', $product->style_id)->update([
                        'qty' => $product->qty - $cart->qty,
                    ]);
                }
            }

            Cart::where('user_id', Auth::user()->id)->delete();

            DB::commit();

            // Dispatch the job to handle email and Excel export in the background
            ProcessOrder::dispatch($order, Auth::user());

            $notification = [
                'message' => 'Order Placed Successfully',
                'alert' => 'success',
            ];

            return view('retailer.thanks.thanks', compact('order_no'))->with($notification);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = [
                'message' => 'Something Went Wrong!',
                'alert' => 'error',
            ];

            return redirect()->back()->with($notification);
        }
    }


    function orders()
    {
        return view('retailer.order.order');
    }

    function orderData(Request $request)
    {
        $order = "";
        $order = Order::select(
            'orders.id',
            'orders.order_no',
            'orders.totalweight',
            'orders.created_at',
            'orders.approved_invoice',
            'statuses.status',
            DB::raw('SUM(order_details.qty) as total_qty'),
            'users.name'
        )
            ->join('statuses', 'statuses.id', 'orders.status_id')
            ->join('order_details', 'order_details.order_id', 'orders.id')
            ->leftjoin('users', 'users.id', 'orders.assigned_dealer_id')
            ->where('orders.user_id', Auth::user()->id)
            ->whereRaw("DATE(orders.created_at) BETWEEN '{$request->startdate}' AND '{$request->enddate}'")
            ->groupBy(
                'orders.id',
                'orders.order_no',
                'orders.totalweight',
                'orders.created_at',
                'orders.approved_invoice',
                'statuses.status',
                'users.name'
            )->get();

        return datatables()->of($order)->addColumn('action', function ($row) {
            $html = "";
            $html = '<a class="text-success view-details-btn" href="orderdetail/' . encrypt($row->id) . '">View details</a>';
            return $html;
        })->addColumn('repeatOrders', function ($row) {
            $htmls = "";
            $htmls = encrypt($row->id);
            return $htmls;
        })->toJson();
    }

    function getOrderDetail($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('id', decrypt($order_id))->first();
        $status = ModelsStatus::where('id', $order->status_id)->first();
        $orderdetails = OrderDetail::select(
            'order_details.*',
            'products.product_unique_id',
            'products.product_image',
            'products.product_name',
            'colors.color_name',
            'projects.project_name',
            'styles.style_name'
        )
            ->join('products', 'products.id', 'order_details.product_id')
            ->join('colors', 'colors.id', 'products.color_id')
            ->join('styles', 'styles.id', 'products.style_id')
            ->join('projects', 'projects.id', 'products.project_id')
            ->where('order_details.order_id', decrypt($order_id))
            ->get();

        $totalWeight = 0;
        foreach ($orderdetails as $detail) {
            $totalWeight += $detail->qty * $detail->weight;
        }
        return view('retailer.order.orderdetail', compact('order', 'orderdetails', 'status', 'totalWeight'));
    }
}

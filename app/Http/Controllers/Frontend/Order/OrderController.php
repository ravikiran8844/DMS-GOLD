<?php

namespace App\Http\Controllers\Frontend\Order;

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

            // Check for existing order with the same order_no
            if (Order::where('order_no', $order_no)->exists()) {
                $orderno = Order::where('order_no', $order_no)->value('order_no');
                $notification = [
                    'message' => 'Order Placed Successfully',
                    'alert' => 'success'
                ];

                return view('dealer.thanks.thanks', compact('orderno'))->with($notification);
            }

            // Validate cart items' quantities
            $cartItems = Cart::where('user_id', Auth::user()->id)->get();
            // $insufficientProducts = [];

            // foreach ($cartItems as $cart) {
            //     $product = Product::where('id', $cart->product_id)->first();
            //     if ($cart->qty > $product->qty) {
            //         $insufficientProducts[] = $product->product_unique_id;
            //     }
            // }

            // if (!empty($insufficientProducts)) {
            //     $insufficientProductsList = '<ul>';
            //     foreach ($insufficientProducts as $sku) {
            //         $insufficientProductsList .= "<li><strong>$sku</strong></li>";
            //     }
            //     $insufficientProductsList .= '</ul>';

            //     $notification = [
            //         'message' => 'Below SKU has went OUT OF STOCK:' . $insufficientProductsList,
            //         'alert' => 'error'
            //     ];
            //     return redirect()->back()->with('notification', $notification);
            // }


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

            $data = OrderSetting::first();
            $data->live = (1 == 1 ? $data->live + 1 : $data->live - 1);
            $data->save();


            foreach ($cartItems as $cart) {
                $orderDetail =  OrderDetail::create([
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
                    'is_ready_stock' => $cart->is_ready_stock
                ]);
                if (Auth::user()->role_id == Roles::CRM) {
                    $product = Product::where('id', $cart->product_id)->first();
                    Product::where('id', $cart->product_id)->where('style_id', $product->style_id)->update([
                        'qty' => $product->qty - $cart->qty
                    ]);
                    $orderDetail->update([
                        'is_approved' => 1
                    ]);
                }
            }

            if (Auth::user()->role_id == Roles::CRM) {
                // Export order details to Excel
                $excelFileName = $order->order_no . '.xlsx';
                $excelFilePath = 'approvedinvoice/' . $excelFileName;

                $datas = OrderDetail::select('order_details.*', 'products.product_image', 'products.product_unique_id', 'orders.totalweight', 'orders.order_no', 'orders.remarks', 'orders.admin_remarks', 'dealer.name as dealer_name', 'orders.reference', 'users.name', 'users.email', 'users.mobile', 'users.address', 'users.district', 'users.pincode', 'styles.style_name')
                    ->join('orders', 'orders.id', 'order_details.order_id')
                    ->join('users', 'users.id', 'orders.user_id')
                    ->join('users as dealer', 'dealer.id', '=', 'orders.assigned_dealer_id')
                    ->join('products', 'products.id', 'order_details.product_id')
                    ->join('styles', 'styles.id', 'order_details.box_id')
                    ->where('orders.user_id', $order->user_id)
                    ->where('order_details.order_id', $order->id)
                    ->where('order_details.is_approved', 1)
                    ->get();
                // Return the order details as a collection
                Excel::store(new ApprovedOrderExport($datas, $order), $excelFilePath);

                // Update the invoice field in the Order table
                $order->update([
                    'approved_invoice' => $excelFilePath
                ]);
            }

            Cart::where('user_id', Auth::user()->id)->delete();

            // // Log the last order details
            // Log::info('Last Order Details:', $order->toArray());

            // Export order details to Excel
            // $excelFileName = $order->order_no . '.xlsx';
            // $excelFilePath = 'invoices/' . $excelFileName;
            // $excelFileNames = $order->order_no . '.xlsx';
            // $excelFilePaths = 'invoices/no-img/' . $excelFileNames;
            // $order_id = $order->id;
            $orderno = $order->order_no;

            // $datas = OrderDetail::select('order_details.*', 'products.product_image', 'products.product_unique_id', 'products.project_id', 'projects.project_name', 'orders.totalweight', 'orders.order_no', 'users.name', 'users.email', 'users.mobile', 'styles.style_name')
            //     ->join('orders', 'orders.id', 'order_details.order_id')
            //     ->join('users', 'users.id', 'orders.user_id')
            //     ->join('products', 'products.id', 'order_details.product_id')
            //     ->join('projects', 'projects.id', 'products.project_id')
            //     ->join('styles', 'styles.id', 'order_details.box_id')
            //     ->where('orders.user_id', Auth::user()->id)
            //     ->where('order_details.order_id', $order_id)
            //     ->get();

            // // Return the order details as a collection
            // Excel::store(new RetailerOrderExport($datas, $order), $excelFilePath);
            // Excel::store(new RetailerOrderExportWithoutImage($datas, $order), $excelFilePaths);

            // // Update the invoice field in the Order table
            // Order::where('id', $order->id)->update([
            //     'invoice_path' => $excelFilePath,
            //     'invoice' => $excelFilePaths,
            // ]);
            // try {
            //     $invoice = Order::where('id', $order->id)->value('invoice_path');
            //     $invoiceWithoutImage = Order::where('id', $order->id)->value('invoice');
            //     Mail::to(Auth::user()->email)->send(new RetailerOrderMail($datas, $invoice));

            //     $adminMail = User::where('role_id', Roles::Admin)->value('email');
            //     Mail::to($adminMail)->bcc('sundaram@brightbridgeinfotech.com')->send(new RetailerOrderMail($datas, $invoice));
            //     Mail::to($adminMail)->bcc('sundaram@brightbridgeinfotech.com')->send(new RetailerOrderWithoutImageMail($datas, $invoiceWithoutImage));
            // } catch (\Throwable $th) {
            //     $this->Log(__FUNCTION__, "POST", $th->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            //     $notification = [
            //         'message' => 'Your Network is not stable so, please try again',
            //         'alert' => 'error'
            //     ];
            //     return redirect()->back()->with($notification);
            // }

            DB::commit();

            // Dispatch the job to handle email and Excel export in the background
            ProcessOrder::dispatch($order, Auth::user());

            $notification = [
                'message' => 'Order Placed Successfully',
                'alert' => 'success'
            ];

            return view('dealer.thanks.thanks', compact('orderno'))->with($notification);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "POST", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = [
                'message' => 'Something Went Wrong!',
                'alert' => 'error'
            ];

            return redirect()->back()->with($notification);
        }
    }

    function orders()
    {
        return view('dealer.order.order');
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
        return view('dealer.order.orderdetail', compact('order', 'orderdetails', 'status', 'totalWeight'));
    }
}

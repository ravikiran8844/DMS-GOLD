<?php

namespace App\Http\Controllers\Backend\Order;

use App\Enums\Roles;
use App\Exports\ApprovedOrderExport;
use App\Exports\StockExport;
use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Traits\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    use Common;
    function order()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Orders')) {
            $dealer = User::select('id', 'name')->where('role_id', Roles::Dealer)->where('is_active', 1)->orderBy('name', 'ASC')->get();
            $users = User::where('role_id', Roles::Retailer)->get();
            $roles = Role::whereNotIn('id', [Roles::SuperAdmin, Roles::Admin])
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->get();
            $ordercount = Order::count();
            $orderweightcount = Order::sum('totalweight');
            $orderpiececount = Order::select('orders.*', 'order_details.qty')
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->sum('order_details.qty');
            $pendingorder = Order::join('users', 'users.id', '=', 'orders.user_id')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                ->where(function ($query) {
                    $query->where('users.role_id', Roles::Retailer)
                        ->orWhere('users.role_id', Roles::CRM)
                        ->orWhere('users.role_id', Roles::Dealer);
                })
                ->where('orders.assigned_dealer_id', null)
                ->where('orders.is_cancel', 0)
                ->distinct('orders.id')  // Distinct to ensure unique order count
                ->count('orders.id');
            $pendingweight = Order::where('orders.assigned_dealer_id', null)
                ->where('orders.is_cancel', 0)->sum('totalweight');
            $pendingpiece = Order::select('orders.*', 'order_details.qty')
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->where('orders.assigned_dealer_id', null)
                ->where('orders.is_cancel', 0)
                ->sum('order_details.qty');
            return view('backend.admin.order.order', compact('users', 'dealer', 'roles', 'ordercount', 'orderweightcount', 'orderpiececount', 'pendingorder', 'pendingweight', 'pendingpiece'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function orderData(Request $request)
    {
        $order = "";
        $order = Order::select(
            'orders.id',
            'orders.order_no',
            'orders.created_at',
            'orders.assigned_dealer_id',
            'orders.user_id',
            'orders.totalweight',
            'orders.invoice_path',
            'users.name',
            'users.mobile',
            'users.GST',
            'users.email',
            'users.address',
            'users.shop_name',
            'users.state',
            'users.pincode',
            'users.district',
            'users.dealer_details',
            'users.preferred_dealer_id',
            'users.role_id',
            'roles.role_name',
            DB::raw('SUM(order_details.qty) as totalqty')
        )
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->groupBy(
                'orders.id',
                'orders.order_no',
                'orders.created_at',
                'orders.assigned_dealer_id',
                'orders.user_id',
                'orders.totalweight',
                'orders.invoice_path',
                'users.name',
                'users.mobile',
                'users.GST',
                'users.email',
                'users.address',
                'users.shop_name',
                'users.state',
                'users.pincode',
                'users.district',
                'users.preferred_dealer_id',
                'users.role_id',
                'roles.role_name',
                'users.dealer_details'
            );

        if ($request->user_id > 0) {
            $order = $order->where('orders.user_id', $request->user_id);
        }
        if ($request->role_id == Roles::Dealer) {
            $order = $order->where('users.role_id', $request->role_id);
        }
        $order = $order->where(function ($query) {
            $query->where('users.role_id', Roles::Retailer)
                ->orWhere('users.role_id', Roles::CRM)
                ->orWhere('users.role_id', Roles::Dealer);
        })
            ->where('orders.assigned_dealer_id', null)
            ->where('orders.is_cancel', 0)
            ->orderBy('orders.id', 'DESC')
            ->get();

        // Product Details Query
        $productDetailsQuery = OrderDetail::select(
            'order_details.id as order_detail_id',
            'order_details.order_id',
            'products.product_unique_id',
            'products.product_name',
            'products.product_image',
            'products.id as product_id',
            'products.qty as available_qty',
            'products.weight',
            'order_details.qty as order_qty',
            'styles.style_name'
        )
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->join('styles', 'styles.id', '=', 'products.style_id')
            ->whereIn('order_details.order_id', $order->pluck('id'))
            ->get()
            ->groupBy('order_id');

        // Combining Results
        $orderData = $order->map(function ($order) use ($productDetailsQuery) {
            $order->products = $productDetailsQuery->get($order->id);
            return $order;
        });

        return datatables()->of($order)
            ->toJson();
    }

    function approvedOrder()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Approved Orders')) {
            $users = User::where('role_id', Roles::Retailer)->get();
            $roles = Role::whereNotIn('id', [Roles::SuperAdmin, Roles::Admin])
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->get();
            $ordercount = Order::where('orders.assigned_dealer_id', '!=', null)->where('orders.is_cancel', 0)->count();
            $orderweightcount = Order::where('orders.assigned_dealer_id', '!=', null)->where('orders.is_cancel', 0)->sum('totalweight');
            $orderpiececount = Order::select('orders.*', 'order_details.qty')
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->where('orders.assigned_dealer_id', '!=', null)->where('orders.is_cancel', 0)
                ->sum('order_details.qty');
            return view('backend.admin.order.approvedorder', compact('users', 'roles', 'ordercount', 'orderweightcount', 'orderpiececount'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function disApprovedOrder()
    {
        if ($this->permissionCheck(Auth::user()->id, 'Dis-Approved Orders')) {
            $users = User::where('role_id', Roles::Retailer)->get();
            $roles = Role::whereNotIn('id', [Roles::SuperAdmin, Roles::Admin])
                ->where('is_active', 1)
                ->whereNull('deleted_at')
                ->get();
            $ordercount = Order::where('orders.is_cancel', 1)->count();
            $orderweightcount = Order::where('orders.is_cancel', 1)->sum('totalweight');
            $orderpiececount = Order::select('orders.*', 'order_details.qty')
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->where('orders.is_cancel', 1)
                ->sum('order_details.qty');
            return view('backend.admin.order.disapprovedorder', compact('users', 'roles', 'ordercount', 'orderweightcount', 'orderpiececount'));
        } else {
            return view('backend.admin.error.restrict');
        }
    }

    function approvedOrderData(Request $request)
    {
        $order = "";
        $order = Order::select(
            'orders.id',
            'orders.order_no',
            'orders.created_at',
            'orders.assigned_dealer_id',
            'orders.user_id',
            'orders.totalweight',
            'orders.approved_invoice',
            'orders.admin_remarks',
            'users.name',
            DB::raw('(SELECT name FROM users WHERE id = orders.assigned_dealer_id) as dealer_name'),
            'users.mobile',
            'users.GST',
            'users.email',
            'users.address',
            'users.shop_name',
            'users.state',
            'users.pincode',
            'users.district',
            'users.dealer_details',
            'users.role_id',
            'roles.role_name',
            DB::raw('SUM(order_details.qty) as totalqty')
        )
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('users as dealers', 'dealers.id', '=', 'orders.assigned_dealer_id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->groupBy(
                'orders.id',
                'orders.order_no',
                'orders.created_at',
                'orders.assigned_dealer_id',
                'orders.user_id',
                'orders.totalweight',
                'orders.approved_invoice',
                'orders.admin_remarks',
                'users.name',
                'users.mobile',
                'users.GST',
                'users.email',
                'users.address',
                'users.shop_name',
                'users.state',
                'users.pincode',
                'users.district',
                'users.role_id',
                'roles.role_name',
                'users.dealer_details'
            );

        if ($request->user_id > 0) {
            $order = $order->where('orders.user_id', $request->user_id);
        }
        if ($request->role_id > 0) {
            $order = $order->where('users.role_id', $request->role_id);
        }

        // Corrected WHERE clause with parentheses
        $order = $order->where(function ($query) {
            $query->where('users.role_id', Roles::Retailer)
                ->orWhere('users.role_id', Roles::CRM)
                ->orWhere('users.role_id', Roles::Dealer);
        })
            ->where('orders.assigned_dealer_id', '!=', null)
            ->where('orders.is_cancel', 0)
            ->orderBy('orders.id', 'DESC')
            ->get();

        // Product Details Query
        $productDetailsQuery = OrderDetail::select(
            'order_details.id as order_detail_id',
            'order_details.order_id',
            'order_details.is_approved',
            'order_details.approved_qty',
            'products.product_unique_id',
            'products.product_name',
            'products.product_image',
            'products.id as product_id',
            'products.qty as available_qty',
            'products.weight',
            'order_details.qty as order_qty',
            'styles.style_name'
        )
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->join('styles', 'styles.id', '=', 'products.style_id')
            ->whereIn('order_details.order_id', $order->pluck('id'))
            ->get()
            ->groupBy('order_id');

        // Combining Results
        $orderData = $order->map(function ($order) use ($productDetailsQuery) {
            $order->products = $productDetailsQuery->get($order->id);
            return $order;
        });
        return datatables()->of($order)
            ->toJson();
    }

    function disApprovedOrderData(Request $request)
    {
        $order = "";
        $order = Order::select(
            'orders.id',
            'orders.order_no',
            'orders.created_at',
            'orders.user_id',
            'orders.totalweight',
            'orders.is_cancel',
            'orders.admin_remarks',
            'users.name',
            'users.mobile',
            'users.GST',
            'users.email',
            'users.address',
            'users.shop_name',
            'users.state',
            'users.pincode',
            'users.district',
            'users.dealer_details',
            'users.role_id',
            'roles.role_name',
            DB::raw('SUM(order_details.qty) as totalqty')
        )
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->groupBy(
                'orders.id',
                'orders.order_no',
                'orders.created_at',
                'orders.assigned_dealer_id',
                'orders.user_id',
                'orders.totalweight',
                'orders.is_cancel',
                'orders.admin_remarks',
                'users.name',
                'users.mobile',
                'users.GST',
                'users.email',
                'users.address',
                'users.shop_name',
                'users.state',
                'users.pincode',
                'users.district',
                'users.role_id',
                'roles.role_name',
                'users.dealer_details'
            );

        if ($request->user_id > 0) {
            $order = $order->where('orders.user_id', $request->user_id);
        }
        if ($request->role_id > 0) {
            $order = $order->where('users.role_id', $request->role_id);
        }
        // Corrected WHERE clause with parentheses
        $order = $order->where(function ($query) {
            $query->where('users.role_id', Roles::Retailer)
                ->orWhere('users.role_id', Roles::CRM)
                ->orWhere('users.role_id', Roles::Dealer);
        })
            ->where('orders.is_cancel', 1)
            ->orderBy('orders.id', 'DESC')
            ->get();


        // Product Details Query
        $productDetailsQuery = OrderDetail::select(
            'order_details.id as order_detail_id',
            'order_details.order_id',
            'order_details.is_approved',
            'order_details.qty as order_qty',
            'products.product_unique_id',
            'products.product_name',
            'products.product_image',
            'products.id as product_id',
            'products.qty as available_qty',
            'products.weight',
            'styles.style_name'
        )
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->join('styles', 'styles.id', '=', 'products.style_id')
            ->whereIn('order_details.order_id', $order->pluck('id'))
            ->get()
            ->groupBy('order_id');

        // Combining Results
        $orderData = $order->map(function ($order) use ($productDetailsQuery) {
            $order->products = $productDetailsQuery->get($order->id);
            return $order;
        });
        return datatables()->of($order)
            ->toJson();
    }

    public function markAllAsRead(Request $request)
    {
        // Update the is_view column for all notifications to 1
        Order::whereIn('id', $request->order_ids)->update(['is_viewed' => 1]);
        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function invoiceDownload($invoice)
    {
        // Add a slash after the 2nd and 6th character
        $formatted_invoice = substr($invoice, 0, 5) . '/' . substr($invoice, 5, 4) . '/' . substr($invoice, 9);

        $file_path = storage_path('app/approvedinvoice/' . $formatted_invoice . '.xlsx');

        // Check if the file exists
        if (file_exists($file_path)) {
            // Return a response to download the file
            return response()->download($file_path);
        } else {
            // Handle the case where the file does not exist
            abort(404, 'File not found');
        }
    }

    function orderInvoiceDownload($invoice)
    {
        // Add a slash after the 2nd and 6th character
        $formatted_invoice = substr($invoice, 0, 5) . '/' . substr($invoice, 5, 4) . '/' . substr($invoice, 9);
        $file_path = storage_path('app/invoices/' . $formatted_invoice . '.xlsx');

        // Check if the file exists
        if (file_exists($file_path)) {
            // Return a response to download the file
            return response()->download($file_path);
        } else {
            // Handle the case where the file does not exist
            abort(404, 'File not found');
        }
    }

    function approved(Request $request)
    {
        $productId = $request->productIds;
        $orderId = $request->order_id;
        $orderdetailId = $request->checkedValues;
        OrderDetail::whereIn('id', $orderdetailId)->update([
            'is_approved' => 1
        ]);

        $order = Order::find($orderId);
        $orderdetails = OrderDetail::whereIn('id', $orderdetailId)->whereIn('product_id', $productId)->get();

        foreach ($orderdetails as $orderdetail) {
            $product = Product::find($orderdetail->product_id);
            if ($product) {
                if ($product->qty < $orderdetail->qty) {
                    $orderdetail->update([
                        'approved_qty' => $product->qty
                    ]);
                    $product->update([
                        'qty' => 0
                    ]);
                } else {
                    $product->update([
                        'qty' => $product->qty - $orderdetail->qty
                    ]);
                }
            }
        }
        $order->update([
            'assigned_dealer_id' => $request->dealer,
            'admin_remarks' => $request->admin_remarks
        ]);
        $user = User::where('id', $order->user_id)->first();
        if ($user->preferred_dealer_id == null) {
            User::where('id', $order->user_id)->update([
                'preferred_dealer_id' => $request->dealer
            ]);
        }

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

        return response()->json(['message' => 'Order Approved successfully!']);
    }

    function cancel(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->update([
            'is_cancel' => 1,
            'admin_remarks' => $request->admin_remarks
        ]);

        return response()->json(['message' => 'Order Cancelled successfully!']);
    }

    function exportStock(Request $request)
    {
        try {
            // Generate the current date for the filename
            $date = Carbon::now()->format('Y-m-d');
            $filename = "stockreport_{$date}.xlsx";

            return Excel::download(new StockExport($request->stockexport), $filename);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => $e->getMessage(),
                'alert' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    // public function orderQuantity(Request $request)
    // {
    //     try {

    //     } catch (Exception $e) {
    //         $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    //     }
    // }
}

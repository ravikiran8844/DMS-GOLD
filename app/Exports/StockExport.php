<?php

namespace app\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class StockExport implements FromView
{
    protected $stockexport;

    public function __construct($stockexport)
    {
        $this->stockexport = $stockexport;
    }

    public function view(): View
    {
        $order = Order::join('order_details as od', 'od.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'od.product_id')
            ->join('users as dealer', 'dealer.id', '=', 'orders.assigned_dealer_id')
            ->join('users as retailer', 'retailer.id', '=', 'orders.user_id')
            ->leftJoin('styles', 'styles.id', '=', 'od.box_id')
            ->select(
                'products.product_unique_id',
                'retailer.name as retailer_name',
                'dealer.name as dealer_name',
                'od.qty',
                'od.weight',
                'od.approved_qty',
                'styles.style_name as box_name'
            )
            ->where('od.is_approved', 1)
            ->whereDate('orders.created_at', $this->stockexport)
            ->get();

        return view('exports.stock', [
            'order' => $order
        ]);
    }
}

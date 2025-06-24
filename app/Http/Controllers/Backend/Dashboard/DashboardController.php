<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Project;
use App\Models\Product;
use App\Models\User;
use App\Enums\Roles;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function dashboard(Request $request)
    {
        $projectCount = Project::count();
        $projectFilter = Project::get();
        $ordersDatas = Order::get();
        $ordersCount = $ordersDatas->count();
        $weightCount = $ordersDatas->sum('totalweight');
        $usersQuery = User::where('role_id', Roles::Dealer);
        $users = $usersQuery->count();
        $dealers = $usersQuery->get();
        $zones = Zone::get();


        $totalWeightMonthly = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(totalweight) as total_weight'),
            DB::raw("DATE_FORMAT(created_at,'%b  %Y') as month_name")
        )
            // ->where('user_id', Auth::user()->id)
            // ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('year', 'month', 'month_name')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Extract month names
        $monthNames = $totalWeightMonthly->pluck('month_name')->toArray();

        // Extract total weights
        $totalWeightMonthly = $totalWeightMonthly->pluck('total_weight')->toArray();


        return view('backend.admin.dashboard.dashboard', compact('ordersCount', 'weightCount', 'projectCount', 'projectFilter', 'users', 'dealers', 'zones', 'monthNames', 'totalWeightMonthly'));
    }

    function filters(Request $request)
    {
        $ordersDatas = Order::get();
        $filteredOrders = 0;
        $totalWeightSum = 0;
        $projectCount = 0;
        $todayProjects = 0; // Initialize today's project count
        $projects = 0;

        // Initialize projectIds array to store project ids for later use
        $projectIds = [];

        // Get today's date
        $today = Carbon::now()->startOfDay();

        // 1. Initially project count
        $initialProjectCount = Project::count();
        if ($request->dateFilter) {
            $dateRange = explode(' - ', $request->dateFilter);

            // $startDate = Carbon::createFromFormat('d-m-Y', $dateRange[0])->startOfDay();
            // $endDate = Carbon::createFromFormat('d-m-Y', $dateRange[1])->endOfDay();
            // $startDate = Carbon::createFromFormat('d/m/Y', $dateRange[0])->startOfDay();
            // $endDate = Carbon::createFromFormat('d/m/Y', $dateRange[1])->endOfDay();
            $date = Carbon::createFromFormat('d/m/Y', $dateRange[0]);
            $startDate = $date->format('d-m-Y');
            $date = Carbon::createFromFormat('d/m/Y', $dateRange[1]);
            $endDate = $date->format('d-m-Y');

            $startDate = Carbon::createFromFormat('d-m-Y', $startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('d-m-Y', $endDate)->endOfDay();

            $filteredOrders = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->join('projects', 'products.project_id', '=', 'projects.id')
                ->when($request->dealerId, function ($query) use ($request) {
                    $query->where('orders.user_id', $request->dealerId);
                })
                ->when($request->zoneFilter, function ($query) use ($request) {
                    $query->where('orders.zone_id', $request->zoneFilter);
                })
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->get();

            // Extract unique project IDs
            $projectIds = $filteredOrders->pluck('project_id')->unique()->toArray();
            // Retrieve projects based on project IDs
            $projects = Project::whereIn('id', $projectIds)->get();
            $projectCount = $projects->count();
            $totalWeightMonthly = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(totalweight) as total_weight'),
                DB::raw("DATE_FORMAT(created_at,'%b  %Y') as month_name")
            )
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('year', 'month', 'month_name')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        }


        $totalWeightSum = $filteredOrders->sum('totalweight');
        $filteredOrdersCount = $filteredOrders->count();

        $ordersCount = $ordersDatas->count();
        $weightCount = $ordersDatas->sum('totalweight');

        // Extract month names
        $monthNames = $totalWeightMonthly->pluck('month_name')->toArray();

        // Extract total weights
        $totalWeightMonthly = $totalWeightMonthly->pluck('total_weight')->toArray();


        return response([
            'ordersCount' => $ordersCount,
            'weightCount' => $weightCount,
            'projectCount' => $projectCount,
            'initialProjectCount' => $initialProjectCount,
            'todayProjects' => $todayProjects,
            'filteredOrders' => $filteredOrdersCount,
            'totalWeightSum' => $totalWeightSum,
            'ordermonthname' => $monthNames,
            'ordermonthweight' => $totalWeightMonthly,
        ]);
    }
    function dealer_dashboard()
    {
        return view('backend.admin.dashboard.dealer_dashboard');
    }
    function order_details()
    {
        return view('backend.admin.order.order_details');
    }
}

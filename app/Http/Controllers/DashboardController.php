<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'supplierCount' => Supplier::count(),
            'orderCount' => Order::count(),
            'revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'statusCounts' => Order::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status'),
            'lowStock' => Product::with('category')
                ->where('stock', '<=', Product::LOW_STOCK_LEVEL)
                ->orderBy('stock')
                ->take(8)
                ->get(),
            'recentOrders' => Order::withCount('items')->latest()->take(5)->get(),
        ]);
    }
}
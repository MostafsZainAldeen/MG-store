<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'products' => Product::query()->count(),
            'orders' => Order::query()->count(),
            'pending' => Order::query()->where('status', 'pending')->count(),
            'delivered' => Order::query()->where('status', 'delivered')->count(),
            'revenue' => Order::query()->where('status', 'delivered')->sum('total'),
        ];

        $recentOrders = Order::query()->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}

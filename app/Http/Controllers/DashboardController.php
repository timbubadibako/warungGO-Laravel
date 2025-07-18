<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Debt;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startDate = Carbon::now()->subDays(6);
        $endDate = Carbon::now();
        $period = CarbonPeriod::create($startDate, $endDate);

        // --- 1. DATA KARTU METRIK UTAMA ---
        $todaysRevenue = Order::whereDate('created_at', $today)->whereIn('status', ['paid', 'debt'])->sum('total_amount');
        $todaysProfit = OrderItem::whereHas('order', fn($q) => $q->whereDate('created_at', $today)->whereIn('status', ['paid', 'debt']))
            ->get()->sum(fn($item) => ($item->selling_price - $item->purchase_price) * $item->quantity);
        $todaysTransactions = Order::whereDate('created_at', $today)->count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<', 10)->orderBy('stock', 'asc')->take(5)->get();
        $totalSuppliers = \App\Models\Supplier::count();
        $recentPurchases = \App\Models\Purchase::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        // Monthly growth calculation
        $thisMonth = Carbon::now()->format('Y-m');
        $lastMonth = Carbon::now()->subMonth()->format('Y-m');
        $thisMonthRevenue = Order::where('status', 'paid')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');
        $lastMonthRevenue = Order::where('status', 'paid')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('total_amount');
        $monthlyGrowth = 0;
        $monthlyGrowthNominal = 0;
        if ($lastMonthRevenue > 0) {
            $monthlyGrowth = round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1);
            $monthlyGrowthNominal = $thisMonthRevenue - $lastMonthRevenue;
        } elseif ($thisMonthRevenue > 0) {
            $monthlyGrowth = 100;
            $monthlyGrowthNominal = $thisMonthRevenue;
        }
        $totalUnpaidDebts = Debt::where('status', 'unpaid')->sum('amount');

        // --- 2. DATA UNTUK SEMUA GRAFIK ---

        // A. Grafik Pendapatan & Keuntungan (Line Chart)
        $revenueData = Order::whereBetween('created_at', [$startDate, $endDate])->whereIn('status', ['paid', 'debt'])->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as revenue'))->groupBy('date')->get()->keyBy('date');
        $profitData = OrderItem::whereHas('order', fn($q) => $q->whereBetween('created_at', [$startDate, $endDate])->whereIn('status', ['paid', 'debt']))->join('orders', 'order_items.order_id', '=', 'orders.id')->select(DB::raw('DATE(orders.created_at) as date'), DB::raw('SUM((order_items.selling_price - order_items.purchase_price) * order_items.quantity) as profit'))->groupBy('date')->get()->keyBy('date');

        $revenueProfitChart = [];
        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $revenueProfitChart['labels'][] = $date->format('d M');
            $revenueProfitChart['revenue'][] = $revenueData->get($dateString)->revenue ?? 0;
            $revenueProfitChart['profit'][] = $profitData->get($dateString)->profit ?? 0;
        }

        // B. Grafik Barang Masuk vs Keluar (Bar Chart)
        $stockMovements = StockMovement::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at')->get()->groupBy(fn($date) => Carbon::parse($date->created_at)->format('Y-m-d'));
        $stockFlowChart = [];
        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $stockFlowChart['labels'][] = $date->format('d M');
            $stockFlowChart['in'][] = $stockMovements->get($dateString)?->where('type', 'in')->sum('quantity') ?? 0;
            $stockFlowChart['out'][] = abs($stockMovements->get($dateString)?->where('type', 'out')->sum('quantity') ?? 0);
        }

        // C. Grafik Produk Terlaris (Pie Chart)
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))->whereHas('order', fn($q) => $q->where('created_at', '>=', Carbon::now()->subDays(7)))->groupBy('product_id')->orderBy('total_quantity', 'desc')->with('product')->take(5)->get();
        $topProductsChart = [
            'labels' => $topProducts->pluck('product.name'),
            'data' => $topProducts->pluck('total_quantity'),
        ];

        // D. Grafik Jumlah Transaksi Harian (Line Chart)
        $dailyTransactions = Order::whereBetween('created_at', [$startDate, $endDate])->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))->groupBy('date')->get()->keyBy('date');
        $dailyTransactionsChart = [];
        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $dailyTransactionsChart['labels'][] = $date->format('d M');
            $dailyTransactionsChart['data'][] = $dailyTransactions->get($dateString)->count ?? 0;
        }

        // --- 3. DATA UNTUK DAFTAR (LIST) ---
        $recentOrders = Order::latest()->take(5)->get();


        // Calculate Category Performance
        $categoryPerformance = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(products.stock) as total_stock'),
                DB::raw('SUM(products.selling_price * products.stock) as total_revenue')
            )
            ->groupBy('categories.name')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->category_name,
                    'sales' => $item->total_stock,
                    'revenue' => $item->total_revenue,
                    'color' => $this->getCategoryColor($item->category_name),
                ];
            });

        // Recent Activities (dummy, can be made dynamic)
        $recentActivities = [
            ['action' => 'Penjualan', 'desc' => 'Transaksi #001234', 'time' => '2 menit lalu', 'icon' => 'dollar-sign', 'color' => 'green'],
            ['action' => 'Produk Baru', 'desc' => 'Teh Pucuk Harum ditambahkan', 'time' => '15 menit lalu', 'icon' => 'plus', 'color' => 'blue'],
            ['action' => 'Stok Update', 'desc' => 'Indomie Goreng -10 dus', 'time' => '1 jam lalu', 'icon' => 'package', 'color' => 'purple'],
            ['action' => 'Supplier Baru', 'desc' => 'PT Sumber Rejeki', 'time' => '3 jam lalu', 'icon' => 'users', 'color' => 'orange'],
        ];

        // --- MENGIRIM SEMUA DATA KE VIEW ---
        return view('dashboard', compact(
            'todaysRevenue', 'todaysProfit', 'todaysTransactions', 'totalProducts', 'lowStockProducts', 'totalSuppliers', 'recentPurchases', 'monthlyGrowth', 'monthlyGrowthNominal', 'totalUnpaidDebts',
            'revenueProfitChart', 'stockFlowChart', 'topProductsChart', 'dailyTransactionsChart',
            'topProducts', 'recentOrders', 'categoryPerformance', 'recentActivities'
        ));
    }

    public function dashboard()
    {
        $categoryPerformance = [
            ['name' => 'Makanan & Minuman', 'sales' => 45, 'revenue' => 850000, 'color' => 'bg-blue-500'],
            ['name' => 'Kebutuhan Sehari-hari', 'sales' => 32, 'revenue' => 620000, 'color' => 'bg-green-500'],
            ['name' => 'Snack & Cemilan', 'sales' => 28, 'revenue' => 420000, 'color' => 'bg-purple-500'],
            ['name' => 'Lainnya', 'sales' => 18, 'revenue' => 280000, 'color' => 'bg-orange-500'],
        ];

        $recentActivities = [
            ['action' => 'Penjualan', 'desc' => 'Transaksi #001234', 'time' => '2 menit lalu', 'icon' => 'dollar-sign', 'color' => 'green'],
            ['action' => 'Produk Baru', 'desc' => 'Teh Pucuk Harum ditambahkan', 'time' => '15 menit lalu', 'icon' => 'plus', 'color' => 'blue'],
            ['action' => 'Stok Update', 'desc' => 'Indomie Goreng -10 dus', 'time' => '1 jam lalu', 'icon' => 'package', 'color' => 'purple'],
            ['action' => 'Supplier Baru', 'desc' => 'PT Sumber Rejeki', 'time' => '3 jam lalu', 'icon' => 'users', 'color' => 'orange'],
        ];

        return view('dashboard', compact('categoryPerformance', 'recentActivities'));
    }

    private function getCategoryColor($categoryName)
    {
        $colors = [
            'Makanan & Minuman' => 'bg-blue-500',
            'Kebutuhan Sehari-hari' => 'bg-green-500',
            'Snack & Cemilan' => 'bg-purple-500',
            'Lainnya' => 'bg-orange-500',
        ];

        return $colors[$categoryName] ?? 'bg-gray-500';
    }
}

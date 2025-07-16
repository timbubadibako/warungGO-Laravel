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
        $lowStockProducts = Product::where('stock', '<', 10)->orderBy('stock', 'asc')->take(5)->get();
        $recentOrders = Order::latest()->take(5)->get();


        // --- MENGIRIM SEMUA DATA KE VIEW ---
        return view('dashboard', compact(
            'todaysRevenue', 'todaysProfit', 'todaysTransactions', 'totalUnpaidDebts',
            'revenueProfitChart', 'stockFlowChart', 'topProductsChart', 'dailyTransactionsChart',
            'topProducts', 'lowStockProducts', 'recentOrders'
        ));
    }
}

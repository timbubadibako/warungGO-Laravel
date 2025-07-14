<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Info Cepat Hari Ini
        $today = Carbon::today();

        $todaysRevenue = Order::whereDate('created_at', $today)->where('status', 'paid')->sum('total_amount');
        $todaysTransactions = Order::whereDate('created_at', $today)->count();

        // Keuntungan: (Harga Jual - Harga Beli) * Kuantitas
        $todaysProfit = OrderItem::whereHas('order', function ($query) use ($today) {
            $query->whereDate('created_at', $today)->where('status', 'paid');
        })->get()->sum(function($item) {
            return ($item->selling_price - $item->purchase_price) * $item->quantity;
        });

        // 2. Produk Terlaris (7 hari terakhir)
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
            })
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->with('product') // Eager load nama produk
            ->take(5)
            ->get();

        // 3. Data untuk Grafik Stok (7 hari terakhir)
        $stockMovements = StockMovement::where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('d M'); // Group by hari
            });

        $chartLabels = $stockMovements->keys();
        $stockIn = $stockMovements->map(fn($day) => $day->where('type', 'in')->sum('quantity'));
        $stockOut = $stockMovements->map(fn($day) => abs($day->where('type', 'out')->sum('quantity'))); // abs() untuk membuat nilai positif

        return view('dashboard', compact(
            'todaysRevenue',
            'todaysTransactions',
            'todaysProfit',
            'topProducts',
            'chartLabels',
            'stockIn',
            'stockOut'
        ));
    }
}

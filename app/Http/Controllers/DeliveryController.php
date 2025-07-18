<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        // Ambil semua order dengan tipe 'delivery' dengan relasi items dan produk
        $deliveries = Order::where('order_type', 'delivery')
                            ->with(['items.product', 'user'])
                            ->latest()
                            ->get();
        return view('deliveries.index', compact('deliveries'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'delivery_status' => 'required|string|in:pending,preparing,out_for_delivery,delivered,cancelled'
        ]);

        $order->update(['delivery_status' => $request->delivery_status]);

        $statusLabels = [
            'pending' => 'Menunggu',
            'preparing' => 'Sedang Diproses',
            'out_for_delivery' => 'Sedang Dikirim',
            'delivered' => 'Terkirim',
            'cancelled' => 'Dibatalkan'
        ];

        return redirect()->route('deliveries.index')
                        ->with('success', 'Status pengiriman berhasil diubah menjadi: ' . $statusLabels[$request->delivery_status]);
    }

    public function details(Order $order)
    {
        // Load relasi yang diperlukan
        $order->load(['items.product', 'user']);

        $html = view('deliveries.partials.detail', compact('order'))->render();
        
        return response()->json(['html' => $html]);
    }
}

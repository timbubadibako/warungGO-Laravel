<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        // Ambil semua order dengan tipe 'delivery'
        $deliveries = Order::where('order_type', 'delivery')
                            ->latest()
                            ->get();
        return view('deliveries.index', compact('deliveries'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['delivery_status' => 'required|string']);

        $order->update(['delivery_status' => $request->delivery_status]);

        return redirect()->route('deliveries.index');
    }
}

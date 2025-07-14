<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Order ID not found'], 400);
        }

        $order = Order::where('invoice_number', $orderId)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status order sesuai status Midtrans
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $order->status = 'paid';
        } elseif ($transactionStatus === 'pending') {
            $order->status = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->status = 'failed';
        }
        $order->save();

        return response()->json(['message' => 'Callback handled']);
    }
}

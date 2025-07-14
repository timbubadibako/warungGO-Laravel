<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function show(Order $order)
    {
        // Eager load relasi untuk data yang dibutuhkan di struk
        $order->load('items.product', 'user');

        return view('receipt.show', compact('order'));
    }
}

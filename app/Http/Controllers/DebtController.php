<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DebtController extends Controller
{
    public function index()
    {
        // Ambil semua hutang yang belum lunas, urutkan dari yang terbaru
        $unpaidDebts = Debt::where('status', 'unpaid')
                          ->with(['order.items.product', 'order.user'])
                          ->latest()
                          ->get();

        return view('debts.index', compact('unpaidDebts'));
    }

    public function pay(Debt $debt)
    {
        // Update status hutang menjadi 'paid' dan catat tanggal lunas
        $debt->update([
            'status' => 'paid',
            'paid_at' => Carbon::now()
        ]);

        // Update juga status order terkait menjadi 'paid'
        if ($debt->order) {
            $debt->order->update(['status' => 'paid']);
        }

        return redirect()->route('debts.index')
                        ->with('success', 'Hutang atas nama "' . $debt->customer_name . '" sebesar Rp ' . number_format($debt->amount, 0, ',', '.') . ' berhasil ditandai lunas!');
    }

    public function details(Debt $debt)
    {
        // Load relasi yang diperlukan
        $debt->load(['order.items.product', 'order.user']);

        $html = view('debts.partials.detail', compact('debt'))->render();
        
        return response()->json(['html' => $html]);
    }
}

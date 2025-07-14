<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // Menampilkan daftar semua pembelian
    public function index()
    {
        $purchases = Purchase::with('supplier')->latest()->get();
        return view('purchases.index', compact('purchases'));
    }

    // Menampilkan form untuk membuat nota pembelian baru
    public function create()
    {
        $suppliers = Supplier::all();
        return view('purchases.create', compact('suppliers'));
    }

    // Menyimpan nota pembelian baru (tanpa item)
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
        ]);

        $purchase = Purchase::create($request->all());

        // Langsung arahkan ke halaman detail untuk menambah item
        return redirect()->route('purchases.show', $purchase);
    }

    // Menampilkan detail satu pembelian (untuk menambah item)
    public function show(Purchase $purchase)
    {
        $products = Product::all();
        // Eager load relasi untuk efisiensi
        $purchase->load('items.product', 'supplier');
        return view('purchases.show', compact('purchase', 'products'));
    }

    // Method untuk menambah item ke nota pembelian
    public function addItem(Request $request, Purchase $purchase)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
        ]);

        // Tambahkan item ke pembelian
        $purchase->items()->create($request->all());

        // Update total harga di nota pembelian
        $totalAmount = $purchase->items->sum(function($item) {
            return $item->cost_price * $item->quantity;
        });
        $purchase->update(['total_amount' => $totalAmount]);

        return redirect()->route('purchases.show', $purchase);
    }

    // Method untuk menyelesaikan pembelian & menambah stok
    public function complete(Purchase $purchase)
    {
        // Gunakan transaction untuk memastikan semua query berhasil
        DB::transaction(function () use ($purchase) {
            foreach ($purchase->items as $item) {
                // Tambah stok produk
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();

                // !! TAMBAHKAN KODE INI UNTUK MENCATAT BARANG MASUK !!
                \App\Models\StockMovement::create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity, // Nilai positif untuk barang masuk
                    'type' => 'in',
                    'description' => 'Pembelian dari ' . $purchase->supplier->name
                ]);
            }

            // Ubah status pembelian menjadi 'completed'
            $purchase->update(['status' => 'completed']);
        });

        return redirect()->route('purchases.index');
    }


    public function destroy(Purchase $purchase)
    {
        // Hanya boleh hapus jika status masih 'pending'
        if ($purchase->status == 'pending') {
            $purchase->delete();
        }
        return redirect()->route('purchases.index');
    }
}

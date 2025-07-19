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
        $suppliers = Supplier::all();
        $products = Product::select('id', 'name', 'purchase_price')->get();
        return view('purchases.index', compact('purchases', 'suppliers', 'products'));
    }

    // Menampilkan form untuk membuat nota pembelian baru
    public function create()
    {
        $suppliers = Supplier::all();
        return view('purchases.create', compact('suppliers'));
    }

    // Menyimpan nota pembelian baru dengan items
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'status' => 'nullable|in:pending,completed',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        // Calculate total amount
        $totalAmount = 0;
        $items = $request->input('items');
        foreach ($items as $item) {
            $totalAmount += $item['quantity'] * $item['cost_price'];
        }

        // Create purchase
        $purchase = Purchase::create([
            'supplier_id' => $request->input('supplier_id'),
            'purchase_date' => $request->input('purchase_date'),
            'total_amount' => $totalAmount,
            'status' => $request->input('status') ?? 'pending',
        ]);

        // Create purchase items
        foreach ($items as $item) {
            $purchase->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'cost_price' => $item['cost_price'],
            ]);
        }

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully!');
    }

    // Menampilkan detail satu pembelian (untuk menambah item)
    public function show(Purchase $purchase)
    {
        $products = Product::all();
        // Eager load relasi untuk efisiensi
        $purchase->load('items.product', 'supplier');
        return view('purchases.show', compact('purchase', 'products'));
    }

    // Menampilkan form untuk mengedit pembelian
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::all();
        return view('purchases.edit', compact('purchase', 'suppliers'));
    }

    // Memperbarui pembelian
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:pending,completed',
        ]);

        $purchase->update([
            'supplier_id' => $request->input('supplier_id'),
            'purchase_date' => $request->input('purchase_date'),
            'total_amount' => $request->input('total_amount') ?? $purchase->total_amount,
            'status' => $request->input('status') ?? $purchase->status,
        ]);

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully!');
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

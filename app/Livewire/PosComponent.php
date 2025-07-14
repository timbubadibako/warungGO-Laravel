<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Midtrans\Snap;
use Midtrans\Config;

#[Layout('layouts.app')]
class PosComponent extends Component
{
    public $search = '';
    public $selectedCategory = 'all';
    public $scannedBarcode = ''; // <-- TAMBAHKAN INI
    public $cart = [];
    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;

    public $paymentMethod = 'cash'; // Nilai default
    public $orderType = 'in_store';

    // Properti untuk form delivery dan hutang
    public $customerName, $customerAddress, $customerPhone;

    public function mount()
    {
        $this->calculateTotals();
    }

    public function render()
    {
        $products = Product::where('name', 'like', '%'.$this->search.'%')
            ->when($this->selectedCategory != 'all', function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->get();

        $categories = Category::all();

        return view('livewire.pos-component', compact('products', 'categories'));
    }

    public function addItem($productId)
    {
        $product = Product::find($productId);
        if (!$product || $product->stock <= 0) return;

        if (isset($this->cart[$productId])) {
            // Cek stok sebelum menambah
            if ($product->stock > $this->cart[$productId]['quantity']) {
                $this->cart[$productId]['quantity']++;
            }
        } else {
            $this->cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->selling_price,
                'purchase_price' => $product->purchase_price,
                'quantity' => 1
            ];
        }
        $this->calculateTotals();
    }

    public function updateCartItem($productId, $action)
    {
        if (isset($this->cart[$productId])) {
            if ($action == 'plus') {
                $product = Product::find($productId);
                if ($product->stock > $this->cart[$productId]['quantity']) {
                    $this->cart[$productId]['quantity']++;
                }
            } elseif ($action == 'minus') {
                if ($this->cart[$productId]['quantity'] > 1) {
                    $this->cart[$productId]['quantity']--;
                } else {
                    unset($this->cart[$productId]);
                }
            } elseif ($action == 'remove') {
                unset($this->cart[$productId]);
            }
        }
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $this->tax = $this->subtotal * 0.11; // PPN 11%
        $this->total = $this->subtotal + $this->tax;
    }

    public function submitOrder()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        if (empty($this->cart)) {
            return;
        }

        if ($this->paymentMethod == 'debt') {
            $this->validate(['customerName' => 'required|string|max:255']);
        }

        if ($this->orderType == 'delivery') {
            $this->validate([
                'customerName' => 'required|string|max:255',
                'customerAddress' => 'required|string',
            ]);
        }

        // MIDTRANS: QRIS & DEBIT
        if (in_array($this->paymentMethod, ['qris', 'debit'])) {
            // Konfigurasi Midtrans Sandbox
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production', false);
            Config::$isSanitized = config('midtrans.is_sanitized', true);
            Config::$is3ds = config('midtrans.is_3ds', true);

            $params = [
                'transaction_details' => [
                    'order_id' => 'INV-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6)),
                    'gross_amount' => $this->total,
                ],
                'customer_details' => [
                    'first_name' => $this->customerName ?? 'Customer',
                    'email' => Auth::user()->email ?? 'customer@example.com',
                ],
                'enabled_payments' => $this->paymentMethod == 'qris' ? ['qris'] : ['credit_card'],
            ];

            $snapToken = Snap::getSnapToken($params);

            $this->dispatch('midtrans-pay', snapToken: $snapToken);
            return;
        }

        $order = null;
        DB::transaction(function () use (&$order) {
            $orderData = [
                'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6)),
                'user_id' => Auth::id(),
                'order_type' => $this->orderType,
                'sub_total' => $this->subtotal,
                'tax' => $this->tax,
                'total_amount' => $this->total,
                'payment_method' => $this->paymentMethod,
                'status' => ($this->paymentMethod == 'debt') ? 'debt' : 'paid',
            ];

            if (!empty($this->customerName)) {
                $orderData['customer_address'] = $this->customerAddress;
                $notes = 'Nama: ' . $this->customerName;
                if (!empty($this->customerPhone)) {
                    $notes .= ', Telp: ' . $this->customerPhone;
                }
                $orderData['customer_notes'] = $notes;
            }

            $order = Order::create($orderData);

            foreach ($this->cart as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'purchase_price' => $item['purchase_price'],
                    'selling_price' => $item['price'],
                ]);

                Product::find($item['product_id'])->decrement('stock', $item['quantity']);

                StockMovement::create([
                    'product_id' => $item['product_id'],
                    'quantity' => -$item['quantity'],
                    'type' => 'out',
                    'description' => 'Penjualan ' . $order->invoice_number,
                ]);
            }

            if ($order->status == 'debt') {
                $order->debt()->create([
                    'customer_name' => $this->customerName,
                    'customer_phone' => $this->customerPhone,
                    'amount' => $order->total_amount,
                ]);
            }
        });

        // Setelah transaksi sukses, HANYA lakukan redirect
        if ($order) {
            return $this->redirect(route('receipt.show', $order));
        }
    }

    // ... (di dalam class PosComponent)

    public function scanAndAddItem()
    {
        // Cari produk berdasarkan barcode
        $product = Product::where('barcode', $this->scannedBarcode)->first();

        if ($product) {
            // Jika produk ditemukan, panggil method addItem yang sudah ada
            $this->addItem($product->id);
        } else {
            // Jika tidak ditemukan, kirim pesan error
            session()->flash('error', 'Produk dengan barcode ini tidak ditemukan.');
        }

        // Kosongkan kembali input barcode agar siap untuk scan berikutnya
        $this->reset('scannedBarcode');
    }
}

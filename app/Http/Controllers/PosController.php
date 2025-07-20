<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Validate and clean cart data
     */
    private function validateCart($cart)
    {
        if (!is_array($cart)) {
            return [];
        }
        
        $validCart = [];
        foreach ($cart as $key => $item) {
            if (is_array($item) && 
                isset($item['name']) && 
                isset($item['price']) && 
                isset($item['quantity']) && 
                $item['quantity'] > 0 &&
                !empty($item['name'])) {
                $validCart[$key] = $item;
            }
        }
        
        return $validCart;
    }

    public function index(Request $request)
    {
        // Ambil filter & pencarian dari query string
        $selectedCategory = $request->input('category', 'all');
        $search = $request->input('search', '');
        $cart = $this->validateCart(session('cart', []));
        $categories = Category::all();

        $products = Product::when($selectedCategory !== 'all', function ($query) use ($selectedCategory) {
                $query->where('category_id', $selectedCategory);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->get();

        // Kalkulasi subtotal, tax, total dengan validasi yang aman
        $subtotal = collect($cart)->sum(function ($item) {
            // Validasi item untuk mencegah error array offset
            if (!is_array($item) || !isset($item['price']) || !isset($item['quantity'])) {
                return 0;
            }
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        });
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        return view('pos.index', compact(
            'products',
            'categories',
            'selectedCategory',
            'search',
            'cart',
            'subtotal',
            'tax',
            'total'
        ));
    }

    public function selectCategory(Request $request, $categoryId)
    {
        return redirect()->route('pos.index', [
            'category' => $categoryId,
        ]);
    }

    public function updateCart(Request $request)
    {
        $cart = $request->input('cart', []);
        $validCart = $this->validateCart($cart);
        
        session(['cart' => $validCart]);

        return response()->json(['status' => 'success']);
    }

    public function addToCart(Request $request, $productId)
    {
        $cart = session('cart', []);
        $product = Product::findOrFail($productId);

        if (isset($cart[$productId]) && is_array($cart[$productId])) {
            // Validasi existing cart item
            $currentQuantity = $cart[$productId]['quantity'] ?? 0;
            if ($product->stock > $currentQuantity) {
                $cart[$productId]['quantity'] = $currentQuantity + 1;
            }
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->selling_price,
                'purchase_price' => $product->purchase_price,
                'quantity' => 1,
                'stock' => $product->stock,
            ];
        }

        session(['cart' => $cart]);
        return back();
    }

    public function updateCartItem(Request $request, $productId)
    {
        $action = $request->input('action');
        $cart = session('cart', []);
        $product = Product::findOrFail($productId);

        if (isset($cart[$productId]) && is_array($cart[$productId])) {
            $currentQuantity = isset($cart[$productId]['quantity']) ? (int)$cart[$productId]['quantity'] : 0;
            
            if ($action == 'plus') {
                if ($product->stock > $currentQuantity) {
                    $cart[$productId]['quantity'] = $currentQuantity + 1;
                }
            } elseif ($action == 'minus') {
                if ($currentQuantity > 1) {
                    $cart[$productId]['quantity'] = $currentQuantity - 1;
                } else {
                    unset($cart[$productId]);
                }
            } elseif ($action == 'remove') {
                unset($cart[$productId]);
            }
        }

        session(['cart' => $cart]);
        return back();
    }

    public function clearCart()
    {
        session(['cart' => []]);
        return back()->with('success', 'Keranjang belanja telah dibersihkan.');
    }

    public function scanBarcode(Request $request)
    {
        $barcode = $request->input('scannedBarcode');
        $product = Product::where('barcode', $barcode)->first();

        if ($product) {
            return $this->addToCart($request, $product->id);
        } else {
            return back()->with('error', 'Produk dengan barcode ini tidak ditemukan.');
        }
    }

    public function checkout(Request $request)
    {
        $cart = $this->validateCart(session('cart', []));
        
        if (empty($cart)) {
            return redirect()->route('pos.index')->with('error', 'Keranjang kosong atau tidak valid.');
        }
        
        // Update session dengan cart yang sudah divalidasi
        session(['cart' => $cart]);
        
        $subtotal = collect($cart)->sum(function ($item) {
            // Validasi item untuk mencegah error array offset
            if (!is_array($item) || !isset($item['price']) || !isset($item['quantity'])) {
                return 0;
            }
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
        });
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        $paymentMethod = $request->input('paymentMethod', 'cash');
        $orderType = $request->input('orderType', 'in_store');
        $customerName = $request->input('customerName');
        $customerAddress = $request->input('customerAddress');
        $customerPhone = $request->input('customerPhone');
        $cashPaid = $request->input('cashPaid');
        $change = $request->input('change');

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Jika metode GET, tampilkan halaman checkout
        if ($request->isMethod('GET')) {
            return view('pos.checkout', compact('cart', 'subtotal', 'tax', 'total'));
        }

        // Validasi untuk pembayaran debt
        if ($paymentMethod == 'debt') {
            $request->validate([
                'customerName' => 'required|string|max:255'
            ]);
        }

        // Validasi untuk delivery
        if ($orderType == 'delivery') {
            $request->validate([
                'customerName' => 'required|string|max:255',
                'customerAddress' => 'required|string',
            ]);
        }

        // Validasi untuk pembayaran tunai
        if ($paymentMethod == 'cash' && $cashPaid) {
            if (floatval($cashPaid) < $total) {
                return back()->with('error', 'Uang yang dibayarkan kurang!');
            }
        }

        $order = null;
        DB::transaction(function () use (
            &$order, $cart, $subtotal, $tax, $total, $paymentMethod,
            $orderType, $customerName, $customerAddress, $customerPhone, $cashPaid, $change, $request
        ) {
            $orderData = [
                'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6)),
                'user_id' => Auth::id(),
                'order_type' => $orderType,
                'sub_total' => $subtotal,
                'tax' => $tax,
                'total_amount' => $total,
                'payment_method' => $paymentMethod,
                'status' => ($paymentMethod == 'debt') ? 'debt' : 'paid',
            ];

            if (!empty($customerName)) {
                $orderData['customer_address'] = $customerAddress;
                $notes = 'Nama: ' . $customerName;
                if (!empty($customerPhone)) {
                    $notes .= ', Telp: ' . $customerPhone;
                }
                $orderData['customer_notes'] = $notes;
            }

            $order = Order::create($orderData);

            foreach ($cart as $item) {
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
                    'customer_name' => $customerName,
                    'customer_phone' => $customerPhone,
                    'amount' => $order->total_amount,
                ]);
            }
        });

        // Bersihkan cart setelah checkout
        session(['cart' => []]);

        // Redirect ke halaman receipt
        if ($order) {
            return redirect()->route('receipt.show', $order);
        }

        return back()->with('error', 'Gagal membuat pesanan.');
    }
}

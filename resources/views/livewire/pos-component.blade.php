<div style="display: flex; gap: 20px;">

    <div style="width: 60%;">
        <h2>Produk</h2>
        <div style="margin-bottom: 10px;">
            <input
                type="text"
                wire:model="scannedBarcode"
                wire:keydown.enter="scanAndAddItem"
                placeholder="Scan barcode di sini..."
                style="width:100%; padding: 8px; font-size: 1.2em;"
                autofocus
            >
            @if (session()->has('error'))
                <div style="color: red;">{{ session('error') }}</div>
            @endif
        </div>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..." style="width:100%; padding: 8px; margin-bottom: 10px;">
        <div>
            <button wire:click="$set('selectedCategory', 'all')">Semua</button>
            @foreach($categories as $category)
                <button wire:click="$set('selectedCategory', {{ $category->id }})">{{ $category->name }}</button>
            @endforeach
        </div>
        <hr>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; max-height: 70vh; overflow-y: auto;">
            @foreach($products as $product)
                <div wire:click="addItem({{ $product->id }})" style="border: 1px solid #ccc; padding: 10px; text-align:center; cursor:pointer;">
                    <strong>{{ $product->name }}</strong>
                    <p>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                    <small>Stok: {{ $product->stock }}</small>
                </div>
            @endforeach
        </div>
    </div>

    <div style="width: 40%; border-left: 1px solid #eee; padding-left: 20px;">
        <h2>Keranjang</h2>
        @if (session()->has('message'))
            <div style="color: green;">{{ session('message') }}</div>
        @endif

        <table border="1" style="width: 100%;" cellpadding="5">
            <tbody>
            @forelse($cart as $productId => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>
                        <button wire:click="updateCartItem({{ $productId }}, 'minus')">-</button>
                        {{ $item['quantity'] }}
                        <button wire:click="updateCartItem({{ $productId }}, 'plus')">+</button>
                    </td>
                    <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                    <td><button wire:click="updateCartItem({{ $productId }}, 'remove')" style="color:red;">X</button></td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center;">Keranjang kosong</td></tr>
            @endforelse
            </tbody>
        </table>

        <hr>

        <h3>Total</h3>
        <p>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
        <p>Pajak (11%): Rp {{ number_format($tax, 0, ',', '.') }}</p>
        <p><strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong></p>

        <hr>

        <form wire:submit.prevent="submitOrder">
            <div>
                <label>Tipe Pesanan:</label>
                <select wire:model.live="orderType">
                    <option value="in_store">Belanja Langsung</option>
                    <option value="delivery">Delivery</option>
                </select>
            </div>
            <br>
            <div>
                <label>Metode Pembayaran:</label>
                <select wire:model.live="paymentMethod">
                    <option value="cash">Tunai</option>
                    <option value="qris">QRIS</option>
                    <option value="debit">Kartu</option>
                    <option value="debt">Hutang</option>
                </select>
            </div>

            @if($orderType == 'delivery' || $paymentMethod == 'debt' || in_array($paymentMethod, ['qris','debit']))
                <hr>
                <h4>Data Pelanggan</h4>
                <div><label>Nama: <input type="text" wire:model="customerName"></label></div>
                @error('customerName') <span style="color:red">{{ $message }}</span> @enderror

                <div><label>Telepon: <input type="text" wire:model="customerPhone"></label></div>

                @if($orderType == 'delivery')
                <div><label>Alamat: <textarea wire:model="customerAddress"></textarea></label></div>
                @if ($errors->has('customerAddress')) <span style="color:red">{{ $errors->first('customerAddress') }}</span> @endif
                @endif
            @endif

            <br><br>
            <button type="submit" style="width: 100%; padding: 15px; background-color: green; color: white; border: none; font-size: 1.2em;">
                SUBMIT PESANAN
            </button>
        </form>
    </div>

</div>

@if (session('midtrans_snap_token'))
    <div>SNAP TOKEN: {{ session('midtrans_snap_token') }}</div>
@endif

{{-- filepath: resources/views/livewire/pos-component.blade.php --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    window.addEventListener('midtrans-pay', function(event) {
        snap.pay(event.detail.snapToken, {
            onSuccess: function(result){
                alert('Pembayaran berhasil!');
                window.location.reload();
            },
            onPending: function(result){
                alert('Silakan selesaikan pembayaran.');
            },
            onError: function(result){
                alert('Pembayaran gagal!');
            },
            onClose: function(){
                alert('Kamu menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>


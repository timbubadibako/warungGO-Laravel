<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan {{ $order->invoice_number }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 300px; margin: 0 auto; }
        .header, .footer { text-align: center; }
        .items table { width: 100%; border-collapse: collapse; }
        .items th, .items td { padding: 5px 0; }
        .items .price { text-align: right; }
        hr { border: none; border-top: 1px dashed #000; }
        .print-button { width: 100%; padding: 10px; margin-top: 20px; background: #333; color: #fff; border: none; cursor: pointer; }
        @media print {
            .print-button { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>WarungGo</h2>
        <p>Jl. Perumahan Laravel No. 11</p>
    </div>
    <hr>
    <p>
        No: {{ $order->invoice_number }}<br>
        Tgl: {{ $order->created_at->format('d/m/Y H:i') }}<br>
        Kasir: {{ $order->user->name }}
    </p>
    <hr>
    <div class="items">
        <table>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td colspan="3">{{ $item->product->name }}</td>
                </tr>
                <tr>
                    <td>{{ $item->quantity }} x {{ number_format($item->selling_price) }}</td>
                    <td class="price" colspan="2">{{ number_format($item->quantity * $item->selling_price) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <hr>
    <table>
        <tr>
            <td>Subtotal:</td>
            <td class="price">Rp {{ number_format($order->sub_total) }}</td>
        </tr>
        <tr>
            <td>Pajak:</td>
            <td class="price">Rp {{ number_format($order->tax) }}</td>
        </tr>
        <tr>
            <td><strong>Total:</strong></td>
            <td class="price"><strong>Rp {{ number_format($order->total_amount) }}</strong></td>
        </tr>
    </table>
    <hr>
    <div class="footer">
        <p>Terima Kasih Telah Berbelanja!</p>
    </div>

    <button class="print-button" onclick="window.print()">Cetak Struk</button>

    <script>
        Optional: langsung cetak saat halaman dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>

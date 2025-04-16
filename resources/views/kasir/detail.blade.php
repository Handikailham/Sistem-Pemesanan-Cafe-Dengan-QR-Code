<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .box { max-width: 600px; margin: auto; background: #f9f9f9; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Detail Transaksi</h2>

        <p><strong>Nama:</strong> {{ $transaksi->nama }}</p>
        <p><strong>No HP:</strong> {{ $transaksi->no_hp }}</p>
        <p><strong>No Meja:</strong> {{ $transaksi->order->meja->nomor ?? '-' }}</p>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($transaksi->order->orderDetails as $item)
                    @php $subtotal = $item->quantity * $item->price; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item->menu->nama }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total</th>
                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>

        <form action="{{ route('kasir.bayar', $transaksi->id) }}" method="POST">
            @csrf
            <input type="number" name="jumlah_dibayar" placeholder="Masukkan jumlah dibayar" required>
            <button type="submit">Bayar</button>
        </form>
    </div>
</body>
</html>

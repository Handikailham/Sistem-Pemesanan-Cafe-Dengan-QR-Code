<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
    </style>
</head>
<body>
    <div 
        class="min-h-screen bg-cover bg-center flex items-center justify-center px-4"
        style="background-image: url('{{ asset('images/geolig.jpg') }}');"
    >
        <div class="max-w-3xl bg-white bg-opacity-90 shadow-xl rounded-xl p-6 w-full">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">🧾 Detail Transaksi</h2>

            <div class="mb-6 space-y-2 text-gray-700">
                <p><strong>No Meja:</strong> {{ $transaksi->order->meja->nomor ?? '-' }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border border-gray-300 rounded">
                    <thead class="bg-yellow-100 text-gray-800">
                        <tr>
                            <th class="px-4 py-2 border">Menu</th>
                            <th class="px-4 py-2 border">Qty</th>
                            <th class="px-4 py-2 border">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @php $total = 0; @endphp
                        @foreach ($transaksi->order->orderDetails as $item)
                            @php $subtotal = $item->quantity * $item->price; $total += $subtotal; @endphp
                            <tr>
                                <td class="px-4 py-2 border">{{ $item->menu->nama }}</td>
                                <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 border">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-yellow-100 font-semibold">
                            <td colspan="2" class="px-4 py-2 border text-right">Total</td>
                            <td class="px-4 py-2 border">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <form action="{{ route('kasir.bayar', $transaksi->id) }}" method="POST" class="mt-6 space-y-3">
                @csrf
                <input type="number" name="jumlah_dibayar" placeholder="Masukkan jumlah dibayar" required class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded">
                    💵 Bayar
                </button>
            </form>
        </div>
    </div>
</body>
</html>

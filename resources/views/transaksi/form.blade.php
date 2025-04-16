<form action="{{ route('pesan.transaksi.store') }}" method="POST" onsubmit="return confirm('Proses pembayaran sekarang?')">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <input type="hidden" name="no_meja" value="{{ $order->meja->nomor }}" readonly>

    <!-- Ringkasan Pesanan -->
    <div class="bg-gray-100 p-4 rounded mb-6">
        <h2 class="text-xl font-semibold mb-3">🧾 Ringkasan Pesanan</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-1">Menu</th>
                    <th class="py-1 text-center">Jumlah</th>
                    <th class="py-1 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($order->orderDetails as $detail)
                    @php 
                        $subtotal = $detail->quantity * $detail->price;
                        $total += $subtotal;
                    @endphp
                    <tr class="border-b">
                        <td class="py-1">{{ $detail->menu->nama }}</td>
                        <td class="py-1 text-center">{{ $detail->quantity }}</td>
                        <td class="py-1 text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="font-semibold">
                    <td colspan="2" class="pt-3 text-right">Total:</td>
                    <td class="pt-3 text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Form Transaksi -->
    <div class="bg-white p-4 rounded shadow-md space-y-4">
        <div>
            <label class="block font-medium">Nama:</label>
            <input type="text" name="nama" required class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-medium">No HP:</label>
            <input type="text" name="no_hp" required class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-medium">Email (Opsional):</label>
            <input type="email" name="email" class="border rounded p-2 w-full">
        </div>

        <div>
            <label class="block font-medium">Metode Pembayaran:</label>
            <select name="metode_pembayaran" required class="border rounded p-2 w-full">
                <option value="online">Bayar Online</option>
                <option value="kasir">Bayar di Kasir</option>
            </select>
        </div>

        <button type="submit" class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition duration-200">
            💸 Bayar Sekarang
        </button>
    </div>

    <!-- Kode Pembayaran -->
    @if(isset($transaksi))
        <div class="bg-white p-6 mt-6 rounded shadow max-w-md mx-auto text-center">
            <h2 class="text-2xl font-bold mb-4">Kode Pembayaran</h2>
            <p class="text-xl bg-gray-100 p-4 rounded font-mono tracking-widest">
                {{ $transaksi->kode_pembayaran }}
            </p>
            <p class="mt-4 text-sm text-gray-600">Tunjukkan kode ini ke kasir untuk menyelesaikan pembayaran.</p>
        </div>
    @endif
</form>

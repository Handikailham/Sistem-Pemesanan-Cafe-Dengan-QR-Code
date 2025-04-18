
<div class="max-w-lg mx-auto mt-12 bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-6">🛒 Ringkasan Pesanan & Pembayaran</h2>

    {{-- Ringkasan Pesanan --}}
    <div class="bg-gray-100 p-4 rounded mb-6">
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
                @foreach($order->orderDetails as $d)
                    @php
                        $sub = $d->quantity * $d->price;
                        $total += $sub;
                    @endphp
                    <tr class="border-b">
                        <td class="py-1">{{ $d->menu->nama }}</td>
                        <td class="py-1 text-center">{{ $d->quantity }}</td>
                        <td class="py-1 text-right">Rp {{ number_format($sub,0,',','.') }}</td>
                    </tr>
                @endforeach
                <tr class="font-semibold">
                    <td colspan="2" class="pt-3 text-right">Total:</td>
                    <td class="pt-3 text-right">Rp {{ number_format($total,0,',','.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Form Pembayaran --}}
    <form action="{{ route('pesan.transaksi.store') }}" method="POST" onsubmit="return confirm('Proses pembayaran sekarang?')">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <div class="mb-4">
            <label class="block font-medium mb-1">Metode Pembayaran</label>
            <select name="metode_pembayaran" required
                class="border rounded p-2 w-full">
                <option value="online">Bayar Online</option>
                <option value="kasir">Bayar di Kasir</option>
            </select>
        </div>

        <button type="submit"
            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            💸 Bayar Sekarang
        </button>
    </form>
</div>

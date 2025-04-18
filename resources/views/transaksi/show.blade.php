
<div class="max-w-md mx-auto mt-12 bg-white p-6 rounded shadow text-center">
    <h2 class="text-2xl font-bold mb-4">✅ Transaksi Berhasil</h2>
    <p class="mb-2">Order #{{ $transaksi->order->id }} — Meja {{ $transaksi->order->meja->nomor }}</p>
    <div class="text-xl bg-gray-100 p-4 rounded font-mono tracking-widest mb-4">
        {{ $transaksi->kode_pembayaran }}
    </div>
    <p class="text-gray-600">Tunjukkan kode ini ke kasir untuk menyelesaikan pembayaran.</p>
    <a href="{{ route('pesan.index', ['nomor_meja' => $transaksi->order->meja->nomor]) }}"
       class="inline-block mt-6 text-green-600 hover:underline">
        ← Kembali ke Menu
    </a>
</div>


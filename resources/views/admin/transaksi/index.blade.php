<h1>Data Transaksi</h1>

@if (session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

<table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kode Pembayaran</th>
            <th>Meja</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transaksi as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->kode_pembayaran }}</td>
                <td>{{ $item->order->meja->nomor ?? '-' }}</td>
                <td>Rp {{ number_format($item->order->total(), 0, ',', '.') }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Belum ada transaksi</td>
            </tr>
        @endforelse
    </tbody>
</table>

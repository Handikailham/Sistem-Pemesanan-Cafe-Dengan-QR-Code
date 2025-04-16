<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pesanan - Meja #{{ $meja->nomor }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    {{-- NAVBAR --}}
    <nav class="bg-white shadow mb-6">
        <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
            <span class="font-bold text-xl">🍽️ CafeKita</span>
            <div class="space-x-4">
                <a href="{{ route('pesan.index', $meja->nomor) }}" class="text-gray-700 hover:text-blue-600 font-medium">Pesan</a>
                <a href="{{ route('keranjang.index', ['nomor_meja' => $meja->nomor]) }}" class="text-gray-700 hover:text-blue-600 font-medium">Keranjang</a>
                <a href="{{ route('pesan.status', $meja->nomor) }}" class="text-gray-700 hover:text-blue-600 font-medium">Status</a>
            </div>
        </div>
    </nav>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">📋 Status Pesanan - Meja #{{ $meja->nomor }}</h2>

        <table class="w-full table-auto border mb-6">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Menu</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanan as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->menu->nama }}</td>
                        <td class="px-4 py-2">{{ $item->jumlah }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-white text-sm {{
                                $item->status === 'menunggu' ? 'bg-gray-500' :
                                ($item->status === 'proses' ? 'bg-yellow-500' : 'bg-green-600') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $item->catatan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Belum ada pesanan untuk meja ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('pesan.index', $meja->nomor) }}" class="text-blue-500 hover:underline">← Kembali ke Menu</a>
    </div>
</body>
</html>

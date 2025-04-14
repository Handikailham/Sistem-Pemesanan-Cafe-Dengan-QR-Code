
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Pesan untuk Meja #{{ $meja->nomor }}</h1>

        @if ($menu->isEmpty())
            <p>Tidak ada menu yang tersedia saat ini.</p>
        @else
            <form action="" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($menu as $item)
                        <div class="border p-4 rounded shadow">
                            <h3 class="text-lg font-semibold">{{ $item->nama }}</h3>
                            <p class="text-sm">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600">{{ $item->deskripsi }}</p>

                            <label for="quantity_{{ $item->id }}" class="block text-sm mt-2">Jumlah</label>
                            <input type="number" id="quantity_{{ $item->id }}" name="quantity[{{ $item->id }}]" class="mt-1 block w-full border border-gray-300 p-2 rounded" min="1" value="1">

                            <button type="submit" class="mt-3 w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Tambah ke Keranjang
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 w-full">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </form>
        @endif
    </div>


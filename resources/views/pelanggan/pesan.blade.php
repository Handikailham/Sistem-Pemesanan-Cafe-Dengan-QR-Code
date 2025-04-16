<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan - Meja #{{ $meja->nomor }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/line-clamp@0.4.0" rel="stylesheet">
</head>
<body class="bg-gray-100">

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

    {{-- KONTEN --}}
    <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Pesan untuk Meja #{{ $meja->nomor }}</h1>
        @if ($menu->isEmpty())
            <p>Tidak ada menu yang tersedia saat ini.</p>
        @else
            <div class="flex overflow-x-auto space-x-6 pb-4">
                @foreach ($menu as $item)
                <div class="min-w-[250px] flex-shrink-0 border p-4 rounded shadow bg-white flex flex-col justify-between h-[400px]">
                    <div>
                        <img src="{{ asset('menu/' . $item->gambar) }}" alt="{{ $item->nama }}" 
                            class="w-full h-40 object-cover rounded mb-2">
                        
                        <h3 class="text-lg font-semibold">{{ $item->nama }}</h3>
                        <p class="text-sm">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600 line-clamp-3 h-12 overflow-hidden">
                            {{ $item->deskripsi }}
                        </p>
                    </div>
                
                    <form action="{{ route('pesan.add') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <input type="hidden" name="nomor_meja" value="{{ $meja->nomor }}">
                
                        <label for="quantity_{{ $item->id }}" class="block text-sm mt-1">Jumlah</label>
                        <input type="number" id="quantity_{{ $item->id }}" name="quantity" 
                            class="mt-1 block w-full border border-gray-300 p-2 rounded" min="1" value="1">
                
                        <button type="submit" class="mt-2 w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Tambah ke Keranjang
                        </button>
                    </form>
                </div>
                
                @endforeach
            </div>
        @endif
    </div>

<!-- MINI KERANJANG (Versi Tengah Bawah & Lebih Besar) -->
<div 
    onclick="window.location.href='{{ route('keranjang.index', ['nomor_meja' => $meja->nomor]) }}'" 
    class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-white border-2 border-blue-600 shadow-xl px-6 py-4 rounded-xl z-50 cursor-pointer hover:bg-blue-50 transition-all w-[300px]">

    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m13-9l2 9m-5-9v6m-4-6v6" />
            </svg>
            <div>
                <p class="text-lg font-semibold text-blue-800">Keranjang: 
                    <span class="font-bold">
                        {{ \App\Models\Keranjang::where('meja_id', $meja->id)->sum('jumlah') }} item
                    </span>
                </p>
                <p class="text-sm text-gray-700">
                    Total: 
                    <span class="font-bold text-green-600">
                        Rp {{ number_format(\App\Models\Keranjang::where('meja_id', $meja->id)->get()->sum(function($item) {
                            return $item->jumlah * $item->menu->harga;
                        }), 0, ',', '.') }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>



</body>
</html>

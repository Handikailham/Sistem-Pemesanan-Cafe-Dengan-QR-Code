<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan - Meja #{{ $meja->nomor }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/line-clamp@0.4.0" rel="stylesheet">
</head>
<body class="bg-gray-50">

    
    <!-- fixed navbar -->
    <nav class="fixed inset-x-0 top-0 bg-white shadow-sm z-20 py-3">

    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
      <!-- logo & brand -->
      <div class="flex items-center gap-4">
        <img src="{{ asset('images/scanbrewcafe.png') }}"
             alt="ScanBrew Logo"
             class="h-12 w-auto">
        <span class="text-3xl font-semibold text-gray-800 tracking-wide font-poppins">
          ScanBrew <span class="text-yellow-500">Cafe</span>
        </span>
      </div>
      <!-- nav links -->
     
    </div>
  </nav>

  <!-- spacer pushes all content below the fixed navbar -->
  <div class="h-20"></div>

  <!-- your page content -->
  <main class="max-w-6xl mx-auto px-6">
    <!-- Baris 1: Café dan Table Number -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      
      <!-- ScanBrew Café -->
      <a href="#"
         class="flex items-center justify-between bg-white p-4 rounded-lg shadow hover:shadow-md transition">
        <div>
          <h3 class="text-lg font-semibold text-gray-800">ScanBrew Café</h3>
          <p class="mt-1 text-sm text-gray-500">Open today, 10:00–11:00</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 text-gray-400"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>
  
      <!-- Table Number -->
      <div class="flex items-center justify-center bg-yellow-100 bg-opacity-50 p-4 rounded-lg shadow">
        <span class="text-lg font-medium text-gray-800">
          Table Number: {{ $meja->nomor }}
        </span>
      </div>
    </div>
  
    <!-- Baris 2: Pilih Kategori Menu - full width -->
    <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-lg font-semibold text-gray-800">Pilih Kategori Menu</h3>
          <p class="mt-1 text-sm text-gray-500">Lihat semua makanan & minuman</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 text-gray-400"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </div>
  
      
  </main>
  
      


    {{-- KONTEN --}}
    <div class="max-w-6xl mx-auto px-4 py-8">
       
    
        @if ($menu->isEmpty())
            <p class="text-center text-gray-500">Tidak ada menu yang tersedia saat ini.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($menu as $item)
                <div class="bg-white rounded-lg shadow-md transform transition hover:scale-105 hover:shadow-lg">
                    <img src="{{ asset('menu/' . $item->gambar) }}" alt="{{ $item->nama }}"
                         class="w-full h-40 object-cover rounded-t-lg">
    
                    <div class="p-5 flex flex-col justify-between h-[350px]">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $item->nama }}</h3>
                            <p class="text-yellow-600 font-semibold mb-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600 line-clamp-3 mb-4">{{ $item->deskripsi }}</p>
                        </div>
    
                        <form action="{{ route('pesan.add') }}" method="POST" class="flex flex-col">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="hidden" name="nomor_meja" value="{{ $meja->nomor }}">
    
                            <div class="flex items-center justify-between mb-3">
                                <label for="quantity_{{ $item->id }}" class="text-sm text-gray-700">Jumlah</label>
                                <input type="number" id="quantity_{{ $item->id }}" name="quantity"
                                       class="w-16 p-2 border border-gray-300 rounded-md"
                                       min="1" value="1">
                            </div>
    
                            <button type="submit"
                                    class="w-full border border-yellow-500 text-yellow-600 py-2 rounded-lg hover:bg-yellow-100 transition">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
    
      
{{-- MINI KERANJANG ATAU CLOSE BILL --}}
@if($cartCount > 0)
    {{-- Kalau ada item di keranjang --}}
    <div 
        onclick="window.location.href='{{ route('keranjang.index', ['nomor_meja' => $meja->nomor]) }}'" 
        class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-white border-2 border-yellow-500 shadow-xl px-6 py-4 rounded-2xl z-50 cursor-pointer hover:shadow-2xl hover:scale-105 transition-all duration-200 w-[320px]">

        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                {{-- ikon keranjang --}}
                <div class="bg-yellow-100 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m13-9l2 9m-5-9v6m-4-6v6" />
                    </svg>
                </div>

                <div>
                    <p class="text-base font-semibold text-yellow-800">
                        Keranjang: <span class="font-bold">{{ $cartCount }} item</span>
                    </p>
                    <p class="text-sm text-gray-700">
                        Total: <span class="font-bold text-green-600">
                            Rp {{ number_format($cartTotal, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

@elseif($orderPending)
    {{-- Kalau keranjang kosong tapi ada order pending --}}
    <form action="{{ route('pesan.closeBill') }}" method="POST" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 w-[320px] mt-4 z-50">
        @csrf
        <input type="hidden" name="meja_id" value="{{ $meja->id }}">
        <button type="submit"
                class="w-full bg-red-600 text-white px-6 py-3 rounded-2xl shadow-lg hover:bg-red-700 transition duration-200">
            Close Bill
        </button>
    </form>
@endif

</body>
</html>

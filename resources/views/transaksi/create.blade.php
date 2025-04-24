<!-- resources/views/pelanggan/transaksi/create.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran Pesanan #{{ $order->id }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-50">

  <div x-data="{ detailsOpen: false, feesOpen: false, roundOpen: false, method: 'kasir', showModal: false }"
       class="max-w-lg mx-auto mt-12 bg-white p-6 rounded-lg shadow">

       <nav class="fixed inset-x-0 top-0 bg-white shadow-sm z-20 py-3">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
          <div class="flex items-center gap-4">
            <img src="{{ asset('images/scanbrewcafe.png') }}" alt="ScanBrew Logo" class="h-12 w-auto">
            <span class="text-xl font-semibold text-gray-800 tracking-wide font-poppins">
              ScanBrew <span class="text-yellow-500">Cafe</span>
            </span>
          </div>
          {{-- Tambahkan nav links di sini jika perlu --}}
        </div>
      </nav>
  
      <div class="h-5"></div>

    <!-- Judul -->
    <h2 class="text-2xl font-bold mb-6">🛒 Ringkasan Pesanan & Pembayaran</h2>

    <!-- Detail Pembayaran -->
    <div class="border rounded-lg p-4 mb-8">
      <h3 class="font-semibold mb-4">Detail Pembayaran</h3>
      <div class="space-y-3 text-sm">

        <!-- Subtotal -->
        <button @click="detailsOpen = !detailsOpen" class="w-full flex justify-between items-center">
          <span>Subtotal ({{ $menuCount }} menu)</span>
          <div class="flex items-center space-x-2">
            <span>Rp {{ number_format($subTotal,0,',','.') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': detailsOpen}" class="h-4 w-4 text-gray-500 transition-transform" viewBox="0 0 24 24" stroke="currentColor" fill="none">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        </button>
        <div x-show="detailsOpen" x-cloak class="mt-2 space-y-2 text-xs text-gray-600">
          @foreach($order->orderDetails as $d)
          <div class="flex justify-between">
            <span>{{ $d->menu->nama }} x {{ $d->quantity }}</span>
            <span>Rp {{ number_format($d->quantity * $d->price,0,',','.') }}</span>
          </div>
          @endforeach
        </div>

        <div class="border-t border-dashed border-gray-200"></div>

        <!-- Biaya Tambahan -->
        <button @click="feesOpen = !feesOpen" class="w-full flex justify-between items-center">
          <span>Biaya Tambahan</span>
          <div class="flex items-center space-x-2">
            <span>Rp {{ number_format($serviceCharge + $pb1,0,',','.') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': feesOpen}" class="h-4 w-4 text-gray-500 transition-transform" viewBox="0 0 24 24" stroke="currentColor" fill="none">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        </button>
        <div x-show="feesOpen" x-cloak class="mt-2 space-y-2 text-xs text-gray-600">
          <div class="flex justify-between">
            <span>Service Charge (5%)</span>
            <span>Rp {{ number_format($serviceCharge,0,',','.') }}</span>
          </div>
          <div class="flex justify-between">
            <span>PB1 (10%)</span>
            <span>Rp {{ number_format($pb1,0,',','.') }}</span>
          </div>
        </div>

        <div class="border-t border-dashed border-gray-200"></div>

        <!-- Pembulatan -->
        <button @click="roundOpen = !roundOpen" class="w-full flex justify-between items-center">
          <span>Pembulatan</span>
          <div class="flex items-center space-x-2">
            <span>-Rp {{ number_format($roundingAmount,0,',','.') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': roundOpen}" class="h-4 w-4 text-gray-500 transition-transform" viewBox="0 0 24 24" stroke="currentColor" fill="none">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
        </button>
        <div x-show="roundOpen" x-cloak class="mt-2 text-xs text-gray-600">
          <p>Total sebelum bulat: Rp {{ number_format($grandTotal,0,',','.') }}</p>
          <p>Dibulatkan ke: Rp {{ number_format($roundedTotal,0,',','.') }}</p>
        </div>

        <div class="border-t border-dashed border-gray-200"></div>

        <!-- Total Akhir -->
        <div class="flex justify-between font-semibold text-lg">
          <span>Total Pembayaran</span>
          <span class="text-yellow-500">Rp {{ number_format($roundedTotal,0,',','.') }}</span>
        </div>
      </div>
    </div>

    <!-- Metode Pembayaran -->
    <div class="mb-6">
      <h3 class="font-semibold mb-3">Metode Pembayaran</h3>
      <div class="flex border rounded-lg overflow-hidden">
        <button @click="method='online'" :class="method==='online' ? 'bg-white text-gray-800 border border-gray-200 flex-1 py-2' : 'bg-gray-50 text-gray-500 flex-1 py-2'"><div class="flex items-center justify-center space-x-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg><span>Pembayaran Online</span></div></button>
        <button @click="method='kasir'" :class="method==='kasir' ? 'bg-white text-gray-800 border border-gray-200 flex-1 py-2' : 'bg-gray-50 text-gray-500 flex-1 py-2'"><div class="flex items-center justify-center space-x-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8M8 11h8m-7 4h6M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><span>Bayar di Kasir</span></div></button>
      </div>
      <div class="mt-6 text-center">
        <template x-if="method==='kasir'"><div><img src="{{ asset('images/cashier.png') }}" alt="Bayar di Kasir" class="mx-auto h-40"><p class="mt-4 text-gray-600">Klik ‘Bayar di Kasir’ dan tunjukkan kode kepada kasir.</p></div></template>
        <template x-if="method==='online'"><div><img src="{{ asset('images/coming-soon.png') }}" alt="Coming Soon" class="mx-auto h-40"><p class="mt-4 text-gray-600">Fitur pembayaran online akan segera hadir.</p></div></template>
      </div>
    </div>

    <!-- Form & Bottom Bar -->
    <form x-ref="form" action="{{ route('pesan.transaksi.store') }}" method="POST" class="relative">
      @csrf
      <input type="hidden" name="order_id" value="{{ $order->id }}">
      <input type="hidden" name="metode_pembayaran" :value="method">
      <div class="h-32"></div>
      <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg px-6 py-4 flex items-center justify-between z-40">
        <div><p class="text-sm text-gray-500">Total Pembayaran</p><p class="text-xl font-bold text-gray-900">Rp {{ number_format($roundedTotal,0,',','.') }}</p></div>
        <button type="button" @click="showModal = true" x-show="method==='kasir'" class="bg-yellow-500 text-white font-semibold px-5 py-2 rounded-lg hover:bg-yellow-600 transition">Bayar di Kasir</button>
      </div>
    </form>

    <!-- Bottom Sheet Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
    <div x-show="showModal" x-cloak x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition transform ease-in duration-200" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="fixed bottom-0 left-0 right-0 bg-white rounded-t-2xl p-6 shadow-xl z-50">
      <img src="{{ asset('images/ic-pay-now.svg') }}" alt="Konfirmasi" class="mx-auto h-32 mb-4">
      <p class="text-lg font-semibold mb-6 text-center">Proses pembayaran sekarang?</p>
      <div class="flex space-x-4">
        <button @click="showModal = false" class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-100 transition">Cek Lagi</button>
        <button @click="$refs.form.submit()" class="flex-1 bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition">Bayar Sekarang</button>
      </div>
    </div>

  </div>

</body>
</html>

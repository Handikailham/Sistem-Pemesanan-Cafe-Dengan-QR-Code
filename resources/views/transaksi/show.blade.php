<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Order Summary</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

  @php
    // Hitung breakdown langsung di view
    $details       = $transaksi->order->orderDetails;
    $subTotal      = $details->sum(fn($d) => $d->quantity * $d->price);
    $serviceCharge = round($subTotal * 0.05);
    $pb1           = round($subTotal * 0.10);
    $grandTotal    = $subTotal + $serviceCharge + $pb1;
    $roundedTotal  = floor($grandTotal / 500) * 500;
    $roundingAmt   = $grandTotal - $roundedTotal;
  @endphp

  <div class="max-w-md mx-auto mt-12 bg-white p-6 rounded-lg shadow">

    {{-- Judul --}}
    <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center">Order Summary</h2>

    {{-- QR Code --}}
    <div class="text-xl font-bold text-center p-4 rounded font-mono tracking-widest mb-4">
        {{ $transaksi->kode_pembayaran }}
    </div>
    

    {{-- Warning --}}
    <div class="flex items-center bg-yellow-50 border border-yellow-200 text-yellow-700 text-sm rounded px-3 py-2 mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01M5.07 19h13.86c1.05 0 1.7-1.14 1.2-2.05L13.2 4.95c-.5-.9-1.78-.9-2.28 0L3.87 16.95C3.37 17.86 4.02 19 5.07 19z"/>
      </svg>
      <span>Tunjukan Kode Pembayaran Ke Kasir</span>
    </div>

    <hr class="border-gray-200 mb-6">

    {{-- Daftar Item --}}
    <div class="space-y-3 mb-6 text-left">
      @foreach($details as $d)
      <div class="flex justify-between">
        <div>
          <span class="font-medium">{{ $d->quantity }}×</span>
          <span>{{ strtoupper($d->menu->nama) }}</span>
        </div>
        <div class="text-gray-700">
          Rp{{ number_format($d->quantity * $d->price, 0, ',', '.') }}
        </div>
      </div>
      @endforeach
    </div>

    <hr class="border-gray-200 mb-4">

    {{-- Ringkasan Biaya --}}
    <div class="text-sm text-gray-600 mb-2 flex justify-between">
      <span>Subtotal ({{ $details->count() }} menu)</span>
      <span>Rp{{ number_format($subTotal,    0, ',', '.') }}</span>
    </div>
    <div class="text-sm text-gray-600 mb-2 flex justify-between">
      <span>Pembulatan</span>
      <span class="-ml-4">−Rp{{ number_format($roundingAmt,  0, ',', '.') }}</span>
    </div>

    {{-- Other Fees (expandable jika mau) --}}
    <div x-data="{ open: false }" class="text-sm text-gray-600 mb-4">
      <button
        @click="open = !open"
        class="w-full flex justify-between items-center"
      >
        <span>Biaya Tambahan</span>
        <div class="flex items-center space-x-1">
          <span>Rp{{ number_format($serviceCharge + $pb1, 0, ',', '.') }}</span>
          <svg xmlns="http://www.w3.org/2000/svg"
               :class="{ 'rotate-180': open }"
               class="h-4 w-4 text-gray-500 transition-transform"
               fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
          </svg>
        </div>
      </button>
      <div x-show="open" x-cloak class="mt-2 space-y-1 pl-4 text-xs text-gray-500">
        <div class="flex justify-between">
          <span>Service Charge</span>
          <span>Rp{{ number_format($serviceCharge, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
          <span>PB1</span>
          <span>Rp{{ number_format($pb1,          0, ',', '.') }}</span>
        </div>
      </div>
    </div>

    <hr class="border-gray-200 mb-4">

    {{-- Total --}}
    <div class="flex justify-between items-center mb-6">
      <span class="font-semibold">Total</span>
      <span class="text-lg font-bold text-red-600">
        Rp{{ number_format($roundedTotal, 0, ',', '.') }}
      </span>
    </div>

    {{-- Button New Order --}}
    <a href="{{ route('pesan.index', ['nomor_meja' => $transaksi->order->meja->nomor]) }}"
       class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 rounded-lg transition text-center">
      New Order
    </a>
  </div>

  {{-- Alpine untuk expandable other fees --}}
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesan - Meja #{{ $meja->nomor }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/@tailwindcss/line-clamp@0.4.0" rel="stylesheet">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">

  {{-- FIXED NAVBAR --}}
  <nav class="fixed inset-x-0 top-0 bg-white shadow-sm z-20 py-3">
    <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
      <div class="flex items-center gap-4">
        <img src="{{ asset('images/scanbrewcafe.png') }}" alt="ScanBrew Logo" class="h-12 w-auto">
        <span class="text-xl font-semibold text-gray-800 tracking-wide font-poppins">
          ScanBrew <span class="text-yellow-500">Cafe</span>
        </span>
      </div>
    </div>
  </nav>
  <div class="h-20"></div> {{-- spacer untuk navbar --}}

  <main class="max-w-6xl mx-auto px-6 pb-32">

    {{-- BARIS 1: Café & Table Number --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <a href="#" class="flex items-center justify-between bg-white p-4 rounded-lg shadow hover:shadow-md transition">
        <div>
          <h3 class="text-lg font-semibold text-gray-800">ScanBrew Café</h3>
          <p class="mt-1 text-sm text-gray-500">Open today, 10:00–11:00</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>
      <div class="flex items-center justify-center bg-yellow-100 bg-opacity-50 p-4 rounded-lg shadow">
        <span class="text-lg font-medium text-gray-800">
          Table Number: {{ $meja->nomor }}
        </span>
      </div>
    </div>


    {{-- GRID PRODUK & MINI-KERANJANG DALAM ALPINE ROOT --}}
    <div x-data="pesanApp()" x-init="init()" class="space-y-8">

      {{-- TAB KATEGORI --}}
<div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition mb-8">
    <div class="flex justify-center space-x-6 border-b pb-2">
      <button
        @click="setKategori('semua')"
        :class="kategoriAktif === 'semua'
          ? 'text-gray-900 font-semibold border-b-2 border-yellow-500 pb-1'
          : 'text-gray-500'"
        class="transition text-center"
      >Semua</button>
  
      <button
        @click="setKategori('makanan')"
        :class="kategoriAktif === 'makanan'
          ? 'text-gray-900 font-semibold border-b-2 border-yellow-500 pb-1'
          : 'text-gray-500'"
        class="transition text-center"
      >Makanan</button>
  
      <button
        @click="setKategori('minuman')"
        :class="kategoriAktif === 'minuman'
          ? 'text-gray-900 font-semibold border-b-2 border-yellow-500 pb-1'
          : 'text-gray-500'"
        class="transition text-center"
      >Minuman</button>
    </div>
  </div>
  

      {{-- GRID PRODUK --}}
      <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse ($menu as $item)
          <div
            x-show="kategoriAktif === 'semua' || kategoriAktif === '{{ strtolower($item->kategori) }}'"
            x-transition
            x-data="itemCard({{ $item->id }})"
            :class="[
              'bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300',
              inCart ? 'border-b-4 border-yellow-500' : ''
            ]"
          >
            <img
              src="{{ asset('menu/' . $item->gambar) }}"
              alt="{{ $item->nama }}"
              class="w-full h-40 object-cover rounded-t-lg"
            >
            <div class="p-4 flex flex-col items-center text-center space-y-2">
              <h3 class="text-base font-semibold text-gray-800">{{ $item->nama }}</h3>
              <p class="text-base font-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>

              <template x-if="inCart">
                <div class="flex items-center space-x-2">
                  <button @click="decrease()" class="flex items-center justify-center h-8 w-8 rounded-full border border-black text-black hover:bg-black/10 transition">&minus;</button>
                  <span class="text-gray-800 font-semibold" x-text="jumlah"></span>
                  <button @click="increase()" class="flex items-center justify-center h-8 w-8 rounded-full border border-black text-black hover:bg-black/10 transition">&plus;</button>
                </div>
              </template>

              <template x-if="!inCart">
                <form action="{{ route('pesan.add') }}" method="POST" class="w-full">
                  @csrf
                  <input type="hidden" name="id" value="{{ $item->id }}">
                  <input type="hidden" name="nomor_meja" value="{{ $meja->nomor }}">
                  <button
                    type="submit"
                    class="w-full border-2 border-yellow-500 text-yellow-500 
                           font-semibold py-1 rounded-lg 
                           hover:bg-gray-100 transition-colors duration-200"
                  >
                    Add
                  </button>
                </form>
              </template>
            </div>
          </div>
        @empty
          <p class="text-center text-gray-500 col-span-full">Tidak ada menu yang tersedia saat ini.</p>
        @endforelse
      </div>

      {{-- MINI KERANJANG --}}
      <div
        x-show="totalItems > 0"
        @cart-updated.window="updateTotals()"
        @click="window.location.href='{{ route('keranjang.index', ['nomor_meja' => $meja->nomor]) }}'"
        class="fixed bottom-6 left-4 right-4 
               bg-yellow-500 text-white rounded-xl shadow-lg 
               flex items-center px-4 py-3 space-x-4 
               z-50 cursor-pointer hover:scale-105 transform transition"
      >
        <div class="relative flex-shrink-0 bg-white p-2 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m13-9l2 9m-5-9v6m-4-6v6" />
          </svg>
          <span 
            class="absolute -top-1 -right-1 bg-white text-black text-xs font-bold 
                   rounded-full h-5 w-5 flex items-center justify-center"
            x-text="totalItems"
          ></span>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium leading-tight">
            Total  
            <span class="block text-lg mt-1" x-text="formatCurrency(totalPrice)"></span>
          </p>
        </div>
        <span class="font-bold uppercase hover:underline">
          Check Out (<span x-text="totalItems"></span>)
        </span>
      </div>

      {{-- CLOSE BILL --}}
      @if($orderPending)
      <div
        x-show="totalItems === 0"
        class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg px-6 py-4 flex items-center justify-between z-50"
      >
        <div class="text-sm">
          <p class="text-gray-500">Tagihan</p>
          <p class="text-lg font-medium text-gray-900">
            Rp {{ number_format($previousTotal, 0, ',', '.') }}
          </p>
        </div>
        <form action="{{ route('pesan.closeBill') }}" method="POST" class="flex-shrink-0">
          @csrf
          <input type="hidden" name="meja_id" value="{{ $meja->id }}">
          <button type="submit"
                  class="bg-orange-500 text-white font-semibold px-5 py-2 rounded-lg hover:bg-orange-600 transition">
            Close Bill
          </button>
        </form>
      </div>
      @endif

    </div>
  </main>

  {{-- SCRIPTS --}}
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] =
      document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let keranjangRows = {!! json_encode(
      $keranjangItems->map(fn($i) => [
        'id'     => $i->id,
        'menuId' => $i->menu_id,
        'jumlah' => $i->jumlah,
        'harga'  => $i->menu->harga,
      ])->toArray()
    ) !!};

    function pesanApp() {
      return {
        keranjangRows,
        totalItems: 0,
        totalPrice: 0,

        // state & method filter kategori
        kategoriAktif: 'semua',
        setKategori(cat) {
          this.kategoriAktif = cat;
        },

        init() {
          this.updateTotals();
          window.addEventListener('cart-updated', () => {
            this.keranjangRows = keranjangRows;
            this.updateTotals();
          });
        },
        updateTotals() {
          this.totalItems = this.keranjangRows.reduce((sum, r) => sum + r.jumlah, 0);
          this.totalPrice = this.keranjangRows.reduce((sum, r) => sum + r.jumlah * r.harga, 0);
        },
        formatCurrency(val) {
          return 'Rp ' + val.toLocaleString();
        }
      }
    }

    function itemCard(menuId) {
      let row = keranjangRows.find(r => r.menuId === menuId) || null;
      return {
        inCart: row !== null,
        jumlah: row ? row.jumlah : 0,

        increase() {
          this.jumlah++;
          this.sync();
        },
        decrease() {
          if (this.jumlah > 1) {
            this.jumlah--;
            this.sync();
          } else {
            axios.post(`/keranjang/remove/${row.id}`)
              .then(() => {
                this.inCart = false;
                this.jumlah = 0;
                keranjangRows = keranjangRows.filter(r => r.id !== row.id);
                window.dispatchEvent(new CustomEvent('cart-updated'));
              });
          }
        },
        sync() {
          axios.post(`/keranjang/update/${row.id}`, { jumlah: this.jumlah })
            .then(() => {
              row.jumlah = this.jumlah;
              window.dispatchEvent(new CustomEvent('cart-updated'));
            });
        }
      }
    }
  </script>
</body>
</html>

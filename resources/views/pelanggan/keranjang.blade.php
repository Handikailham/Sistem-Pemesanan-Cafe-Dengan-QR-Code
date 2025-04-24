<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang - Meja #{{ $meja->nomor }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
  <div x-data="keranjangApp()" x-init="init()" class="relative">

    <!-- Navbar -->
    <nav class="fixed inset-x-0 top-0 bg-white shadow-sm z-20 py-3">
      <div class="max-w-6xl mx-auto px-6 flex items-center gap-4">
        <img src="{{ asset('images/scanbrewcafe.png') }}" alt="ScanBrew Logo" class="h-12 w-auto">
        <span class="text-xl font-semibold text-gray-800 tracking-wide font-poppins">
          ScanBrew <span class="text-yellow-500">Cafe</span>
        </span>
      </div>
    </nav>

    <div class="h-10"></div>

    <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow pb-32 space-y-6">

      <!-- Jika ada item di keranjang -->
      <template x-if="!isEmpty">
        <div>
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Keranjang Pesanan untuk Meja {{ $meja->nomor }}</h2>
            <a href="{{ route('pesan.index', ['nomor_meja' => $meja->nomor]) }}" class="border border-orange-500 text-orange-500 px-3 py-1 rounded hover:bg-orange-50 transition">
              + Tambah Item
            </a>
          </div>

          <!-- Daftar Item -->
          <div class="divide-y divide-gray-200">
            @foreach ($keranjang as $item)
            <div id="item-{{ $item->id }}" x-data="itemRow({{ $item->id }}, {{ $item->jumlah }}, {{ $item->menu->harga }}, '{{ $item->catatan }}')" x-init="$watch('jumlah', val => updateTotal()); $watch('subtotal', val => updateTotal())" class="py-4">
              <div class="flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">{{ $item->menu->nama }}</h3>
              </div>
              <div class="mt-1 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h6m-6 4h6m2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h7l5 5v7a2 2 0 01-2 2z"/>
                </svg>
                <input x-ref="catatanInput" type="text" x-model="catatan" @input.debounce.500ms="sendUpdate()" placeholder="Tinggalkan Catatan" class="w-full text-sm text-gray-700 placeholder-gray-400 bg-transparent focus:outline-none" />
              </div>
              <div class="flex justify-between items-center mt-3">
                <span class="font-semibold text-gray-900" x-text="'Rp ' + subtotal.toLocaleString()"></span>
                <div class="flex items-center space-x-2">
                  <button @click="decrease()" class="flex h-8 w-8 items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100 transition">−</button>
                  <span class="font-medium text-gray-800" x-text="jumlah"></span>
                  <button @click="increase()" class="flex h-8 w-8 items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100 transition">+</button>
                </div>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Subtotal -->
          <div class="text-right mt-4">
            <span class="text-gray-600">Subtotal:</span>
            <span class="text-xl font-bold text-gray-900" x-text="'Rp ' + total.toLocaleString()"></span>
          </div>

          <!-- Konfirmasi -->
          <form x-ref="confirmForm" action="{{ route('pesan.confirm') }}" method="POST" class="mt-4 text-right" x-show="!isEmpty">
            @csrf
            <input type="hidden" name="meja_id" value="{{ $meja->id }}">
            <button type="button" @click="showModal = true" class="bg-green-600 text-white px-6 py-3 rounded-lg w-full hover:bg-green-700 transition">
              Konfirmasi Pesanan
            </button>
          </form>
        </div>
      </template>

      <!-- Empty State -->
      <template x-if="isEmpty">
        <div class="flex flex-col items-center justify-center py-16 space-y-4">
          <img src="{{ asset('images/empty-cart.png') }}" alt="Keranjang Kosong" class="w-48 h-48">
          <h3 class="text-2xl font-semibold text-gray-800">Anda belum memesan apapun</h3>
          <p class="text-gray-500">Cari menu dan pesan sekarang.</p>
          <a href="{{ route('pesan.index', ['nomor_meja' => $meja->nomor]) }}" class="mt-4 bg-orange-500 text-white px-8 py-3 rounded-full hover:bg-orange-600 transition">
            Cari Menu
          </a>
        </div>
      </template>

    </div>

    @if($previousTotal > 0)
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg px-6 py-4 flex items-center justify-between z-40">
      <div>
        <p class="text-sm text-gray-500">Tagihan</p>
        <p class="text-lg font-medium text-gray-900">Rp {{ number_format($previousTotal, 0, ',', '.') }}</p>
      </div>
      <form action="{{ route('pesan.closeBill') }}" method="POST">
        @csrf
        <input type="hidden" name="meja_id" value="{{ $meja->id }}">
        <button type="submit" class="bg-orange-500 text-white px-5 py-2 rounded-lg hover:bg-orange-600 transition">
          Close Bill
        </button>
      </form>
    </div>
    @endif

    <!-- Modal Backdrop -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50"></div>

    <!-- Modal Bottom Sheet -->
    <div x-show="showModal" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-0 left-0 right-0 bg-white rounded-t-2xl p-6 shadow-xl z-50">
      <p class="text-center text-lg font-semibold mb-4">Apakah Anda yakin ingin konfirmasi pesanan?</p>
      <div class="flex space-x-4">
        <button @click="showModal = false"
                class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-100">
          Batal
        </button>
        <button @click="$refs.confirmForm.submit()"
                class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
          Ya, Konfirmasi
        </button>
      </div>
    </div>

  </div>

  <!-- Alpine & Axios Script -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] =
      document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let keranjangRows = {!! json_encode(
      $keranjang->map(fn($i) => [
        'id'       => $i->id,
        'jumlah'   => $i->jumlah,
        'harga'    => $i->menu->harga,
        'catatan'  => $i->catatan,
        'subtotal' => $i->jumlah * $i->menu->harga,
      ])
    ) !!};

    function keranjangApp() {
      return {
        total: 0,
        isEmpty: keranjangRows.length === 0,
        showModal: false,
        init() {
          this.total = keranjangRows.reduce((sum, r) => sum + r.subtotal, 0);
        },
        updateTotal() {
          this.total = keranjangRows.reduce((sum, r) => sum + r.subtotal, 0);
          this.isEmpty = keranjangRows.length === 0;
        }
      };
    }

    function itemRow(id, jumlahAwal, harga, catatanAwal) {
      return {
        id,
        jumlah: jumlahAwal,
        harga,
        catatan: catatanAwal,
        subtotal: jumlahAwal * harga,
        init() {
          const idx = keranjangRows.findIndex(r => r.id === id);
          if (idx !== -1) keranjangRows[idx] = this;
          else keranjangRows.push(this);
          setTimeout(() => {
            document.querySelector('[x-data="keranjangApp()"]')?.__x.$data.updateTotal();
          }, 0);
        },
        increase() {
          this.jumlah++;
          this.subtotal = this.jumlah * this.harga;
          this.sendUpdate();
        },
        decrease() {
          if (this.jumlah > 1) {
            this.jumlah--;
            this.subtotal = this.jumlah * this.harga;
            this.sendUpdate();
          } else {
            this.jumlah = 0;
            this.subtotal = 0;
            this.removeItem();
          }
        },
        sendUpdate() {
          axios.post(`/keranjang/update/${id}`, {
            jumlah: this.jumlah,
            catatan: this.catatan,
            _token: '{{ csrf_token() }}'
          }).catch(console.error);
        },
        removeItem() {
          keranjangRows = keranjangRows.filter(r => r.id !== id);
          axios.post(`/keranjang/remove/${id}`, { _token: '{{ csrf_token() }}' })
            .then(() => {
              document.getElementById(`item-${id}`)?.remove();
              document.querySelector('[x-data="keranjangApp()"]')?.__x.$data.updateTotal();
            }).catch(console.error);
        }
      };
    }
  </script>
</body>
</html>

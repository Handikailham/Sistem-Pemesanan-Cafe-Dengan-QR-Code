<!DOCTYPE html>
<html lang="id" x-data="dapurData()" x-init="init()">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Dapur Control</title>
  @vite('resources/js/app.js')
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    [x-cloak] { display: none!important; }
    /* Custom scrollbar for modal-body */
    .modal-body {
      /* Firefox */
      scrollbar-width: thin;
      scrollbar-color: #9CA3AF #E5E7EB;
    }
    .modal-body::-webkit-scrollbar {
      width: 8px;
    }
    .modal-body::-webkit-scrollbar-track {
      background: #E5E7EB;
      border-radius: 4px;
    }
    .modal-body::-webkit-scrollbar-thumb {
      background-color: #9CA3AF;
      border-radius: 4px;
    }
  </style>
</head>
<body class="bg-cover bg-center font-sans leading-normal text-gray-800" style="background-image: url('{{ asset('images/geolig.jpg') }}'); background-size: cover; background-position: center;">

  <!-- Header -->
  <header class="bg-white bg-opacity-80 backdrop-blur-md shadow-md fixed inset-x-0 top-0 z-50 py-4">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <img src="{{ asset('images/scanbrewcafe.png') }}" alt="Logo" class="h-12 w-auto" />
        <span class="text-2xl font-bold text-gray-900">ScanBrew <span class="text-yellow-500">Cafe</span></span>
      </div>
      <div class="flex items-center space-x-2">
        <h1 class="text-xl font-semibold text-gray-900">Dapur Control</h1>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 7 4-14 3 7h4" />
        </svg>
      </div>
    </div>
  </header>

  <!-- Konten Utama -->
  <main class="pt-24 pb-12 max-w-6xl mx-auto px-6">
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <template x-for="mejaData in filteredPesanan" :key="mejaData.meja">
        <div class="flex flex-col h-full bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 border-l-8 transform transition hover:scale-105"
             :class="{
               'border-yellow-400': mejaData.pesanan.some(i => i.status === 'menunggu'),
               'border-blue-600': mejaData.pesanan.some(i => i.status === 'proses'),
               'border-green-600': mejaData.pesanan.every(i => i.status === 'selesai')
             }">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h2 class="text-xl font-semibold text-gray-800">Meja #<span x-text="mejaData.meja"></span></h2>
              <p class="text-sm text-gray-600">Masuk: <span x-text="(new Date(mejaData.waktu_masuk)).toLocaleTimeString('id-ID')"></span></p>
            </div>
            <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded-full" x-text="mejaData.pesanan.length + ' item'"></span>
          </div>
          <ul class="flex-1 space-y-2 mb-4 overflow-hidden">
            <template x-for="item in mejaData.pesanan.slice(0, 3)" :key="item.id">
              <li class="flex justify-between items-center">
                <div>
                  <p class="font-medium text-gray-700" x-text="item.menu.nama"></p>
                  <p class="text-xs text-gray-500">x<span x-text="item.jumlah"></span></p>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full"
                      :class="{
                        'bg-yellow-100 text-yellow-800': item.status === 'menunggu',
                        'bg-blue-100 text-blue-800': item.status === 'proses',
                        'bg-green-100 text-green-800': item.status === 'selesai'
                      }" x-text="item.status"></span>
              </li>
            </template>
            <li x-show="mejaData.pesanan.length > 3" class="text-sm text-gray-500">+<span x-text="mejaData.pesanan.length - 3"></span> item lagi...</li>
          </ul>
          <button @click="openDetail(mejaData)" class="mt-auto w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-medium transition">
            Lihat Detail
          </button>
        </div>
      </template>
      <template x-if="filteredPesanan.length === 0">
        <div class="col-span-full text-center text-gray-500 py-10">Tidak ada pesanan sesuai filter.</div>
      </template>
    </div>
  </main>

  <!-- Modal Detail Pesanan -->
  <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div @click.away="closeModal()"
           class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[calc(100vh-4rem)] flex flex-col overflow-hidden transform transition-all"
           x-transition>
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b flex justify-between items-center">
          <h3 class="text-2xl font-bold text-gray-800">Detail Meja #<span x-text="modalMeja.meja"></span></h3>
          <button @click="closeModal()" class="text-gray-600 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <!-- Modal Body (scrollable with custom scrollbar) -->
        <div class="modal-body px-6 py-4" style="max-height:calc(100vh - 16rem); overflow-y:auto;">
          <table class="w-full text-left border-collapse mb-6">
            <thead class="bg-gray-100">
              <tr>
                <th class="p-3 font-semibold text-gray-700">Menu</th>
                <th class="p-3 font-semibold text-gray-700">Qty</th>
                <th class="p-3 font-semibold text-gray-700">Status</th>
                <th class="p-3 font-semibold text-gray-700">Catatan</th>
              </tr>
            </thead>
            <tbody>
              <template x-for="item in modalMeja.pesanan" :key="item.id">
                <tr class="border-t">
                  <td class="p-3 text-gray-700" x-text="item.menu.nama"></td>
                  <td class="p-3 text-gray-700" x-text="item.jumlah"></td>
                  <td class="p-3">
                    <span class="px-2 py-1 rounded-full text-sm font-medium text-white" :class="{
                            'bg-gray-500': item.status === 'menunggu',
                            'bg-yellow-500': item.status === 'proses',
                            'bg-green-600': item.status === 'selesai'
                          }" x-text="item.status.charAt(0).toUpperCase() + item.status.slice(1)"></span>
                  </td>
                  <td class="p-3 text-gray-700" x-text="item.catatan || '-' "></td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <!-- Modal Footer -->
        <div class="flex-shrink-0 px-6 py-4 border-t flex justify-between items-center">
          <form :action="`/dapur/proses/${modalMeja.meja}`" method="POST" @submit.prevent="if(confirm('Yakin proses semua?')) $event.target.submit()">
            @csrf @method('DELETE')
            <button class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition">Proses Semua</button>
          </form>
          <button @click="closeModal()" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium transition">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Alpine Data Script -->
  <script>
    function dapurData() {
      return {
        pesanan: @json($pesanan),
        filterStatus: 'semua',
        showModal: false,
        modalMeja: {},
        init() {
          window.Echo.channel('dapur').listen('.pesanan.masuk', ({ pesanan }) => {
            const mejaNomor = pesanan.meja.nomor;
            const existing = this.pesanan.find(p => p.meja == mejaNomor);
            if (existing) {
              if (!existing.pesanan.some(i => i.id === pesanan.id)) existing.pesanan.push(pesanan);
            } else this.pesanan.push({ meja: mejaNomor, pesanan: [pesanan], waktu_masuk: pesanan.created_at });
            this.pesanan.sort((a, b) => new Date(a.waktu_masuk) - new Date(b.waktu_masuk));
          });
        },
        get filteredPesanan() {
          if (this.filterStatus === 'semua') return this.pesanan;
          return this.pesanan.map(m => ({ meja: m.meja, waktu_masuk: m.waktu_masuk, pesanan: m.pesanan.filter(i => i.status === this.filterStatus) })).filter(m => m.pesanan.length);
        },
        openDetail(mejaData) { this.modalMeja = mejaData; this.showModal = true; },
        closeModal() { this.showModal = false; this.modalMeja = {}; }
      };
    }
  </script>
</body>
</html>

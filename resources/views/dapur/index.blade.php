<!DOCTYPE html>
<html lang="id" x-data="dapurData()" x-init="init()">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Halaman Dapur</title>
  @vite('resources/js/app.js')
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-cover bg-center font-sans leading-normal text-gray-800" style="background-image: url('images/geolig.jpg'); background-size: cover; background-position: center;">

  <!-- Header -->
  <header class="bg-white shadow-md mb-6 fixed top-0 left-0 right-0 z-50 py-3">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">
      <!-- Logo di sebelah kiri -->
      <div class="flex items-center">
        <img src="/images/scanbrewcafe.png" alt="ScanBrew Café Logo" class="h-20 w-auto"> 
      </div>

      <!-- Judul di sebelah kanan -->
      <div class="flex items-center ml-auto">
        <h1 class="text-2xl font-bold text-gray-900 mr-2">Dapur Control</h1>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 7 4-14 3 7h4" />
        </svg>
      </div>
    </div>
  </header>

  <!-- Konten Utama -->
  <main class="max-w-6xl mx-auto px-6 pt-24 grid gap-6 md:grid-cols-2 lg:grid-cols-3 bg-white">
    <template x-for="mejaData in filteredPesanan" :key="mejaData.meja">
      <div class="bg-white rounded-2xl shadow-xl p-4 border-l-8 transition-transform transform hover:scale-105" :class="{
          'border-yellow-400': mejaData.pesanan.some(i=>i.status==='menunggu'),
          'border-blue-600': mejaData.pesanan.some(i=>i.status==='proses'),
          'border-green-600': mejaData.pesanan.every(i=>i.status==='selesai')
        }">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h2 class="text-xl font-semibold">Meja #<span x-text="mejaData.meja"></span></h2>
            <p class="text-sm text-gray-500">Masuk: <span x-text="(new Date(mejaData.waktu_masuk)).toLocaleTimeString('id-ID')"></span></p>
          </div>
          <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded-full" x-text="mejaData.pesanan.length + ' item'"></span>
        </div>
        <ul class="space-y-1">
          <template x-for="item in mejaData.pesanan.slice(0,3)" :key="item.id">
            <li class="flex justify-between items-center">
              <div>
                <p class="font-medium" x-text="item.menu.nama"></p>
                <p class="text-xs text-gray-500">x<span x-text="item.jumlah"></span></p>
              </div>
              <span class="text-xs font-semibold px-2 py-1 rounded-full" :class="{
                  'bg-yellow-100 text-yellow-800': item.status==='menunggu',
                  'bg-blue-100 text-blue-800': item.status==='proses',
                  'bg-green-100 text-green-800': item.status==='selesai'
                }" x-text="item.status"></span>
            </li>
          </template>
          <li x-show="mejaData.pesanan.length>3" class="text-sm text-gray-500">+<span x-text="mejaData.pesanan.length - 3"></span> item lagi...</li>
        </ul>

        <!-- Button Lihat Detail -->
        <button @click="openDetail(mejaData)" class="mt-4 w-full bg-yellow-500 hover:bg-yellow-500 text-white py-2 rounded-lg font-medium transition">Lihat Detail</button>
      </div>
    </template>

    <template x-if="filteredPesanan.length === 0">
      <div class="col-span-full text-center text-gray-500 py-10">Tidak ada pesanan sesuai filter.</div>
    </template>

  </main>

  <!-- Modal Detail Pesanan -->
  <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div @click.away="closeModal()" class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-6 transform transition-all" x-transition>
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-2xl font-bold">Detail Meja #<span x-text="modalMeja.meja"></span></h3>
        <button @click="closeModal()" class="text-gray-600 hover:text-gray-800">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-3 font-semibold">Menu</th>
            <th class="p-3 font-semibold">Qty</th>
            <th class="p-3 font-semibold">Status</th>
            <th class="p-3 font-semibold">Catatan</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="item in modalMeja.pesanan" :key="item.id">
            <tr class="border-t">
              <td class="p-3" x-text="item.menu.nama"></td>
              <td class="p-3" x-text="item.jumlah"></td>
              <td class="p-3">
                <span class="px-2 py-1 rounded-full text-sm font-medium" :class="{
                  'bg-yellow-200 text-yellow-800': item.status==='menunggu',
                  'bg-blue-200 text-blue-800': item.status==='proses',
                  'bg-green-200 text-green-800': item.status==='selesai'
                }" x-text="item.status"></span>
              </td>
              <td class="p-3" x-text="item.catatan || '-' "></td>
            </tr>
          </template>
        </tbody>
      </table>
      <div class="mt-6 flex justify-end space-x-3">
        <form :action="`/dapur/proses/${modalMeja.meja}`" method="POST" @submit.prevent="if(confirm('Yakin proses semua?')) $event.target.submit()">
          @csrf @method('DELETE')
          <button class="px-6 py-2 bg-yellow-500 hover:bg-black-500 text-white rounded-lg">Proses Semua</button>
        </form>
        <button @click="closeModal()" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">Tutup</button>
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
            // logic to update orders dynamically
          });
        },
        get filteredPesanan() {
          if (this.filterStatus === 'semua') return this.pesanan;
          return this.pesanan.map(m => ({
            meja: m.meja,
            waktu_masuk: m.waktu_masuk,
            pesanan: m.pesanan.filter(i => i.status === this.filterStatus)
          })).filter(m => m.pesanan.length);
        },
        openDetail(mejaData) {
          this.modalMeja = mejaData;
          this.showModal = true;
        },
        closeModal() {
          this.showModal = false;
          this.modalMeja = {};
        }
      }
    }
  </script>
</body>
</html>

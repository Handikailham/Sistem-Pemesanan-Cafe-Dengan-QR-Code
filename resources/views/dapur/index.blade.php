<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Halaman Dapur</title>

  @vite('resources/js/app.js')

  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">

  <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow mt-10" x-data="dapurData()" x-init="init()">
    <h2 class="text-2xl font-bold mb-6">📦 Daftar Pesanan Masuk ke Dapur</h2>

    {{-- Daftar per meja (urutan berdasarkan waktu masuk pertama) --}}
    <template x-for="mejaData in pesanan" :key="mejaData.meja">
      <div class="mb-4 border border-gray-300 rounded p-4 flex justify-between items-center bg-gray-50">
        <div>
          <h3 class="text-lg font-semibold">Meja #<span x-text="mejaData.meja"></span></h3>
          <p class="text-sm text-gray-600" x-text="mejaData.pesanan.length + ' menu dipesan'"></p>
        </div>
        <button
          @click="selectedMeja = mejaData.pesanan; showModal = true"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
        >
          Detail
        </button>
      </div>
    </template>

    <template x-if="pesanan.length === 0">
      <div class="text-center text-gray-500 py-8">Tidak ada pesanan</div>
    </template>

    {{-- Modal Detail --}}
    <template x-if="showModal">
      <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6" x-show="showModal" x-transition>
          <h3 class="text-xl font-bold mb-4">Detail Pesanan</h3>

          <table class="w-full text-sm mb-6">
            <thead class="bg-gray-100 text-left">
              <tr>
                <th class="px-4 py-2">Menu</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Catatan</th>
              </tr>
            </thead>
            <tbody>
              <template x-for="item in selectedMeja" :key="item.id">
                <tr class="border-t">
                  <td class="px-4 py-2" x-text="item.menu.nama"></td>
                  <td class="px-4 py-2" x-text="item.jumlah"></td>
                  <td class="px-4 py-2">
                    <span
                      class="px-2 py-1 rounded text-white text-xs"
                      :class="{
                        'bg-gray-500': item.status === 'menunggu',
                        'bg-yellow-500': item.status === 'proses',
                        'bg-green-600': item.status === 'selesai'
                      }"
                      x-text="item.status.charAt(0).toUpperCase() + item.status.slice(1)"
                    ></span>
                  </td>
                  <td class="px-4 py-2" x-text="item.catatan || '-'"></td>
                </tr>
              </template>
            </tbody>
          </table>

          <div class="flex justify-end space-x-4">
            <form
              :action="`/dapur/proses/${selectedMeja[0].meja.nomor}`"
              method="POST"
              @submit.prevent="if(confirm('Yakin proses?')) $event.target.submit()"
            >
              @csrf
              @method('DELETE')
              <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Proses</button>
            </form>
            <button @click="showModal = false" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </template>
  </div>

  {{-- Alpine Data --}}
  <script>
    function dapurData() {
      return {
        pesanan: @json($pesanan),
        showModal: false,
        selectedMeja: null,

        init() {
          window.Echo
            .channel('dapur')
            .listen('.pesanan.masuk', ({ pesanan }) => {
              const mejaNomor = pesanan.meja.nomor;

              const existing = this.pesanan.find(p => p.meja == mejaNomor);

              if (existing) {
                // tambahkan jika belum ada
                if (!existing.pesanan.some(p => p.id === pesanan.id)) {
                  existing.pesanan.push(pesanan);
                }
              } else {
                this.pesanan.push({
                  meja: mejaNomor,
                  pesanan: [pesanan],
                  waktu_masuk: pesanan.created_at
                });
              }

              // sortir ulang berdasarkan waktu_masuk
              this.pesanan.sort((a, b) => new Date(a.waktu_masuk) - new Date(b.waktu_masuk));
            });
        }
      };
    }
  </script>
</body>
</html>

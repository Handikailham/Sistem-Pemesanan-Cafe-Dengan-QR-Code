<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Dapur</title>

    {{-- Load JS via Vite --}}
    @vite(['resources/js/app.js'])

    {{-- Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    {{-- AlpineJS --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Pusher --}}
    <script defer src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        function dapurData() {
            return {
                pesanan: {},
                showModal: false,
                selectedMeja: null,
                init() {
                    this.pesanan = JSON.parse(JSON.stringify(@json($pesanan)));

                    // Tunggu sampai Echo siap
                    const waitEcho = setInterval(() => {
                        if (typeof window.Echo !== 'undefined') {
                            clearInterval(waitEcho);

                            window.Echo.channel('dapur')
                                .listen('.pesanan.masuk', (e) => {
                                    let nomorMeja = e.pesanan.meja.nomor;
                                    let updated = {...this.pesanan};

                                    if (updated[nomorMeja]) {
                                        updated[nomorMeja] = [...updated[nomorMeja], e.pesanan];
                                    } else {
                                        updated[nomorMeja] = [e.pesanan];
                                    }

                                    this.pesanan = updated;
                                    console.log("Pesanan baru diterima:", e.pesanan);
                                });
                        }
                    }, 100);
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow mt-10" x-data="dapurData()" x-init="init()">
        <h2 class="text-2xl font-bold mb-6">📦 Daftar Pesanan Masuk ke Dapur</h2>

        <!-- Tampilan Pesanan -->
        <template x-for="(items, nomorMeja) in pesanan" :key="nomorMeja">
            <div class="mb-4 border border-gray-300 rounded shadow-sm p-4 flex justify-between items-center bg-gray-50">
                <div>
                    <h3 class="text-lg font-semibold">Meja #<span x-text="nomorMeja"></span></h3>
                    <p class="text-sm text-gray-600" x-text="items.length + ' menu dipesan'"></p>
                </div>
                <button
                    @click="selectedMeja = items; showModal = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Detail
                </button>
            </div>
        </template>

        <!-- Pesanan Kosong -->
        <template x-if="Object.keys(pesanan).length === 0">
            <div class="mb-4 text-center text-gray-500">Tidak ada pesanan</div>
        </template>

        <!-- Modal untuk Detail Pesanan -->
        <template x-if="showModal">
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6" x-show="selectedMeja" x-transition>
                    <h3 class="text-xl font-bold mb-4">Detail Pesanan</h3>

                    <template x-if="selectedMeja">
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
                                            <span class="px-2 py-1 rounded text-white text-xs"
                                                :class="{
                                                    'bg-gray-500': item.status === 'menunggu',
                                                    'bg-yellow-500': item.status === 'proses',
                                                    'bg-green-600': item.status === 'selesai'
                                                }"
                                                x-text="item.status.charAt(0).toUpperCase() + item.status.slice(1)">
                                            </span>
                                        </td>
                                        <td class="px-4 py-2" x-text="item.catatan ? item.catatan : '-'"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </template>

                    <div class="flex justify-between">
                        <!-- Tombol untuk Proses -->
                        <form :action="'/dapur/proses/' + selectedMeja[0].meja.nomor" method="POST"
                              @submit.prevent="if(confirm('Yakin ingin memproses pesanan ini?')) $event.target.submit()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                Proses
                            </button>
                        </form>
                        <button @click="showModal = false"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</body>
</html>

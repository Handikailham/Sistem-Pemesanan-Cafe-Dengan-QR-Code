<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang - Meja #{{ $meja->nomor }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">

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

    <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Keranjang Pesanan untuk Meja #{{ $meja->nomor }}</h2>

        <!-- Mengatur tampilan dengan Alpine -->
        <div x-data="keranjangApp()" x-init="init()">
            <!-- Tampilkan tabel jika keranjang tidak kosong -->
            <div x-show="!isEmpty">
                <div class="overflow-x-auto">
                    <table class="w-full mb-4 table-auto border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Menu</th>
                                <th class="px-4 py-2 text-center">Jumlah</th>
                                <th class="px-4 py-2 text-center">Catatan</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keranjang as $item)
                                <tr id="item-{{ $item->id }}" class="border-t" 
                                    x-data="itemRow({{ $item->id }}, {{ $item->jumlah }}, {{ $item->menu->harga }}, '{{ $item->catatan }}')" 
                                    x-init="$watch('jumlah', val => updateTotal()); $watch('subtotal', val => updateTotal())">
                                    <td class="px-4 py-2">{{ $item->menu->nama }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <button @click="decrease()" class="bg-gray-300 px-2 rounded hover:bg-gray-400 text-sm">−</button>
                                            <span class="font-semibold" x-text="jumlah"></span>
                                            <button @click="increase()" class="bg-gray-300 px-2 rounded hover:bg-gray-400 text-sm">+</button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <input type="text" x-model="catatan" @input.debounce.500ms="sendUpdate()" class="w-full border rounded p-1">
                                    </td>
                                    <td class="px-4 py-2 text-right" x-text="'Rp ' + subtotal.toLocaleString()"></td>
                                </tr>
                            @endforeach
                            <tr class="border-t bg-gray-50">
                                <td colspan="3" class="px-4 py-2 font-bold text-right">Total</td>
                                <td class="px-4 py-2 font-bold text-right" x-text="'Rp ' + total.toLocaleString()"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Tombol untuk konfirmasi pesanan tampil jika masih ada item di keranjang -->
                <div class="flex flex-col space-y-4">
                    <form action="{{ route('pesan.confirm') }}" method="POST">
                        @csrf
                        <input type="hidden" name="meja_id" value="{{ $meja->id }}">
                        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 w-full">
                            Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Tampilkan pesan jika keranjang kosong -->
            <div x-show="isEmpty">
                <p class="text-center text-gray-500 font-semibold py-8">Keranjang masih kosong.</p>
            </div>
        </div>

        <!-- Tombol Close Bill ditempatkan di luar blok Alpine agar selalu muncul jika order ada -->
        @if(isset($order))
            <form action="{{ route('pesan.closeBill') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="meja_id" value="{{ $meja->id }}">
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded hover:bg-red-700 w-full">
                    Close Bill
                </button>
            </form>
        @endif

        <a href="{{ route('pesan.index', ['nomor_meja' => $meja->nomor]) }}" class="text-blue-600 hover:underline mt-4 inline-block">
            ← Kembali ke Menu
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Data awal dari server
        let keranjangRows = {!! json_encode($keranjang->map(function($item) {
            return [
                'id' => $item->id,
                'jumlah' => $item->jumlah,
                'harga' => $item->menu->harga,
                'catatan' => $item->catatan,
                'subtotal' => $item->jumlah * $item->menu->harga,
            ];
        })) !!};

        function keranjangApp() {
            return {
                total: 0,
                isEmpty: keranjangRows.length === 0,
                init() {
                    this.total = keranjangRows.reduce((sum, row) => sum + row.subtotal, 0);
                },
                updateTotal() {
                    this.total = keranjangRows.reduce((sum, row) => sum + row.subtotal, 0);
                    this.isEmpty = keranjangRows.length === 0;
                }
            };
        }

        function itemRow(id, jumlahAwal, harga, catatanAwal) {
            return {
                id: id,
                jumlah: jumlahAwal,
                harga: harga,
                catatan: catatanAwal,
                subtotal: jumlahAwal * harga,
                init() {
                    // Perbarui data di keranjangRows agar tidak terjadi duplikasi
                    const index = keranjangRows.findIndex(row => row.id === this.id);
                    if (index !== -1) {
                        keranjangRows[index] = this;
                    } else {
                        keranjangRows.push(this);
                    }
                    setTimeout(() => {
                        const app = document.querySelector('[x-data^="keranjangApp"]')?.__x.$data;
                        if (app?.updateTotal) app.updateTotal();
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
                    } else if (this.jumlah === 1) {
                        // Jika quantity menjadi 0, hapus item dan perbarui tampilan
                        this.jumlah = 0;
                        this.subtotal = 0;
                        this.removeItem();
                    }
                },
                sendUpdate() {
                    axios.post('/keranjang/update/' + this.id, {
                        jumlah: this.jumlah,
                        catatan: this.catatan,
                        _token: '{{ csrf_token() }}'
                    }).then(() => {
                        this.subtotal = this.jumlah * this.harga;
                    }).catch(err => console.error(err));
                },
                removeItem() {
                    // Hapus dari array dan perbarui tampilan
                    keranjangRows = keranjangRows.filter(row => row.id !== this.id);
                    axios.post('/keranjang/remove/' + this.id, {
                        _token: '{{ csrf_token() }}'
                    }).then(() => {
                        // Hapus baris item dari DOM
                        document.getElementById('item-' + this.id).remove();
                        const app = document.querySelector('[x-data^="keranjangApp"]')?.__x.$data;
                        if (app?.updateTotal) app.updateTotal();
                    }).catch(err => console.error(err));
                }
            };
        }
    </script>
</body>
</html>

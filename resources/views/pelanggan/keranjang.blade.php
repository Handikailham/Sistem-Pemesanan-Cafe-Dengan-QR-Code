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
          <div class="flex items-center space-x-6 text-lg text-gray-800 font-medium">
            <a href="{{ route('pesan.index', $meja->nomor) }}"
               class="hover:text-yellow-500 transition duration-200">Pesan</a>
            <a href="{{ route('keranjang.index', ['nomor_meja' => $meja->nomor]) }}"
               class="hover:text-yellow-500 transition duration-200">Keranjang</a>
          </div>
        </div>
      </nav>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
        <!-- Card Utama -->
        <div class="bg-white shadow-lg rounded-lg p-6">
          <!-- Header -->
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3 text-black-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.6 8m0 0a1.6 1.6 0 003.2 0m-3.2 0H17m0 0a1.6 1.6 0 003.2 0m-3.2 0L17 13" />
              </svg>
              <span class="text-2xl font-semibold">Keranjang Pesanan</span>
            </div>          
            <a href="{{ route('pesan.index', $meja->nomor) }}"
               class="flex items-center text-gray-800 hover:text-yellow-500 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7" />
              </svg>
              <span class="text-lg font-medium">Kembali</span>
            </a>
          </div>
      
          <div class="h-px bg-black w-full mb-6"></div>
      
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Menu di Pesan</h2>
      
          @if($keranjang->isEmpty())
            <p class="text-center text-gray-500 italic">Belum ada item di keranjang.</p>
          @else
            <div class="flex space-x-6 overflow-x-auto pb-2">
              @foreach($keranjang as $item)
                <div class="w-56 flex-shrink-0 bg-gray-50 rounded-lg p-4 flex items-center justify-between">
                  <div class="flex-1 pr-2">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $item->menu->nama }}</h3>
                    <span class="text-gray-700">
                      Rp {{ number_format($item->menu->harga * $item->jumlah, 0, ',', '.') }}
                    </span>
                  </div>
                  <img src="{{ asset('menu/' . $item->menu->gambar) }}" alt="{{ $item->menu->nama }}"
                       class="h-20 w-20 object-cover rounded-md">
                </div>
              @endforeach
            </div>
          @endif
      
          <div class="h-px bg-black w-full mb-6"></div>
      
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800">
              Total Menu ({{ $keranjang->count() }})
            </h2>
            <a href="{{ route('pesan.index', $meja->nomor) }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-lg shadow hover:bg-yellow-600 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Tambah Menu
            </a>
          </div>
      
          <div class="h-px bg-black w-full mb-6"></div>
      
          <div>
            <ul class="space-y-4">
              @foreach($keranjang as $item)
                <li class="p-4 bg-gray-50 border-l-4 border-yellow-400 rounded-lg shadow-sm">
                  <div class="flex justify-between items-center mb-2">
                    <h3 class="text-base font-semibold text-gray-800">
                      {{ optional($item->menu)->nama ?? $item->nama_menu }}
                    </h3>
                    <span class="text-sm bg-yellow-300 text-gray-800 font-bold px-3 py-1 rounded-full">
                      x{{ $item->jumlah ?? $item->qty ?? 1 }}
                    </span>
                  </div>
      
                  <input 
                    type="text"
                    name="catatan[{{ $item->id }}]"
                    value="{{ old('catatan.'.$item->id, $item->catatan ?? '') }}"
                    placeholder="Catatan untuk menu ini (opsional)"
                    class="w-full px-3 py-2 text-sm border border-yellow-300 rounded-md focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                  >
                </li>
              @endforeach
            </ul>
          </div>
      
          <div class="h-px bg-black w-full my-6"></div>
      
          <div class="mt-6 space-y-2 text-sm text-gray-700">
            <div class="flex justify-between border-b pb-1">
              <span>Jumlah Menu</span>
              <span class="font-semibold">{{ $keranjang->sum('jumlah') }} item</span>
            </div>
      
            <div class="flex justify-between border-b pb-1">
              <span>Subtotal Harga</span>
              <span class="font-semibold">
                Rp {{ number_format($keranjang->sum(function($item) {
                  return ($item->menu->harga ?? 0) * ($item->jumlah ?? 1);
                }), 0, ',', '.') }}
              </span>
            </div>
      
            <div class="flex justify-between pt-2 text-base text-gray-800 font-bold">
              <span>Total</span>
              <span>
                Rp {{ number_format($keranjang->sum(function($item) {
                  return ($item->menu->harga ?? 0) * ($item->jumlah ?? 1);
                }), 0, ',', '.') }}
              </span>
            </div>
          </div>
      
          <div class="mt-6 flex flex-col sm:flex-row gap-4">
            <form action="{{ route('pesan.confirm') }}" method="POST" class="w-full sm:flex-1">
              @csrf
              <input type="hidden" name="meja_id" value="{{ $meja->id }}">
              <button type="submit"
                      class="w-full py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl shadow transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
                Konfirmasi Pesanan
              </button>
            </form>
      
            @if(isset($order))
            <form action="{{ route('pesan.closeBill') }}" method="POST" class="w-full sm:flex-1">
              @csrf
              <input type="hidden" name="meja_id" value="{{ $meja->id }}">
              <button type="submit"
                      class="w-full py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl shadow transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                Close Bill
              </button>
            </form>
            @endif
          </div>
        </div>
      </div>
      
      

      
      <div x-data="keranjangApp()" x-init="init()" class="max-w-6xl mx-auto px-6 py-8 bg-white rounded-2xl shadow-lg mt-24">
        <template x-if="!isEmpty">
          <div class="space-y-6">
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6h12.4M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                </svg>
                Keranjang Pesanan
              </h2>
            <!-- Tabel Keranjang -->
            <div class="overflow-x-auto">
              <table class="w-full text-left text-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-yellow-500 text-white">
                  <tr>
                    <th class="px-6 py-4">Menu</th>
                    <th class="px-6 py-4 text-center">Jumlah</th>
                    <th class="px-6 py-4 text-center">Catatan</th>
                    <th class="px-6 py-4 text-right">Subtotal</th>
                  </tr>
                </thead>
                <tbody class="divide-y">
                  @foreach ($keranjang as $item)
                  <tr id="item-{{ $item->id }}" class="hover:bg-gray-50 transition"
                      x-data="itemRow({{ $item->id }}, {{ $item->jumlah }}, {{ $item->menu->harga }}, '{{ $item->catatan }}')"
                      x-init="$watch('jumlah', updateTotal); $watch('subtotal', updateTotal)">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $item->menu->nama }}</td>
                    <td class="px-6 py-4 text-center">
                      <div class="inline-flex items-center space-x-2">
                        <button @click="decrease()" class="p-2 bg-gray-200 rounded-full hover:bg-gray-300 transition">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none"
                               viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                          </svg>
                        </button>
                        <span x-text="jumlah" class="w-6 text-center"></span>
                        <button @click="increase()" class="p-2 bg-gray-200 rounded-full hover:bg-gray-300 transition">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none"
                               viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                          </svg>
                        </button>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <input type="text" x-model="catatan" @input.debounce.500ms="sendUpdate()"
                             placeholder="Tambah catatan..."
                             class="w-full p-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent transition" />
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-gray-800"
                        x-text="'Rp ' + subtotal.toLocaleString()"></td>
                  </tr>
                  @endforeach
      
                  <!-- Total -->
                  <tr class="bg-gray-50 font-semibold">
                    <td colspan="3" class="px-6 py-4 text-right">Total:</td>
                    <td class="px-6 py-4 text-right" x-text="'Rp ' + total.toLocaleString()"></td>
                  </tr>
                </tbody>
              </table>
            </div>
      
            <!-- Aksi & Kembali ke Menu -->
            <div class="flex flex-col sm:flex-row items-center justify-between">
              <a href="{{ route('pesan.index', ['nomor_meja' => $meja->nomor]) }}"
                 class="inline-block py-3 px-6 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-xl transition mb-4 sm:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block mr-1" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Menu
              </a>
      
              <div class="flex gap-4 w-full sm:w-auto">
                <form action="{{ route('pesan.confirm') }}" method="POST" class="flex-1">
                  @csrf
                  <input type="hidden" name="meja_id" value="{{ $meja->id }}">
                  <button type="submit"
                          class="w-full py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl shadow transition flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                    Konfirmasi Pesanan
                  </button>
                </form>
      
                @if(isset($order))
                <form action="{{ route('pesan.closeBill') }}" method="POST" class="flex-1">
                  @csrf
                  <input type="hidden" name="meja_id" value="{{ $meja->id }}">
                  <button type="submit"
                          class="w-full py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl shadow transition flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close Bill
                  </button>
                </form>
                @endif
              </div>
            </div>
      
           
        </template>
      
        <!-- Jika Kosong -->
        <div x-show="isEmpty" class="py-20 text-center text-gray-400">
          <p class="mb-6 text-lg">Keranjang masih kosong.</p>
          <a href="{{ route('pesan.index', ['nomor_meja' => $meja->nomor]) }}"
             class="inline-block py-3 px-6 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-xl shadow transition">
            Mulai Pesan
          </a>
        </div>
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

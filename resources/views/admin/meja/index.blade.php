<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin – Data Meja | ScanBrew Café</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="flex h-screen bg-yellow-50 text-gray-800 font-sans">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
    <div class="p-6 flex items-center space-x-2 border-b">
      <img src="{{ asset('images/scanbrewcafe.png') }}" alt="Logo" class="w-10 h-10">
      <span class="text-xl font-bold text-yellow-500">ScanBrew Café</span>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
      <a href="{{ route('admin.meja.index') }}" class="flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg font-medium">
        <i data-feather="grid" class="w-5 h-5 mr-3"></i> Meja
      </a>
      <a href="{{ route('admin.menu.index') }}" class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="book-open" class="w-5 h-5 mr-3 text-yellow-500"></i> Menu
      </a>
      <a href="{{ route('admin.transaksi.index') }}" class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="clipboard" class="w-5 h-5 mr-3 text-yellow-500"></i> Transaksi
      </a>
      <a href="{{ route('admin.user.index') }}" class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="users" class="w-5 h-5 mr-3 text-yellow-500"></i> User
      </a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <!-- HEADER -->
    <header class="flex justify-between items-center px-8 py-5 bg-white border-b border-grey-200">
      <h1 class="text-2xl font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="grid" class="text-yellow-500"></i> Data Meja
      </h1>
      <a href="{{ route('admin.meja.create') }}"
         class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 transition">
        <span class="text-xl">＋</span>
        <span>Tambah Meja</span>
      </a>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
      @if (session('success'))
        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 text-yellow-500 rounded-lg flex items-center space-x-2 shadow-sm">
          <i data-feather="check-circle" class="w-5 h-5 text-yellow-500"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      <div class="bg-white rounded-xl shadow-lg overflow-hidden border-b border-grey-200">
        <table class="min-w-full text-sm divide-y divide-gray-100">
          <thead class="bg-yellow-500 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="px-6 py-4 text-left">ID</th>
              <th class="px-6 py-4 text-left">Nomor Meja</th>
              <th class="px-6 py-4 text-center">QR Code</th>
              <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 bg-white">
            @forelse ($meja as $m)
            <tr class="hover:bg-yellow-50 transition">
              <td class="px-6 py-4">{{ $m->id }}</td>
              <td class="px-6 py-4 font-semibold text-gray-700">Meja {{ $m->nomor }}</td>
              <td class="px-6 py-4 text-center">
                <div class="inline-block p-2 bg-white border border-yellow-100 rounded shadow-sm">
                  {!! QrCode::size(100)->backgroundColor(255,255,255)->generate(url('/pesan/'.$m->nomor)) !!}
                </div>
                <div class="mt-2">
                  <a href="{{ url('/pesan/'.$m->nomor) }}" target="_blank"
                     class="text-yellow-500 hover:text-yellow-600 hover:underline text-sm">
                    Lihat Link
                  </a>
                </div>
              </td>
              <td class="px-6 py-4 text-center">
                <form action="{{ route('admin.meja.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="inline-flex items-center justify-center w-9 h-9 bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition">
                    <i data-feather="trash" class="w-4 h-4"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data meja.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <script>feather.replace()</script>
</body>
</html>

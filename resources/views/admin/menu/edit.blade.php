<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Menu | ScanBrew Café</title>

  <!-- Tailwind CSS & Feather Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="flex h-screen bg-gray-50">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
    <div class="p-6 flex items-center space-x-2 border-b">
      <img src="{{ asset('images/scanbrewcafe.png') }}" alt="Logo" class="w-10 h-10">
      <span class="text-xl font-bold text-yellow-500">ScanBrew Café</span>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
      <!-- Dashboard -->
      <a href="{{ route('admin.dashboard') }}"
         class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg text-gray-700">
        <i data-feather="home" class="w-5 h-5 mr-3 text-yellow-500"></i>
        <span>Dashboard</span>
      </a>
      <!-- Meja -->
      <a href="{{ route('admin.meja.index') }}"
         class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="grid" class="w-5 h-5 mr-3 text-yellow-500"></i>
        <span class="text-gray-700">Meja</span>
      </a>
      <!-- Menu -->
      <a href="{{ route('admin.menu.index') }}"
         class="flex items-center px-4 py-2 bg-yellow-500 rounded-lg font-medium">
        <i data-feather="book-open" class="w-5 h-5 mr-3 text-white"></i>
        <span class="text-white">Menu</span>
      </a>
      <!-- Transaksi -->
      <a href="{{ route('admin.transaksi.index') }}"
         class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="clipboard" class="w-5 h-5 mr-3 text-yellow-500"></i>
        <span class="text-gray-700">Transaksi</span>
      </a>
      <!-- User -->
      <a href="{{ route('admin.user.index') }}"
         class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="users" class="w-5 h-5 mr-3 text-yellow-500"></i>
        <span class="text-gray-700">User</span>
      </a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <!-- HEADER -->
    <header class="flex justify-between items-center px-8 py-5 bg-white border-b border-gray-200">
      <h1 class="text-2xl font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="book-open" class="text-yellow-600"></i> Edit Menu: {{ $menu->nama }}
      </h1>
      <a href="{{ route('admin.menu.index') }}"
         class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-600 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 transition">
        <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
      <div class="max-w-3xl mx-auto p-8 bg-yellow-50 rounded-2xl shadow-lg shadow-yellow-200 border border-yellow-300">
        <h2 class="text-3xl font-bold text-yellow-600 mb-8 text-center flex items-center justify-center gap-2">
          <i data-feather="edit" class="w-6 h-6 text-yellow-600"></i> Edit Menu
        </h2>

        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
          </div>
        @endif

        @if($errors->any())
          <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          <!-- Baris 1: Nama & Harga -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Menu</label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <i data-feather="tag" class="w-5 h-5 text-yellow-500"></i>
                </span>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $menu->nama) }}" required
                       class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"/>
              </div>
            </div>
            <div>
              <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <i data-feather="dollar-sign" class="w-5 h-5 text-yellow-500"></i>
                </span>
                <input type="number" name="harga" id="harga" value="{{ old('harga', $menu->harga) }}" required
                       class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"/>
              </div>
            </div>
          </div>

          <!-- Baris 2: Kategori & Gambar -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <i data-feather="box" class="w-5 h-5 text-yellow-500"></i>
                </span>
                <input type="text" name="kategori" id="kategori" value="{{ old('kategori', $menu->kategori) }}" required
                       class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"/>
              </div>
            </div>
            <div>
              <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Menu</label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                  <i data-feather="image" class="w-5 h-5 text-yellow-500"></i>
                </span>
                <input type="file" name="gambar" id="gambar" accept=".jpg,.jpeg,.png"
                       class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition"/>
              </div>
              <p class="text-xs text-gray-500 mt-1">Maks: 2MB. JPG, JPEG, PNG.</p>
            </div>
          </div>

          <!-- Baris 3: Deskripsi full-width -->
          <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <div class="relative">
              <span class="absolute top-2 left-0 flex items-center pl-3">
                <i data-feather="file-text" class="w-5 h-5 text-yellow-500"></i>
              </span>
              <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mt-10">
            <button type="submit"
                    class="w-full flex items-center justify-center bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-700 transition shadow-md">
              <i data-feather="save" class="w-5 h-5 mr-2"></i> Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>

  <script>feather.replace()</script>
</body>
</html>

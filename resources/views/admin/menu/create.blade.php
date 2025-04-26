<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Menu | ScanBrew Café</title>
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
      <!-- Menu (active) -->
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
    <header class="flex justify-between items-center px-8 py-5 bg-white border-b border-grey-200">
      <h1 class="text-2xl font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="book-open" class="text-yellow-500"></i> Tambah Menu
      </h1>
      <a href="{{ route('admin.menu.index') }}"
         class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 transition">
        <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
      <div class="max-w-4xl mx-auto p-8 bg-white rounded-2xl shadow border border-yellow-100">
        <h2 class="text-2xl font-bold text-yellow-500 mb-6 flex items-center gap-2">
          <i data-feather="plus" class="w-6 h-6 text-yellow-500"></i> Form Tambah Menu
        </h2>

        <!-- Form -->
        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf

          <div class="grid grid-cols-2 gap-6">
            <!-- Nama Menu -->
            <div class="flex flex-col">
              <label for="nama" class="text-sm font-medium text-gray-700">Nama Menu</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="tag" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                       class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none" />
              </div>
              @error('nama')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>

            <!-- Harga -->
            <div class="flex flex-col">
              <label for="harga" class="text-sm font-medium text-gray-700">Harga</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="dollar-sign" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <input type="number" name="harga" id="harga" value="{{ old('harga') }}" required
                       class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none" />
              </div>
              @error('harga')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6 mt-6">
            <!-- Kategori -->
            <div class="flex flex-col">
              <label for="kategori" class="text-sm font-medium text-gray-700">Kategori</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="list" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}" required
                       class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none" />
              </div>
              @error('kategori')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>

            <!-- Gambar -->
            <div class="flex flex-col">
              <label for="gambar" class="text-sm font-medium text-gray-700">Gambar (opsional)</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="image" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <input type="file" name="gambar" id="gambar"
                       class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none" />
              </div>
              @error('gambar')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
            </div>
          </div>

          <!-- Deskripsi -->
          <div class="flex flex-col mt-6">
            <label for="deskripsi" class="text-sm font-medium text-gray-700">Deskripsi</label>
            <div class="flex items-start border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
              <i data-feather="file-text" class="w-5 h-5 text-yellow-500 ml-3 mt-3"></i>
              <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none">{{ old('deskripsi') }}</textarea>
            </div>
            @error('deskripsi')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
          </div>

          <!-- Tombol Simpan -->
          <div class="flex justify-center mt-8">
            <button type="submit"
                    class="w-full py-3 bg-yellow-500 text-white text-lg rounded-xl font-semibold hover:bg-yellow-600 transition">
              Simpan Menu
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>

  <script>feather.replace()</script>
</body>
</html>

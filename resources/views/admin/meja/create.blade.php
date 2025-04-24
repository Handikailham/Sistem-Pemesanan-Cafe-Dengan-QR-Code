<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin – Tambah Meja | ScanBrew Café</title>
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
      <a href="{{ route('admin.meja.index') }}"
         class="flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg font-medium">
        <i data-feather="grid" class="w-5 h-5 mr-3"></i> Meja
      </a>
      <a href="{{ route('admin.menu.index') }}"
         class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="book-open" class="w-5 h-5 mr-3 text-yellow-500"></i> Menu
      </a>
      <a href="{{ route('admin.transaksi.index') }}"
         class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="clipboard" class="w-5 h-5 mr-3 text-yellow-500"></i> Transaksi
      </a>
      <a href="{{ route('admin.user.index') }}"
         class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="users" class="w-5 h-5 mr-3 text-yellow-500"></i> User
      </a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <!-- HEADER -->
    <header class="flex justify-between items-center px-8 py-5  bg-white border-b border-grey-200">
      <h1 class="text-2xl font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="table" class="text-yellow-500"></i> Tambah Meja
      </h1>
      <a href="{{ route('admin.meja.index') }}"
         class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 transition">
        <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
      <div class="max-w-xl bg-white mx-auto p-8 rounded-2xl shadow-lg border border-yellow-300">
        <h2 class="text-2xl font-bold text-yellow-500 mb-6 flex items-center gap-2">
          <i data-feather="plus" class="w-6 h-6"></i> Form Tambah Meja
        </h2>
        <form action="{{ route('admin.meja.store') }}" method="POST" class="space-y-6">
          @csrf
          <div>
            <label for="nomor" class="block text-sm font-medium text-gray-700 mb-1">Nomor Meja</label>
            <input id="nomor" name="nomor" type="text" required
                   class="block w-full px-4 py-3 border border-yellow-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500">
          </div>
          <button type="submit"
                  class="w-full py-3 bg-yellow-500 text-white text-lg rounded-xl font-semibold hover:bg-yellow-600 transition">
            Simpan
          </button>
        </form>
      </div>
    </main>
  </div>

  <script>feather.replace()</script>
</body>
</html>

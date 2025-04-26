<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Admin – Dashboard | ScanBrew Café</title>
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
      @php $r = request()->route()->getName(); @endphp

      <a href="{{ route('admin.dashboard') }}"
         class="flex items-center px-4 py-2 rounded-lg {{ $r==='admin.dashboard' ? 'bg-yellow-500 text-white' : 'hover:bg-yellow-100 text-gray-700' }}">
        <i data-feather="home" class="w-5 h-5 mr-3 {{ $r==='admin.dashboard' ? 'text-white' : 'text-yellow-500' }}"></i> Dashboard
      </a>
      <a href="{{ route('admin.meja.index') }}"
         class="flex items-center px-4 py-2 rounded-lg {{ Str::startsWith($r, 'admin.meja') ? 'bg-yellow-500 text-white' : 'hover:bg-yellow-100 text-gray-700' }}">
        <i data-feather="grid" class="w-5 h-5 mr-3 {{ Str::startsWith($r, 'admin.meja') ? 'text-white' : 'text-yellow-500' }}"></i> Meja
      </a>
      <a href="{{ route('admin.menu.index') }}"
         class="flex items-center px-4 py-2 rounded-lg {{ Str::startsWith($r, 'admin.menu') ? 'bg-yellow-500 text-white' : 'hover:bg-yellow-100 text-gray-700' }}">
        <i data-feather="book-open" class="w-5 h-5 mr-3 {{ Str::startsWith($r, 'admin.menu') ? 'text-white' : 'text-yellow-500' }}"></i> Menu
      </a>
      <a href="{{ route('admin.transaksi.index') }}"
         class="flex items-center px-4 py-2 rounded-lg {{ Str::startsWith($r, 'admin.transaksi') ? 'bg-yellow-500 text-white' : 'hover:bg-yellow-100 text-gray-700' }}">
        <i data-feather="clipboard" class="w-5 h-5 mr-3 {{ Str::startsWith($r, 'admin.transaksi') ? 'text-white' : 'text-yellow-500' }}"></i> Transaksi
      </a>
      <a href="{{ route('admin.user.index') }}"
         class="flex items-center px-4 py-2 rounded-lg {{ Str::startsWith($r, 'admin.user') ? 'bg-yellow-500 text-white' : 'hover:bg-yellow-100 text-gray-700' }}">
        <i data-feather="users" class="w-5 h-5 mr-3 {{ Str::startsWith($r, 'admin.user') ? 'text-white' : 'text-yellow-500' }}"></i> User
      </a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <!-- HEADER -->
    <header class="flex justify-between items-center px-8 py-5 bg-white border-b border-gray-200">
      <h1 class="text-2xl font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="home" class="text-yellow-500"></i> Dashboard
      </h1>
    </header>

    <!-- CONTENT: tanpa card -->
    <main class="flex-1 bg-gray-50 flex items-center justify-center">
      <h2 class="text-3xl font-bold text-gray-700">Selamat datang, Admin</h2>
    </main>
  </div>

  <script>feather.replace()</script>
</body>
</html>

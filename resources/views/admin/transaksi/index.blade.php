<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin – Data Transaksi | ScanBrew Café</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="flex h-screen bg-yellow-50 text-gray-800 font-sans">

 <!-- SIDEBAR -->
 <aside class="w-64 bg-white border-r border-grey-200 flex flex-col">
  <div class="p-6 flex items-center space-x-2 border-b border-grey-200">
    <img src="{{ asset('images/scanbrewcafe.png') }}" alt="Logo" class="w-10 h-10">
    <span class="text-xl font-bold text-yellow-600">ScanBrew Café</span>
  </div>
  <nav class="flex-1 px-4 py-6 space-y-2">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center px-4 py-2 rounded-lg hover:bg-yellow-100 text-gray-800">
      <i data-feather="home" class="w-5 h-5 mr-3 text-yellow-500"></i>
      Dashboard
    </a>
    <!-- Meja -->
    <a href="{{ route('admin.meja.index') }}"
       class="flex items-center px-4 py-2 rounded-lg 
              {{ request()->routeIs('admin.meja.*') ? 'bg-yellow-500 text-white font-semibold' : 'hover:bg-yellow-100 text-gray-800' }}">
      <i data-feather="grid" 
         class="w-5 h-5 mr-3 
                {{ request()->routeIs('admin.meja.*') ? 'text-white' : 'text-yellow-500' }}"></i> 
      Meja
    </a>
    <!-- Menu -->
    <a href="{{ route('admin.menu.index') }}"
       class="flex items-center px-4 py-2 rounded-lg 
              {{ request()->routeIs('admin.menu.*') ? 'bg-yellow-500 text-white font-semibold' : 'hover:bg-yellow-100 text-gray-800' }}">
      <i data-feather="book-open" 
         class="w-5 h-5 mr-3 
                {{ request()->routeIs('admin.menu.*') ? 'text-white' : 'text-yellow-500' }}"></i> 
      Menu
    </a>
    <!-- Transaksi -->
    <a href="{{ route('admin.transaksi.index') }}"
       class="flex items-center px-4 py-2 rounded-lg 
              {{ request()->routeIs('admin.transaksi.*') ? 'bg-yellow-500 text-white font-semibold' : 'hover:bg-yellow-100 text-gray-800' }}">
      <i data-feather="clipboard" 
         class="w-5 h-5 mr-3 
                {{ request()->routeIs('admin.transaksi.*') ? 'text-white' : 'text-yellow-500' }}"></i> 
      Transaksi
    </a>
    <!-- User -->
    <a href="{{ route('admin.user.index') }}"
       class="flex items-center px-4 py-2 rounded-lg 
              {{ request()->routeIs('admin.user.*') ? 'bg-yellow-500 text-white font-semibold' : 'hover:bg-yellow-100 text-gray-800' }}">
      <i data-feather="users" 
         class="w-5 h-5 mr-3 
                {{ request()->routeIs('admin.user.*') ? 'text-white' : 'text-yellow-500' }}"></i> 
      User
    </a>
  </nav>
</aside>
  
  <!-- MAIN CONTENT -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <!-- HEADER -->
    <header class="flex justify-between items-center px-8 py-5 bg-white border-b border-grey-200">
      <h1 class="text-2xl font-semibold text-black flex items-center gap-2">
        <i data-feather="clipboard" class="text-yellow-500"></i> Data Transaksi
      </h1>
    </header>

    <!-- CONTENT -->
    <main class="p-8 overflow-auto flex-1 bg-gray-50">
      @if(session('success'))
        <div class="mb-4 p-4 bg-yellow-100 border border-yellow-300 text-yellow-900 rounded-lg flex items-center space-x-2 shadow-sm">
          <i data-feather="check-circle" class="w-5 h-5 text-yellow-500"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-yellow-100">
        <table class="min-w-full text-sm divide-y divide-yellow-100">
          <thead class="bg-yellow-500 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="px-6 py-4 text-left">ID</th>
              <th class="px-6 py-4 text-left">Kode Pembayaran</th>
              <th class="px-6 py-4 text-left">Meja</th>
              <th class="px-6 py-4 text-left">Total</th>
              <th class="px-6 py-4 text-left">Status</th>
              <th class="px-6 py-4 text-left">Tanggal</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-yellow-50">
            @forelse($transaksi as $item)
            <tr class="odd:bg-white even:bg-yellow-50 hover:bg-yellow-100 transition">
              <td class="px-6 py-4">{{ $item->id }}</td>
              <td class="px-6 py-4">{{ $item->kode_pembayaran }}</td>
              <td class="px-6 py-4">{{ $item->order->meja->nomor ?? '-' }}</td>
              <td class="px-6 py-4">Rp {{ number_format($item->order->total(), 0, ',', '.') }}</td>
              <td class="px-6 py-4">{{ ucfirst($item->status) }}</td>
              <td class="px-6 py-4">{{ $item->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi</td>
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

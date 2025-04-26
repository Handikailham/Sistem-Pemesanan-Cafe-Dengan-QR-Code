<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin – Data User | ScanBrew Café</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="flex h-screen bg-yellow-50 text-gray-800 font-sans">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-white border-r border-grey-500 flex flex-col">
    <div class="p-6 flex items-center space-x-2 border-b border-grey-500">
      <img src="{{ asset('images/scanbrewcafe.png') }}" alt="Logo" class="w-10 h-10">
      <span class="text-xl font-bold text-yellow-500">ScanBrew Café</span>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
      <!-- Dashboard -->
      <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="home" class="w-5 h-5 mr-3 text-yellow-500"></i> Dashboard
      </a>
      <!-- Meja -->
      <a href="{{ route('admin.meja.index') }}" class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="grid" class="w-5 h-5 mr-3 text-yellow-500"></i> Meja
      </a>
      <!-- Menu -->
      <a href="{{ route('admin.menu.index') }}" class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="book-open" class="w-5 h-5 mr-3 text-yellow-500"></i> Menu
      </a>
      <!-- Transaksi -->
      <a href="{{ route('admin.transaksi.index') }}" class="flex items-center px-4 py-2 hover:bg-yellow-100 rounded-lg">
        <i data-feather="clipboard" class="w-5 h-5 mr-3 text-yellow-500"></i> Transaksi
      </a>
      <!-- User -->
      <a href="{{ route('admin.user.index') }}" class="flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg font-medium">
        <i data-feather="users" class="w-5 h-5 mr-3"></i> User
      </a>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <!-- HEADER -->
    <header class="flex justify-between items-center px-8 py-5 bg-white border-b border-grey-500">
      <h1 class="text-2xl font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="users" class="text-yellow-500"></i> Data User
      </h1>
      <a href="{{ route('admin.user.create') }}"
         class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 transition">
        <span class="text-xl">＋</span>
        <span>Tambah User</span>
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

      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full text-sm divide-y divide-gray-100">
          <thead class="bg-yellow-500 text-white uppercase text-xs tracking-wider">
            <tr>
              <th class="px-6 py-4 text-left">#</th>
              <th class="px-6 py-4 text-left">Nama</th>
              <th class="px-6 py-4 text-left">Email</th>
              <th class="px-6 py-4 text-left">Role</th>
              <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 bg-white">
            @foreach ($users as $u)
              <tr class="hover:bg-yellow-50 transition">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-semibold text-gray-700">{{ $u->name }}</td>
                <td class="px-6 py-4">{{ $u->email }}</td>
                <td class="px-6 py-4">{{ ucfirst($u->role) }}</td>
                <td class="px-6 py-4 text-center">
                  <div class="flex justify-center gap-2">
                    <a href="{{ route('admin.user.edit', $u->id) }}"
                       class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition"
                       title="Edit">
                      <i data-feather="edit" class="w-4 h-4"></i>
                    </a>
                    <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus user ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition"
                              title="Hapus">
                        <i data-feather="trash-2" class="w-4 h-4"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <script>feather.replace()</script>
</body>
</html>

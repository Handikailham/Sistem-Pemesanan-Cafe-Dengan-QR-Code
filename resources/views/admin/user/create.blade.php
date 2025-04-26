<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah User | ScanBrew Café</title>
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
    <header class="flex justify-between items-center px-8 py-5 bg-white border-b border-grey-200">
      <h1 class="text-2xl font-semibold text-gray-700 flex items-center gap-2">
        <i data-feather="users" class="text-yellow-500"></i> Tambah User
      </h1>
      <a href="{{ route('admin.user.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow hover:bg-yellow-600 transition">
        <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
      </a>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
      <div class="max-w-4xl mx-auto p-8 bg-white rounded-2xl shadow border border-yellow-100">
        <h2 class="text-2xl font-bold text-yellow-500 mb-6 flex items-center gap-2">
          <i data-feather="plus" class="w-6 h-6 text-yellow-500"></i> Form Tambah User
        </h2>

        <!-- Form -->
        <form action="{{ route('admin.user.store') }}" method="POST">
          @csrf

          <div class="grid grid-cols-2 gap-6">
            <!-- Nama User -->
            <div class="flex flex-col">
              <label for="name" class="text-sm font-medium text-gray-700">Nama Lengkap</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="user" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none" />
              </div>
              @error('name')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Email -->
            <div class="flex flex-col">
              <label for="email" class="text-sm font-medium text-gray-700">Email</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="mail" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none" />
              </div>
              @error('email')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6 mt-6">
            <!-- Role -->
            <div class="flex flex-col">
              <label for="role" class="text-sm font-medium text-gray-700">Role</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="shield" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <select name="role" id="role" required class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none bg-white">
                  <option value="">-- Pilih Role --</option>
                  <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                  <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                  <option value="dapur" {{ old('role') == 'dapur' ? 'selected' : '' }}>Dapur</option>
                </select>
              </div>
              @error('role')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col">
              <label for="password" class="text-sm font-medium text-gray-700">Password</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="lock" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <input type="password" name="password" id="password" required class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none" />
              </div>
              @error('password')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6 mt-6">
            <!-- Confirm Password -->
            <div class="flex flex-col">
              <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
              <div class="flex items-center border border-yellow-200 rounded-xl mt-2 focus-within:ring-2 focus-within:ring-yellow-400">
                <i data-feather="lock" class="w-5 h-5 text-yellow-500 ml-3"></i>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-3 border-0 rounded-xl focus:outline-none" />
              </div>
              @error('password_confirmation')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Tombol Simpan -->
          <div class="flex justify-center mt-8">
            <button type="submit" class="w-full py-3 bg-yellow-500 text-white text-lg rounded-xl font-semibold hover:bg-yellow-600 transition">
              Simpan User
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>

  <script>feather.replace()</script>
</body>
</html>

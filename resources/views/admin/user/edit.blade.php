<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User | ScanBrew Café</title>

  <!-- Tailwind CSS & Feather Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="flex h-screen bg-gray-50">

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
      <i data-feather="users" class="text-yellow-600"></i> Edit User: {{ $user->name }}
    </h1>
    <a href="{{ route('admin.user.index') }}"
       class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-600 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 transition">
      <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
    </a>
  </header>

  <!-- CONTENT -->
  <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
    <div class="max-w-3xl mx-auto p-8 bg-yellow-50 rounded-2xl shadow-lg shadow-yellow-200 border border-yellow-300">
      <h2 class="text-3xl font-bold text-yellow-600 mb-8 text-center flex items-center justify-center gap-2">
        <i data-feather="edit" class="w-6 h-6 text-yellow-600"></i> Edit User
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

      <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <!-- Nama -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i data-feather="user" class="w-5 h-5 text-yellow-500"></i>
              </span>
              <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                     class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
            </div>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i data-feather="mail" class="w-5 h-5 text-yellow-500"></i>
              </span>
              <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                     class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <!-- Role -->
          <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i data-feather="shield" class="w-5 h-5 text-yellow-500"></i>
              </span>
              <select name="role" id="role" required
                      class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kasir" {{ $user->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="dapur" {{ $user->role === 'dapur' ? 'selected' : '' }}>Dapur</option>
              </select>
            </div>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru (opsional)</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i data-feather="lock" class="w-5 h-5 text-yellow-500"></i>
              </span>
              <input type="password" name="password" id="password"
                     class="pl-10 pr-4 py-3 w-full bg-yellow-50 border border-yellow-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
            </div>
            <small class="text-gray-500">Kosongkan jika tidak ingin mengganti.</small>
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

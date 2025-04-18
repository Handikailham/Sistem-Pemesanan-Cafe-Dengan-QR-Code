{{-- resources/views/admin/menu/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu — {{ $menu->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Tailwind (atau CSS lain) --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Edit Menu: {{ $menu->nama }}</h1>

        {{-- Tampilkan pesan sukses / error --}}
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

        <form action="{{ route('admin.menu.update', $menu->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="nama" class="block font-medium">Nama Menu</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama', $menu->nama) }}"
                    class="mt-1 block w-full border-gray-300 rounded"
                    required>
            </div>

            {{-- Harga --}}
            <div>
                <label for="harga" class="block font-medium">Harga (Rp)</label>
                <input
                    type="number"
                    id="harga"
                    name="harga"
                    value="{{ old('harga', $menu->harga) }}"
                    class="mt-1 block w-full border-gray-300 rounded"
                    min="0"
                    required>
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori" class="block font-medium">Kategori</label>
                <input
                    type="text"
                    id="kategori"
                    name="kategori"
                    value="{{ old('kategori', $menu->kategori) }}"
                    class="mt-1 block w-full border-gray-300 rounded"
                    required>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block font-medium">Deskripsi</label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    class="mt-1 block w-full border-gray-300 rounded"
                    rows="4">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block font-medium">Gambar saat ini</label>
                @if($menu->gambar)
                    <img
                        src="{{ asset('menu/'.$menu->gambar) }}"
                        alt="Gambar {{ $menu->nama }}"
                        class="mb-2 w-32 h-32 object-cover rounded">
                @else
                    <p class="text-gray-500 italic">Belum ada gambar</p>
                @endif
            </div>
            <div>
                <label for="gambar" class="block font-medium">Upload Gambar Baru (opsional)</label>
                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept=".jpg,.jpeg,.png"
                    class="mt-1 block w-full">
                <p class="text-sm text-gray-500">Maks: 2MB. Format: JPG, JPEG, PNG.</p>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex items-center space-x-4">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
                <a
                    href="{{ route('admin.menu.index') }}"
                    class="text-gray-600 hover:underline">
                    &larr; Kembali ke Daftar Menu
                </a>
            </div>
        </form>
    </div>
</body>
</html>

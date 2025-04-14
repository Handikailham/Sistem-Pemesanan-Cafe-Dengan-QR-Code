
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Tambah Menu</h1>

    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Menu</label>
            <input type="text" name="nama" id="nama" required class="mt-1 block w-full border border-gray-300 p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" name="harga" id="harga" required class="mt-1 block w-full border border-gray-300 p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="mt-1 block w-full border border-gray-300 p-2 rounded"></textarea>
        </div>
        

        <div class="mb-4">
            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
            <input type="text" name="kategori" id="kategori" required class="mt-1 block w-full border border-gray-300 p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar (opsional)</label>
            <input type="file" name="gambar" id="gambar" class="mt-1 block w-full">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Simpan
        </button>
    </form>
</div>



<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Tambah Meja</h1>
    
    <form action="{{ route('admin.meja.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nomor" class="block text-sm font-medium text-gray-700">Nomor Meja</label>
            <input type="text" name="nomor" id="nomor" required class="mt-1 block w-full border border-gray-300 p-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan
        </button>
    </form>
</div>

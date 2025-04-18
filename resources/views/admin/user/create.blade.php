<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Tambah User</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium">Nama</label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name') }}"
                   required
                   class="mt-1 block w-full border-gray-300 rounded"/>
        </div>

        <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="email"
                   name="email"
                   id="email"
                   value="{{ old('email') }}"
                   required
                   class="mt-1 block w-full border-gray-300 rounded"/>
        </div>

        <label for="role">Role</label><br>
<select name="role" id="role" required>
    <option value="">-- Pilih Role --</option>
    <option value="admin">Admin</option>
    <option value="kasir">Kasir</option>
    <option value="dapur">Dapur</option>
</select>
<br><br>


        <div>
            <label for="password" class="block font-medium">Password</label>
            <input type="password"
                   name="password"
                   id="password"
                   required
                   class="mt-1 block w-full border-gray-300 rounded"/>
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium">Konfirmasi Password</label>
            <input type="password"
                   name="password_confirmation"
                   id="password_confirmation"
                   required
                   class="mt-1 block w-full border-gray-300 rounded"/>
        </div>

        <div class="flex items-center space-x-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan
            </button>
            <a href="{{ route('admin.user.index') }}" class="text-gray-600 hover:underline">
                &larr; Kembali
            </a>
        </div>
    </form>
</div>
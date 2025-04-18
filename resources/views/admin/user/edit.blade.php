<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Edit User: {{ $user->name }}</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-medium">Nama</label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name', $user->name) }}"
                   required
                   class="mt-1 block w-full border-gray-300 rounded"/>
        </div>

        <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="email"
                   name="email"
                   id="email"
                   value="{{ old('email', $user->email) }}"
                   required
                   class="mt-1 block w-full border-gray-300 rounded"/>
        </div>

        <div>
            <label for="role">Role</label><br>
<select name="role" id="role" required>
    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
    <option value="kasir" {{ $user->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
    <option value="pelayan" {{ $user->role === 'dapur' ? 'selected' : '' }}>Dapur</option>
</select>
<br><br>

        </div>

        <div>
            <label for="password" class="block font-medium">Password Baru (opsional)</label>
            <input type="password"
                   name="password"
                   id="password"
                   class="mt-1 block w-full border-gray-300 rounded"/>
            <small class="text-gray-500">Kosongkan jika tidak ingin mengganti.</small>
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium">Konfirmasi Password</label>
            <input type="password"
                   name="password_confirmation"
                   id="password_confirmation"
                   class="mt-1 block w-full border-gray-300 rounded"/>
        </div>

        <div class="flex items-center space-x-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('admin.user.index') }}" class="text-gray-600 hover:underline">
                &larr; Batal
            </a>
        </div>
    </form>
</div>
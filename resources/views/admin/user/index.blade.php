
<h1 class="text-2xl mb-4">Daftar User</h1>
<a href="{{ route('admin.user.create') }}" class="btn btn-blue mb-4">Tambah User</a>
<table class="table-auto w-full">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th> <!-- Tambahan -->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $u)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ ucfirst($u->role) }}</td> <!-- Tampilkan Role -->
                <td>
                    <!-- Tombol edit dan hapus tetap -->
                    <a href="{{ route('admin.user.edit', $u->id) }}">Edit</a> |
                    <form action="{{ route('admin.user.destroy', $u->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus user ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    
</table>